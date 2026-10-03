/** Starts every behaviour on the page. */
import { startScroll } from "./lib/scroll.js";
import { initHero } from "./hero.js";
import { initNav } from "./nav.js";
import {
  initContactPhoto,
  initLaunchPanel,
  initParallaxPhoto,
  initScaleIn,
  initScrollWords,
  initSpine,
} from "./effects.js";
import { initExpanders, initReveal } from "./ui.js";
import { initWhatIDo } from "./what-i-do.js";
import { initDock } from "./dock.js";
import { initContactForm } from "./form.js";
import { initIpod } from "./ipod.js";

/** Must match the media attribute on phone.css in includes/head.php. */
const PHONE_QUERY = matchMedia("(max-width: 767.98px)");

const each = (selector, init) => document.querySelectorAll(selector).forEach(init);

// The phone layout is static where the desktop scrolls, so switching sides needs a fresh start.
PHONE_QUERY.addEventListener("change", () => location.reload());

startScroll();
each("[data-nav]", initNav);
if (!PHONE_QUERY.matches) {
  each("[data-hero]", initHero);
  each("[data-scroll-words]", initScrollWords);
  each("#practice", initWhatIDo);
}
each("[data-launch]", initLaunchPanel);
each("[data-scale-in]", initScaleIn);
each("[data-capabilities]", initParallaxPhoto);
each("[data-dock]", initDock);
each("[data-spine]", initSpine);
each("[data-contact]", initContactPhoto);
each("[data-contact-form]", initContactForm);
each("[data-ipod]", initIpod);
initReveal();
initExpanders();
