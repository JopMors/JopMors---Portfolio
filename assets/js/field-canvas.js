/**
 * A slow, procedural "instrument readout" drawn on a canvas — ridge lines,
 * contour rings or a small neural network. Animates only while near the viewport; one still frame for
 * reduced motion.
 */
import { prefersReducedMotion } from "./lib/scroll.js";

const MAX_DPR = 2;
const RIDGE_STEP_PX = 6;
const RING_SEGMENTS = 180;
const RING_COUNT = 22;
/** Nodes per layer of the network drawing, input → output. */
const NETWORK_LAYERS = [4, 6, 7, 6, 3];
/** Share of connections that carry a travelling signal. */
const SIGNAL_SHARE = 0.16;

/** Cheap, smooth pseudo-noise from layered sines — deterministic per seed. */
function wave(x, t, seed) {
  return (
    Math.sin(x * 1.7 + t * 0.9 + seed) * 0.5 +
    Math.sin(x * 3.1 - t * 0.6 + seed * 2.3) * 0.3 +
    Math.sin(x * 7.3 + t * 1.3 + seed * 0.7) * 0.2
  );
}

function drawRidges(ctx, w, h, t, seed) {
  const lines = Math.max(Math.round(h / 14), 2);
  const margin = h * 0.12;
  const span = h - margin * 2;
  for (let i = 0; i < lines; i++) {
    const baseY = margin + (span * i) / (lines - 1);
    ctx.beginPath();
    for (let x = 0; x <= w; x += RIDGE_STEP_PX) {
      const u = x / w;
      // Gaussian envelope: calm edges, energetic centre.
      const envelope = Math.exp(-Math.pow((u - 0.5) / 0.2, 2));
      const y = baseY - Math.abs(wave(u * 6 + i * 0.35, t, seed + i * 0.13)) * envelope * h * 0.09;
      if (x === 0) ctx.moveTo(x, y);
      else ctx.lineTo(x, y);
    }
    ctx.stroke();
  }
}

function drawRings(ctx, w, h, t, seed) {
  const cx = w * 0.5;
  const cy = h * 0.5;
  const maxR = Math.min(w, h) * 0.4;
  for (let i = 1; i <= RING_COUNT; i++) {
    const r = (maxR * i) / RING_COUNT;
    ctx.beginPath();
    for (let s = 0; s <= RING_SEGMENTS; s++) {
      const a = (s / RING_SEGMENTS) * Math.PI * 2;
      const rr = r + wave(Math.cos(a) * 1.4 + i * 0.12, t, seed + Math.sin(a)) * r * 0.08;
      const x = cx + Math.cos(a) * rr;
      const y = cy + Math.sin(a) * rr;
      if (s === 0) ctx.moveTo(x, y);
      else ctx.lineTo(x, y);
    }
    ctx.stroke();
  }
}

/** Deterministic 0–1 pseudo-random number for a pair of indices. */
function hash(a, b, seed) {
  const v = Math.sin(a * 12.9898 + b * 78.233 + seed * 37.719) * 43758.5453;
  return v - Math.floor(v);
}

/** Activation sweeping through the network from input to output, 0–1. */
function activation(layer, phase, t, seed) {
  return Math.pow(0.5 + 0.5 * Math.sin(t * 1.8 - layer * 1.1 + phase * Math.PI * 2 + seed), 3);
}

