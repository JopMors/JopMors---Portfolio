/**
 * Floating navigation: nearly clear at the top, glass once scrolling starts,
 * hides while scrolling down, highlights the section in view.
 */
import { scrollToTarget } from "./lib/scroll.js";

const COMPACT_AFTER = 40;
const REVEAL_DELTA = 6;

export function initNav(header) {
  const bar = header.querySelector("[data-nav-bar]");
  const list = header.querySelector("[data-nav-list]");
  const pill = header.querySelector("[data-nav-pill]");
  const links = [...header.querySelectorAll("[data-nav-link]")];
  const toggle = header.querySelector("[data-nav-toggle]");
  const sheet = header.querySelector("[data-nav-sheet]");
  const iconOpen = header.querySelector("[data-nav-icon-open]");
  const iconClose = header.querySelector("[data-nav-icon-close]");

  let open = false;
  let visible = true;
  let lastY = window.scrollY;

  const updateBar = () => {
    const y = window.scrollY;
    const delta = y - lastY;
    if (Math.abs(delta) > REVEAL_DELTA) {
      visible = delta < 0 || y < COMPACT_AFTER * 4;
      lastY = y;
    }
    bar.classList.toggle("lg-clear", !(y > COMPACT_AFTER || open));
    header.classList.toggle("is-hidden", !(visible || open));
  };

  const setOpen = (next) => {
    open = next;
    toggle.setAttribute("aria-expanded", String(open));
    sheet.classList.toggle("is-open", open);
    iconOpen.classList.toggle("hidden", open);
    iconClose.classList.toggle("hidden", !open);
    updateBar();
  };

  // Every [data-scroll-to] on the page scrolls smoothly to its section.
  document.querySelectorAll("[data-scroll-to]").forEach((button) =>
    button.addEventListener("click", () => {
      setOpen(false);
      scrollToTarget(button.dataset.scrollTo);
    })
  );
  toggle.addEventListener("click", () => setOpen(!open));
  sheet.querySelectorAll("a").forEach((link) => link.addEventListener("click", () => setOpen(false)));
  window.addEventListener("scroll", updateBar, { passive: true });
  updateBar();
  requestAnimationFrame(() => header.classList.add("is-ready"));

  // Active section highlight.
  const setActive = (id) => {
    links.forEach((link) => link.classList.toggle("opacity-60", link.dataset.navLink !== id));
    const link = list.querySelector(`[data-nav-link="${id}"]`);
    if (!link) return;
    pill.style.width = `${link.offsetWidth}px`;
    pill.style.height = `${link.offsetHeight}px`;
    pill.style.transform = `translate(${link.offsetLeft}px, ${link.offsetTop}px)`;
    pill.style.opacity = "1";
  };

  // On a sub-page (e.g. a project page) the current item is fixed.
  if (header.dataset.navCurrent) {
    setActive(header.dataset.navCurrent);
    window.addEventListener("resize", () => setActive(header.dataset.navCurrent));
    return;
  }

  const ids = [...new Set(links.map((l) => l.dataset.navLink))];
  const sections = ids.map((id) => document.getElementById(id)).filter(Boolean);
  const observer = new IntersectionObserver(
    (entries) => {
      const best = entries
        .filter((e) => e.isIntersecting)
        .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
      if (best) setActive(best.target.id);
    },
    { rootMargin: "-45% 0px -45% 0px", threshold: [0, 0.25, 0.5, 1] }
  );
  sections.forEach((s) => observer.observe(s));
  setActive(ids[0]);
  window.addEventListener("resize", () => {
    const active = links.find((l) => !l.classList.contains("opacity-60"));
    if (active) setActive(active.dataset.navLink);
  });
}
