/**
 * The Spindle iPod: tilts gently towards the pointer, its scrubber plays in
 * real time, and it can be used. Turn the click wheel by dragging around it
 * or scrolling over it (volume, or moving through the menu); press MENU, the
 * centre and the skip buttons; click the screen or the scrubber. Each wheel
 * step ticks. What the player does is in ipod-player.js.
 */
import { follow, onFrame, prefersReducedMotion } from "./lib/scroll.js";
import { createPlayer } from "./ipod-player.js";

const TILT_DEG = 9;
const TILT_RATE = 6;
const STEP_DEG = 18; // degrees of dragging around the wheel per click
const DRAG_START_DEG = 6; // less than this is a press, not a turn
const SCROLL_STEP_PX = 40; // scroll distance per click
const LINE_HEIGHT_PX = 16;
const TICK_HZ = 2400;
const TICK_GAIN = 0.035;
const TICK_SECONDS = 0.012;

export function initIpod(stage) {
  const player = createPlayer(stage);
  const wheel = stage.querySelector("[data-ipod-wheel]");
  const step = (direction) => {
    player.turn(direction);
    tick();
  };

  let timer = 0;
  new IntersectionObserver(([entry]) => {
    clearInterval(timer);
    if (entry.isIntersecting) timer = setInterval(player.tickClock, 1000);
  }).observe(stage);

  const interaction = { active: false };
  bindWheelTurning(wheel, step, interaction);
  bindWheelButtons(wheel, player, step, interaction);
  bindScreen(stage, player, interaction);
  if (!prefersReducedMotion()) bindTilt(stage, interaction);
}

/** Dragging around the ring and scrolling over it both turn the wheel. */
function bindWheelTurning(wheel, step, interaction) {
  let drag = null;
  const angleAt = (e) => {
    const rect = wheel.getBoundingClientRect();
    return (Math.atan2(e.clientY - rect.top - rect.height / 2, e.clientX - rect.left - rect.width / 2) * 180) / Math.PI;
  };

  wheel.addEventListener("pointerdown", (e) => {
    drag = { angle: angleAt(e), turned: 0, turning: false, id: e.pointerId };
    interaction.active = true;
  });
  wheel.addEventListener("pointermove", (e) => {
    if (!drag || e.pointerId !== drag.id) return;
    const angle = angleAt(e);
    drag.turned += ((angle - drag.angle + 540) % 360) - 180;
    drag.angle = angle;
    if (!drag.turning && Math.abs(drag.turned) < DRAG_START_DEG) return;
    if (!drag.turning) {
      drag.turning = true;
      wheel.setPointerCapture(e.pointerId);
    }
    while (Math.abs(drag.turned) >= STEP_DEG) {
      const direction = Math.sign(drag.turned);
      step(direction);
      drag.turned -= direction * STEP_DEG;
    }
  });
  const end = () => {
    // A turn shouldn't also count as a press on the button it started on.
    interaction.swallowClick = drag?.turning ?? false;
    drag = null;
    interaction.active = false;
  };
  wheel.addEventListener("pointerup", end);
  wheel.addEventListener("pointercancel", end);

  let scrolled = 0;
  wheel.addEventListener(
    "wheel",
    (e) => {
      e.preventDefault();
      const unit = e.deltaMode === 1 ? LINE_HEIGHT_PX : 1;
      scrolled += (Math.abs(e.deltaY) >= Math.abs(e.deltaX) ? e.deltaY : e.deltaX) * unit;
      while (Math.abs(scrolled) >= SCROLL_STEP_PX) {
        const direction = Math.sign(scrolled);
        step(direction);
        scrolled -= direction * SCROLL_STEP_PX;
      }
    },
    { passive: false }
  );
}

