/**
 * Smooth scrolling (Lenis) and one shared animation loop. Effects register
 * with onFrame(); scrollProgress() mirrors Framer Motion's scroll offsets.
 */
import Lenis from "../vendor/lenis.mjs";

export const EASE = "cubic-bezier(0.22, 1, 0.36, 1)";

export const clamp = (v, lo, hi) => Math.min(Math.max(v, lo), hi);
export const clamp01 = (v) => clamp(v, 0, 1);
/** Where `v` sits between a and b, as 0 → 1. */
export const ramp = (v, [a, b]) => clamp01((v - a) / (b - a));
export const lerp = (a, b, t) => a + (b - a) * t;

/** Frame-rate independent easing of `current` towards `target`. */
export function follow(current, target, dt, rate) {
  const next = current + (target - current) * (1 - Math.exp(-rate * dt));
  return Math.abs(target - next) < 0.0001 ? target : next;
}

const frameCallbacks = new Set();
let lenis = null;

export const prefersReducedMotion = () => window.matchMedia("(prefers-reduced-motion: reduce)").matches;

export function startScroll() {
  lenis = new Lenis({ lerp: 0.085, smoothWheel: !prefersReducedMotion() });
  let last = performance.now();
  const loop = (time) => {
    lenis.raf(time);
    const dt = Math.min((time - last) / 1000, 0.1);
    last = time;
    frameCallbacks.forEach((cb) => cb(dt));
    requestAnimationFrame(loop);
  };
  requestAnimationFrame(loop);
}

/** Run `cb(dt)` every animation frame. */
export function onFrame(cb) {
  frameCallbacks.add(cb);
}

/** Scroll to a section id ("top" for the page start). */
export function scrollToTarget(id) {
  if (id === "top") {
    if (lenis) lenis.scrollTo(0, { duration: 1.6 });
    else window.scrollTo({ top: 0, behavior: "smooth" });
    return;
  }
  const el = document.getElementById(id);
  if (!el) return;
  if (lenis) lenis.scrollTo(el, { offset: -24, duration: 1.4 });
  else el.scrollIntoView({ behavior: "smooth" });
}

const EDGES = { start: 0, center: 0.5, end: 1 };
const parseOffset = (offset) => offset.split(" ").map((part) => EDGES[part] ?? Number(part));

/**
 * 0 → 1 progress of `el` through the viewport, using Framer-style offsets:
 * ["start end", "start start"] = from the element's top meeting the viewport
 * bottom, to the element's top meeting the viewport top.
 */
export function scrollProgress(el, [from, to]) {
  const rect = el.getBoundingClientRect();
  const top = rect.top + window.scrollY;
  const vh = window.innerHeight;
  const [fromTarget, fromView] = parseOffset(from);
  const [toTarget, toView] = parseOffset(to);
  const y0 = top + fromTarget * rect.height - fromView * vh;
  const y1 = top + toTarget * rect.height - toView * vh;
  return clamp01((window.scrollY - y0) / (y1 - y0 || 1));
}

/** Calls `apply(progress)` whenever the element's scroll progress changes. */
export function scrollEffect(el, offsets, apply) {
  let last = -1;
  const update = () => {
    const p = scrollProgress(el, offsets);
    if (Math.abs(p - last) < 0.0001) return;
    last = p;
    apply(p);
  };
  update();
  onFrame(update);
}