function drawNetwork(ctx, w, h, t, seed) {
  const maxCount = Math.max(...NETWORK_LAYERS);
  const marginX = w * 0.14;
  const spanY = h * 0.66;
  const radius = Math.max(Math.min(w, h) * 0.011, 3);

  // Node positions: layers spread across, each centred vertically, drifting gently.
  const layers = NETWORK_LAYERS.map((count, li) => {
    const x = marginX + ((w - marginX * 2) * li) / (NETWORK_LAYERS.length - 1);
    const height = (spanY * (count - 1)) / (maxCount - 1);
    return Array.from({ length: count }, (_, ni) => ({
      x: x + wave(li * 1.3 + ni * 0.7, t * 0.6, seed) * w * 0.008,
      y: h / 2 - height / 2 + (count > 1 ? (height * ni) / (count - 1) : 0) + wave(ni * 1.1 + li * 0.5, t * 0.5, seed + 3) * h * 0.012,
      glow: activation(li, hash(li, ni, seed), t, seed),
    }));
  });

  // Connections, brightening as activation passes; a few carry a signal dot.
  for (let li = 0; li < layers.length - 1; li++) {
    for (const [ai, a] of layers[li].entries()) {
      for (const [bi, b] of layers[li + 1].entries()) {
        const h1 = hash(li * 10 + ai, bi, seed);
        ctx.globalAlpha = 0.16 + 0.7 * activation(li, h1, t, seed);
        ctx.beginPath();
        ctx.moveTo(a.x, a.y);
        ctx.lineTo(b.x, b.y);
        ctx.stroke();

        if (h1 < SIGNAL_SHARE) {
          const f = (t * 0.35 + h1 * 7 - li * 0.25) % 1;
          const p = f < 0 ? f + 1 : f;
          ctx.globalAlpha = Math.sin(p * Math.PI) * 0.95;
          ctx.beginPath();
          ctx.arc(a.x + (b.x - a.x) * p, a.y + (b.y - a.y) * p, 1.6, 0, Math.PI * 2);
          ctx.fill();
        }
      }
    }
  }

  // Nodes: hollow rings (lines behind them are cleared), centres lit by activation.
  for (const layer of layers) {
    for (const node of layer) {
      ctx.globalAlpha = 1;
      ctx.globalCompositeOperation = "destination-out";
      ctx.beginPath();
      ctx.arc(node.x, node.y, radius + 1, 0, Math.PI * 2);
      ctx.fill();
      ctx.globalCompositeOperation = "source-over";
      ctx.beginPath();
      ctx.arc(node.x, node.y, radius, 0, Math.PI * 2);
      ctx.stroke();
      ctx.globalAlpha = 0.2 + 0.8 * node.glow;
      ctx.beginPath();
      ctx.arc(node.x, node.y, radius * 0.45, 0, Math.PI * 2);
      ctx.fill();
    }
  }
  ctx.globalAlpha = 1;
}

const DRAW = { ridges: drawRidges, rings: drawRings, network: drawNetwork };

export class FieldCanvas {
  constructor(canvas, { color, speed = 0.18 }) {
    this.canvas = canvas;
    this.ctx = canvas.getContext("2d");
    this.color = color;
    this.speed = speed;
    this.variant = "ridges";
    this.seed = 1;
    this.running = false;
    this.frame = 0;

    new ResizeObserver(() => {
      this.resize();
      this.render(performance.now());
    }).observe(canvas);

    new IntersectionObserver(
      ([entry]) => (entry.isIntersecting ? this.start() : this.stop()),
      { rootMargin: "200px" }
    ).observe(canvas);
  }

  set(variant, seed, color = this.color) {
    this.variant = variant;
    this.seed = seed;
    this.color = color;
    this.render(this.running ? performance.now() : seed * 1000);
  }

  resize() {
    const dpr = Math.min(window.devicePixelRatio || 1, MAX_DPR);
    this.canvas.width = this.canvas.clientWidth * dpr;
    this.canvas.height = this.canvas.clientHeight * dpr;
    this.ctx.setTransform(dpr, 0, 0, dpr, 0, 0);
  }

  render(time) {
    const { ctx, canvas } = this;
    const w = canvas.clientWidth;
    const h = canvas.clientHeight;
    ctx.clearRect(0, 0, w, h);
    ctx.strokeStyle = this.color;
    ctx.fillStyle = this.color;
    ctx.lineWidth = 1;
    (DRAW[this.variant] ?? drawRidges)(ctx, w, h, (time / 1000) * this.speed, this.seed);
  }

  start() {
    if (this.running || prefersReducedMotion()) return;
    this.running = true;
    const loop = (time) => {
      this.render(time);
      this.frame = requestAnimationFrame(loop);
    };
    this.frame = requestAnimationFrame(loop);
  }

  stop() {
    this.running = false;
    cancelAnimationFrame(this.frame);
  }
}
