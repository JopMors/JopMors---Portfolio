/** Scroll-linked effects for the content sections. */
import { ramp, scrollEffect } from "./lib/scroll.js";

const DIM_WORD = 0.16;

/** The one-sentence statement: each word brightens as it scrolls through. */
export function initScrollWords(paragraph) {
  const words = [...paragraph.querySelectorAll("[data-word]")];
  const n = words.length;
  scrollEffect(paragraph, ["start 0.85", "end 0.45"], (p) => {
    words.forEach((word, i) => {
      word.style.opacity = (DIM_WORD + (1 - DIM_WORD) * ramp(p, [i / n, (i + 1) / n])).toFixed(3);
    });
  });
}

/** Project panels grow to full size (and square up) as they arrive. */
export function initLaunchPanel(article) {
  const panel = article.querySelector("[data-launch-panel]");
  scrollEffect(article, ["start end", "start start"], (p) => {
    article.style.transform = `scale(${0.9 + 0.1 * p})`;
    article.style.borderRadius = `${48 - 20 * p}px`;
    panel.style.transform = `translateY(${120 - 120 * p}px)`;
  });
}

/** A media frame (e.g. a project screenshot) that settles into place. */
export function initScaleIn(el) {
  scrollEffect(el, ["start end", "center center"], (p) => {
    el.style.transform = `scale(${0.92 + 0.08 * p})`;
    el.style.borderRadius = `${40 - 12 * p}px`;
  });
}

/** Capabilities photo: slow parallax + settle. */
export function initParallaxPhoto(section) {
  const photo = section.querySelector("[data-parallax-photo]");
  scrollEffect(section, ["start end", "end start"], (p) => {
    photo.style.transform = `translateY(${-6 + 12 * p}%) scale(${1.2 - 0.2 * p})`;
  });
}

/** The timeline spine draws itself while scrolling. */
export function initSpine(spine) {
  const fill = spine.querySelector("[data-spine-fill]");
  scrollEffect(spine, ["start 0.8", "end 0.55"], (p) => {
    fill.style.height = `${p * 100}%`;
  });
}

/** Contact: the workspace photo settles as the section scrolls in. */
export function initContactPhoto(section) {
  const photo = section.querySelector("[data-contact-photo]");
  scrollEffect(section, ["start end", "end end"], (p) => {
    photo.style.transform = `scale(${1.25 - 0.25 * p})`;
  });
}
