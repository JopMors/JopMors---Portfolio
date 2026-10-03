/**
 * The entrance: one continuous push-in from the whole photograph to the
 * MacBook display filling the viewport. The lid/display are HTML laid over the
 * photo (so the code stays sharp); once the display fills the view it
 * "lights up" into the page background.
 */
import { clamp, clamp01, follow, onFrame, ramp, scrollProgress } from "./lib/scroll.js";

/* Scene geometry, in image pixels (must match includes/hero.php). */
const IMAGE = { w: 2048, h: 1152 };
const LID = { x: 654, y: 521 };
const DISPLAY = { x: 663, y: 537, w: 360, h: 230 };
/** Where the editor's code column starts, as a fraction of the display width. */
const CODE_COLUMN_START = 0.19;

/* Timeline, as scroll progress through the section (0 → 1). */
const ZOOM_END = 0.84;
const TITLE_OUT = [0, 0.08];
const HINT_OUT = [0, 0.03];
const TYPING = [0.02, 0.74];
/** Code is already partly written when the scene opens. */
const TYPED_AT_START = 0.42;
const DEPTH_OF_FIELD = [0.22, 0.66];
const GRADE_OUT = [0.55, 0.8];
const LIGHT_UP = [0.86, 0.97];
const BEAT_FADE = 0.04;
/** How quickly the camera catches up with the scroll position (higher = snappier). */
const CAMERA_FOLLOW_RATE = 4;

const easeInOutCubic = (t) => (t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2);

function cameraAt(progress, vp) {
  const portrait = vp.h > vp.w;
  const s0 = Math.max(vp.w / IMAGE.w, vp.h / IMAGE.h);
  const sEnd = Math.max(vp.w / DISPLAY.w, vp.h / DISPLAY.h);

  // On portrait screens only a slice of the display fits at the end, so land
  // on the start of the code column instead of the display's centre.
  const visibleFraction = Math.min(vp.w / (DISPLAY.w * sEnd), 1);
  const landing = portrait
    ? clamp(CODE_COLUMN_START + visibleFraction / 2, visibleFraction / 2, 0.5)
    : 0.5;
  const cx = DISPLAY.x + DISPLAY.w * landing;
  const cy = DISPLAY.y + DISPLAY.h / 2;

  // Portrait screens start cropped around the laptop instead of the image centre.
  const halfW = vp.w / (2 * s0);
  const focusX = clamp(portrait ? cx : IMAGE.w / 2, halfW, IMAGE.w - halfW);
  const startX = (cx - focusX) * s0 + vp.w / 2;
  const startY = (cy - IMAGE.h / 2) * s0 + vp.h / 2;

  const e = easeInOutCubic(clamp01(progress / ZOOM_END));
  const s = s0 * Math.pow(sEnd / s0, e);
  const px = startX + (vp.w / 2 - startX) * e;
  const py = startY + (vp.h / 2 - startY) * e;

  return {
    s,
    tx: clamp(px - cx * s, vp.w - IMAGE.w * s, 0),
    ty: clamp(py - cy * s, vp.h - IMAGE.h * s, 0),
  };
}

/** Fades in over BEAT_FADE after `start`, out over BEAT_FADE before `end`. */
function beatOpacity(p, [start, end]) {
  if (p <= start || p >= end) return 0;
  return Math.min((p - start) / BEAT_FADE, (end - p) / BEAT_FADE, 1);
}

/** Reveals the editor's code character by character. */
function createTyping(section) {
  const tokens = [...section.querySelectorAll("[data-token]")].map((el) => ({
    el,
    text: el.textContent,
    line: el.closest("[data-line-content]"),
  }));
  const caret = section.querySelector("[data-caret]");
  const total = tokens.reduce((n, t) => n + t.text.length, 0);
  let typed = -1;

  return (fraction) => {
    const next = Math.round(clamp01(fraction) * total);
    if (next === typed) return;
    typed = next;
    let offset = 0;
    let lastVisible = tokens[0];
    for (const token of tokens) {
      const shown = clamp(next - offset, 0, token.text.length);
      offset += token.text.length;
      token.el.textContent = token.text.slice(0, shown);
      if (shown > 0) lastVisible = token;
    }
    lastVisible.line.appendChild(caret);
  };
}

export function initHero(section) {
  const q = (selector) => section.querySelector(selector);
  const stage = q("[data-hero-stage]");
  const photo = q("[data-hero-photo]");
  const lid = q("[data-hero-lid]");
  const blur = q("[data-hero-blur]");
  const grade = q("[data-hero-grade]");
  const title = q("[data-hero-title]");
  const hint = q("[data-hero-hint]");
  const lightUp = q("[data-hero-lightup]");
  const beats = [...section.querySelectorAll("[data-hero-beat]")].map((el) => ({
    el,
    at: el.dataset.heroBeat.split(",").map(Number),
  }));
  const type = createTyping(section);

  const offsets = ["start start", "end end"];
  let vp = { w: stage.clientWidth, h: stage.clientHeight };
  let current = scrollProgress(section, offsets);
  let rendered = -1;

  const render = (p, force = false) => {
    if (!force && Math.abs(p - rendered) < 0.00005) return;
    rendered = p;

    const { tx, ty, s } = cameraAt(p, vp);
    photo.style.transform = `translate3d(${tx}px, ${ty}px, 0) scale(${s})`;
    lid.style.transform = `translate3d(${tx + LID.x * s}px, ${ty + LID.y * s}px, 0) scale(${s})`;
    blur.style.opacity = String(ramp(p, DEPTH_OF_FIELD) * 0.9);
    grade.style.opacity = String(1 - ramp(p, GRADE_OUT));
    lightUp.style.opacity = String(ramp(p, LIGHT_UP));

    const t = ramp(p, TITLE_OUT);
    title.style.opacity = String(1 - t);
    title.style.transform = `translateY(${-48 * t}px)`;
    title.style.filter = `blur(${10 * t}px)`;
    if (hint) hint.style.opacity = String(1 - ramp(p, HINT_OUT));

    for (const beat of beats) {
      beat.el.style.opacity = String(beatOpacity(p, beat.at));
      beat.el.style.transform = `translateY(${20 - 40 * ramp(p, beat.at)}px)`;
    }

    type(TYPED_AT_START + (1 - TYPED_AT_START) * ramp(p, TYPING));
    stage.style.visibility = "visible";
  };

  new ResizeObserver(() => {
    vp = { w: stage.clientWidth, h: stage.clientHeight };
    render(current, true);
  }).observe(stage);

  render(current, true);
  onFrame((dt) => {
    current = follow(current, scrollProgress(section, offsets), dt, CAMERA_FOLLOW_RATE);
    render(current);
  });
}
