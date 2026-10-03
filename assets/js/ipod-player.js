/**
 * What the Spindle demo player does: tracks, volume, play/pause and a small
 * menu (Now Playing, Songs, Skins, Shuffle). Input handling is in ipod.js.
 * The tracks are made up; their colours paint the album art.
 */
const TRACKS = [
  { title: "Night Drive", artist: "Spindle", length: 255, art: ["#45bfff", "#7a5cff", "#2d7ff0", "#4b3aa8"] },
  { title: "Glass Harbour", artist: "Spindle", length: 212, art: ["#5ef2c4", "#1fa2a8", "#1f8a70", "#0f4c5c"] },
  { title: "Click Wheel", artist: "The Scrollers", length: 178, art: ["#ffb35c", "#ff5c8a", "#f0702d", "#a83a6b"] },
  { title: "Afterglow", artist: "Low Orbit", length: 227, art: ["#ff7a59", "#ffd166", "#d9480f", "#7a1f1f"] },
  { title: "Paper Moons", artist: "Spindle", length: 242, art: ["#ffe08a", "#8c7bff", "#c9a227", "#3b3486"] },
];

const SKINS = [
  { id: "liquid", label: "Liquid Glass" },
  { id: "frosted", label: "Frosted Glass" },
  { id: "classic", label: "Classic White" },
];

const START_AT_SECONDS = 84;
const VOLUME_STEP = 1 / 16;
const VOLUME_VISIBLE_MS = 1500;
const RESTART_THRESHOLD_SECONDS = 3;
const VISIBLE_ROWS = 5;

const clock = (s) => `${Math.floor(s / 60)}:${String(Math.floor(s % 60)).padStart(2, "0")}`;

/** Menus as functions, so Songs and Skins can mark the current choice. */
const MENUS = {
  main: () => ({
    title: "Spindle",
    items: [
      { label: "Now Playing", run: (p) => p.closeMenu() },
      { label: "Songs", submenu: "songs" },
      { label: "Skins", submenu: "skins" },
      { label: "Shuffle Songs", run: (p) => p.shuffle() },
    ],
  }),
  songs: (p) => ({
    title: "Songs",
    items: TRACKS.map((track, i) => ({
      label: track.title,
      current: i === p.state.track,
      run: () => p.playTrack(i),
    })),
  }),
  skins: (p) => ({
    title: "Skins",
    items: SKINS.map((skin) => ({
      label: skin.label,
      current: skin.id === p.state.skin,
      run: () => p.setSkin(skin.id),
    })),
  }),
};

