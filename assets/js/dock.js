/** macOS-style dock: icons grow as the pointer passes over them. */
import { clamp01, follow, lerp, onFrame } from "./lib/scroll.js";

const REST = 56;
const PEAK = 84;
const REACH = 150;
const GROW_RATE = 18;

export function initDock(dock) {
  const icons = [...dock.querySelectorAll("[data-dock-icon]")].map((el) => ({ el, size: REST }));
  let pointerX = Infinity;

  dock.addEventListener("mousemove", (e) => (pointerX = e.clientX));
  dock.addEventListener("mouseleave", () => (pointerX = Infinity));

  onFrame((dt) => {
    for (const icon of icons) {
      let target = REST;
      if (Number.isFinite(pointerX)) {
        const rect = icon.el.getBoundingClientRect();
        const distance = Math.abs(pointerX - rect.left - rect.width / 2);
        target = lerp(PEAK, REST, clamp01(distance / REACH));
      }
      if (icon.size === target) continue;
      icon.size = follow(icon.size, target, dt, GROW_RATE);
      icon.el.style.width = `${icon.size}px`;
      icon.el.style.height = `${icon.size}px`;
    }
  });
}
