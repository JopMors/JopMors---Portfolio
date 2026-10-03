/** "What I do": the sticky drawing follows whichever step is in view. */
import { EASE, onFrame, prefersReducedMotion } from "./lib/scroll.js";
import { FieldCanvas } from "./field-canvas.js";

const FIELD_STROKE = "rgba(245,245,247,0.42)";
/** Opacity of a step's tinted line colour. */
const TINT_ALPHA = 0.5;
/** Each half of the swap: fade the old drawing out, then the new one in — never both at once. */
const FADE_MS = 550;

export function initWhatIDo(section) {
  const layer = section.querySelector("[data-field-layer]");
  const chapters = [...section.querySelectorAll("[data-capability]")];
  const field = new FieldCanvas(section.querySelector("[data-field-canvas]"), { color: FIELD_STROKE });
  const strokeFor = (chapter) => (chapter.dataset.tint ? `rgb(${chapter.dataset.tint} / ${TINT_ALPHA})` : FIELD_STROKE);
  const draw = (chapter) => field.set(chapter.dataset.variant, Number(chapter.dataset.seed), strokeFor(chapter));
  let active = null;
  let pendingSwap = 0;

  layer.style.transition = `opacity ${FADE_MS}ms ${EASE}`;

  const show = (chapter) => {
    if (chapter === active) return;
    active = chapter;
    clearTimeout(pendingSwap);
    if (prefersReducedMotion()) return draw(chapter);
    layer.style.opacity = "0";
    pendingSwap = setTimeout(() => {
      draw(chapter);
      layer.style.opacity = "1";
    }, FADE_MS);
  };

  // The active step is the last one whose top has passed the middle of the screen, worked out
  // from position every frame, so fast scrolls and arriving from below never leave a stale drawing.
  const current = () =>
    chapters.findLast((c) => c.getBoundingClientRect().top <= window.innerHeight / 2) ?? chapters[0];
  onFrame(() => show(current()));
  active = current();
  draw(active);
}