export function createPlayer(stage) {
  const $ = (name) => stage.querySelector(`[data-ipod-${name}]`);
  const el = {
    body: $("body"), screen: $("screen"), art: $("art"), meta: $("meta"),
    title: $("title"), artist: $("artist"), progress: $("progress"), elapsed: $("elapsed"),
    remaining: $("remaining"), volume: $("volume"), listTitle: $("list-title"), listItems: $("list-items"),
  };
  const state = { track: 0, seconds: START_AT_SECONDS, playing: true, volume: 0.6, skin: "liquid", menu: [] };
  let volumeTimer = 0;

  const player = {
    state,
    get menuOpen() {
      return state.menu.length > 0;
    },

    tickClock() {
      if (!state.playing) return;
      const length = TRACKS[state.track].length;
      if (state.seconds + 1 >= length) return player.skip(1);
      state.seconds += 1;
      renderProgress(true);
    },

    /** One click of the wheel: moves the menu highlight, or the volume. */
    turn(direction) {
      if (player.menuOpen) {
        const top = state.menu[state.menu.length - 1];
        const count = MENUS[top.id](player).items.length;
        const index = Math.min(Math.max(top.index + direction, 0), count - 1);
        state.menu = [...state.menu.slice(0, -1), { ...top, index }];
        renderMenu();
        return;
      }
      state.volume = Math.min(Math.max(state.volume + direction * VOLUME_STEP, 0), 1);
      showVolume();
    },

    press(action) {
      const actions = {
        menu: () => (player.menuOpen ? back() : openMenu("main")),
        select: () => (player.menuOpen ? choose() : togglePlay()),
        next: () => player.skip(1),
        previous: () => player.skip(-1),
        "now-playing": () => player.closeMenu(),
      };
      actions[action]?.();
    },

    /** Clicking a row in the menu selects it. */
    clickRow(index) {
      const top = state.menu[state.menu.length - 1];
      state.menu = [...state.menu.slice(0, -1), { ...top, index }];
      choose();
    },

    seek(fraction) {
      state.seconds = Math.round(fraction * (TRACKS[state.track].length - 1));
      renderProgress(false);
    },

    skip(direction) {
      if (direction < 0 && state.seconds > RESTART_THRESHOLD_SECONDS) return player.seek(0);
      player.playTrack((state.track + direction + TRACKS.length) % TRACKS.length);
    },

    playTrack(index) {
      Object.assign(state, { track: index, seconds: 0, playing: true });
      player.closeMenu();
      renderTrack();
    },

    shuffle() {
      const others = TRACKS.map((_, i) => i).filter((i) => i !== state.track);
      player.playTrack(others[Math.floor(Math.random() * others.length)]);
    },

    setSkin(id) {
      state.skin = id;
      el.body.dataset.skin = id;
      renderMenu();
    },

    closeMenu() {
      state.menu = [];
      renderMenu();
    },
  };

  function openMenu(id) {
    state.menu = [...state.menu, { id, index: 0 }];
    renderMenu();
  }

  function back() {
    state.menu = state.menu.slice(0, -1);
    renderMenu();
  }

  function choose() {
    const top = state.menu[state.menu.length - 1];
    const item = MENUS[top.id](player).items[top.index];
    if (item.submenu) openMenu(item.submenu);
    else item.run(player);
  }

  function togglePlay() {
    state.playing = !state.playing;
    renderPlaying();
  }

  function showVolume() {
    el.volume.style.width = `${state.volume * 100}%`;
    el.meta.classList.add("is-volume");
    clearTimeout(volumeTimer);
    volumeTimer = setTimeout(() => el.meta.classList.remove("is-volume"), VOLUME_VISIBLE_MS);
  }

  function renderTrack() {
    const track = TRACKS[state.track];
    el.title.textContent = track.title;
    el.artist.textContent = track.artist;
    track.art.forEach((colour, i) => el.art.style.setProperty(`--art-${i + 1}`, colour));
    renderProgress(false);
    renderPlaying();
  }

  /** `animate` keeps the one-second glide; seeking and new tracks jump instead. */
  function renderProgress(animate) {
    const length = TRACKS[state.track].length;
    el.progress.style.transition = animate ? "" : "none";
    el.progress.style.width = `${(state.seconds / length) * 100}%`;
    el.elapsed.textContent = clock(state.seconds);
    el.remaining.textContent = `-${clock(length - state.seconds)}`;
  }

  function renderPlaying() {
    stage.classList.toggle("is-paused", !state.playing);
  }

  function renderMenu() {
    el.screen.classList.toggle("is-menu", player.menuOpen);
    if (!player.menuOpen) return;
    const top = state.menu[state.menu.length - 1];
    const menu = MENUS[top.id](player);
    const first = Math.min(Math.max(top.index - VISIBLE_ROWS + 1, 0), Math.max(menu.items.length - VISIBLE_ROWS, 0));
    el.listTitle.textContent = menu.title;
    el.listItems.replaceChildren(
      ...menu.items.slice(first, first + VISIBLE_ROWS).map((item, offset) => {
        const row = document.createElement("li");
        row.textContent = item.label;
        row.dataset.ipodRow = String(first + offset);
        row.classList.toggle("is-active", first + offset === top.index);
        row.classList.toggle("has-submenu", Boolean(item.submenu));
        row.classList.toggle("is-current", Boolean(item.current));
        return row;
      })
    );
  }

  renderTrack();
  el.volume.style.width = `${state.volume * 100}%`;
  return player;
}