/** MENU, centre, skip and now-playing buttons, plus the keyboard. */
function bindWheelButtons(wheel, player, step, interaction) {
  wheel.addEventListener("click", (e) => {
    if (interaction.swallowClick) {
      interaction.swallowClick = false;
      return;
    }
    const button = e.target.closest("[data-ipod-action]");
    if (button) player.press(button.dataset.ipodAction);
  });

  const keys = {
    ArrowDown: () => step(1),
    ArrowRight: () => step(1),
    ArrowUp: () => step(-1),
    ArrowLeft: () => step(-1),
    Enter: () => player.press("select"),
    " ": () => player.press("select"),
    Escape: () => player.press("menu"),
    Backspace: () => player.press("menu"),
  };
  wheel.addEventListener("keydown", (e) => {
    // Let focused buttons handle Enter and Space themselves.
    if (e.target !== wheel && (e.key === "Enter" || e.key === " ")) return;
    if (!keys[e.key]) return;
    e.preventDefault();
    keys[e.key]();
  });
}

/** Rows in the menu, the screen to open the menu, and the scrubber to seek. */
function bindScreen(stage, player, interaction) {
  const screen = stage.querySelector("[data-ipod-screen]");
  const seekBar = stage.querySelector("[data-ipod-seek]");
  const seekTo = (e) => {
    const rect = seekBar.getBoundingClientRect();
    player.seek(Math.min(Math.max((e.clientX - rect.left) / rect.width, 0), 1));
  };

  seekBar.addEventListener("pointerdown", (e) => {
    if (player.menuOpen) return;
    e.stopPropagation();
    seekBar.setPointerCapture(e.pointerId);
    interaction.active = true;
    seekTo(e);
  });
  seekBar.addEventListener("pointermove", (e) => {
    if (seekBar.hasPointerCapture(e.pointerId)) seekTo(e);
  });
  seekBar.addEventListener("pointerup", () => (interaction.active = false));
  seekBar.addEventListener("click", (e) => e.stopPropagation());

  screen.addEventListener("click", (e) => {
    const row = e.target.closest("[data-ipod-row]");
    if (row) player.clickRow(Number(row.dataset.ipodRow));
    else if (!player.menuOpen) player.press("menu");
  });
}

/** Tilt towards the pointer, held still while the wheel or scrubber is in use. */
function bindTilt(stage, interaction) {
  const body = stage.querySelector("[data-ipod-body]");
  const target = { x: 0, y: 0 };
  const current = { x: 0, y: 0 };
  stage.addEventListener("pointermove", (e) => {
    if (interaction.active) return;
    const rect = stage.getBoundingClientRect();
    target.y = ((e.clientX - rect.left) / rect.width - 0.5) * TILT_DEG * 2;
    target.x = -((e.clientY - rect.top) / rect.height - 0.5) * TILT_DEG * 2;
  });
  stage.addEventListener("pointerleave", () => {
    target.x = 0;
    target.y = 0;
  });
  onFrame((dt) => {
    if (current.x === target.x && current.y === target.y) return;
    current.x = follow(current.x, target.x, dt, TILT_RATE);
    current.y = follow(current.y, target.y, dt, TILT_RATE);
    body.style.transform = `rotateX(${current.x}deg) rotateY(${current.y}deg)`;
  });
}

/** A short synthesised click, like Spindle's. Silent until the page has had a click. */
let audio = null;
function tick() {
  if (!window.AudioContext) return;
  audio ??= new AudioContext();
  if (audio.state !== "running") return;
  const at = audio.currentTime;
  const tone = audio.createOscillator();
  const gain = audio.createGain();
  tone.type = "square";
  tone.frequency.value = TICK_HZ;
  gain.gain.setValueAtTime(TICK_GAIN, at);
  gain.gain.exponentialRampToValueAtTime(0.0001, at + TICK_SECONDS);
  tone.connect(gain).connect(audio.destination);
  tone.start(at);
  tone.stop(at + TICK_SECONDS * 2);
}
// Browsers only allow sound after a click; wake the audio on the first one.
document.addEventListener("pointerdown", () => audio?.state === "suspended" && audio.resume(), { passive: true });
