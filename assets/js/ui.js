/** Small interface behaviours shared across sections. */
import { EASE } from "./lib/scroll.js";

/** Fade/slide elements with [data-reveal] in once they enter the viewport. */
export function initReveal() {
  const observer = new IntersectionObserver(
    (entries) => {
      for (const entry of entries) {
        if (!entry.isIntersecting) continue;
        entry.target.classList.add("is-revealed");
        observer.unobserve(entry.target);
      }
    },
    { rootMargin: "-10% 0px -10% 0px" }
  );
  document.querySelectorAll("[data-reveal]").forEach((el) => observer.observe(el));
}

/** "More / Less" toggles on the timeline cards. */
export function initExpanders() {
  document.querySelectorAll("[data-expand-toggle]").forEach((button) => {
    const card = button.closest("article");
    const panel = card.querySelector("[data-expand]");
    const label = button.querySelector("[data-expand-label]");
    const plus = button.querySelector("svg");

    button.addEventListener("click", () => {
      const open = button.getAttribute("aria-expanded") !== "true";
      button.setAttribute("aria-expanded", String(open));
      label.textContent = open ? "Less" : "More";
      plus.classList.toggle("rotate-45", open);
      animateHeight(panel, open);
    });
  });
}

function animateHeight(panel, open) {
  panel.hidden = false;
  const from = panel.getBoundingClientRect().height;
  const to = open ? panel.scrollHeight : 0;
  panel.dataset.target = open ? "open" : "closed";

  panel.style.transition = "none";
  panel.style.height = `${from}px`;
  void panel.offsetHeight; // apply the start height before animating
  panel.style.transition = `height 0.5s ${EASE}, opacity 0.5s ${EASE}`;
  panel.style.height = `${to}px`;
  panel.style.opacity = open ? "1" : "0";

  panel.addEventListener("transitionend", function done(e) {
    if (e.propertyName !== "height") return;
    panel.removeEventListener("transitionend", done);
    if (panel.dataset.target === "open") panel.style.height = "auto";
    else panel.hidden = true;
  });
}
