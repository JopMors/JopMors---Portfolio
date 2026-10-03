<?php
/**
 * A single iPod-style player in black liquid glass, used for Spindle. It works:
 * the click wheel scrolls, the buttons press and the screen has a menu.
 * Styling: assets/css/site.css (".ipod"); behaviour: assets/js/ipod.js + ipod-player.js.
 * Every size inside scales with the width you give it via $class (e.g. "w-[340px]").
 */
function ipod(string $class = '', string $title = 'Night Drive', string $artist = 'Spindle'): string
{
    $glyph = fn (string $paths, string $viewBox = '0 0 24 24') =>
        '<svg viewBox="' . $viewBox . '" fill="currentColor" aria-hidden="true">' . $paths . '</svg>';

    $bars = $glyph('<rect x="0" y="7" width="2.6" height="5" rx=".6"/><rect x="4.5" y="4.6" width="2.6" height="7.4" rx=".6"/><rect x="9" y="2.2" width="2.6" height="9.8" rx=".6"/><rect x="13.4" y="0" width="2.6" height="12" rx=".6"/>', '0 0 16 12');
    $previous = $glyph('<path d="M6 5h2.2v14H6zM20 5v14l-10.5-7z"/>');
    $next = $glyph('<path d="M15.8 5H18v14h-2.2zM4 5v14l10.5-7z"/>');
    $pause = $glyph('<path d="M7 5h3.6v14H7zM13.4 5H17v14h-3.6z"/>');
    $play = $glyph('<path d="M7 4.5v15l12.5-7.5z"/>');
    $note = $glyph('<rect x="12.6" y="4" width="2.1" height="12.5" rx=".5"/><path d="M12.6 4h6.2v3.1h-6.2z"/><ellipse cx="10.3" cy="16.6" rx="3.6" ry="2.8" transform="rotate(-22 10.3 16.6)"/>');
    $speaker = $glyph('<path d="M4 9h4l5-4v14l-5-4H4z"/>');
    $speakerLoud = $glyph('<path d="M3 9h4l5-4v14l-5-4H3z"/><path d="M15.5 8.5a5 5 0 0 1 0 7M18 6a8.5 8.5 0 0 1 0 12" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>');

    return '
      <div class="ipod-stage ' . e($class) . '" data-ipod role="group" aria-label="Spindle, a working demo player">
        <div class="ipod lg" data-ipod-body>
          <div class="ipod__sheen"></div>
          <div class="ipod__screen" data-ipod-screen>
            <div class="ipod__art" data-ipod-art></div>
            <div class="ipod__status">' . $bars . '<span class="ipod__state" data-ipod-state>' . $play . $pause . '</span></div>
            <div class="ipod__meta" data-ipod-meta>
              <p class="ipod__title" data-ipod-title aria-live="polite">' . e($title) . '</p>
              <p class="ipod__artist" data-ipod-artist>' . e($artist) . '</p>
              <div class="ipod__seek" data-ipod-seek>
                <div class="ipod__progress"><span style="width: 33%" data-ipod-progress></span></div>
                <div class="ipod__times"><span data-ipod-elapsed>1:24</span><span data-ipod-remaining>-2:51</span></div>
              </div>
              <div class="ipod__volume" aria-hidden="true">' . $speaker . '<div class="ipod__progress"><span data-ipod-volume></span></div>' . $speakerLoud . '</div>
            </div>
            <div class="ipod__glare"></div>
            <div class="ipod__list" data-ipod-list>
              <p class="ipod__list-title" data-ipod-list-title></p>
              <ul data-ipod-list-items></ul>
            </div>
          </div>
          <div class="ipod__wheel lg" data-ipod-wheel data-lenis-prevent-wheel tabindex="0" aria-label="Click wheel. Scroll or drag around it, or use the arrow keys.">
            <button type="button" class="ipod__menu" data-ipod-action="menu" aria-label="Menu">MENU</button>
            <button type="button" class="ipod__previous" data-ipod-action="previous" aria-label="Previous track">' . $previous . '</button>
            <button type="button" class="ipod__next" data-ipod-action="next" aria-label="Next track">' . $next . '</button>
            <button type="button" class="ipod__note" data-ipod-action="now-playing" aria-label="Now playing">' . $note . '</button>
            <button type="button" class="ipod__center lg" data-ipod-action="select" aria-label="Play, pause or select">' . $pause . $play . '</button>
          </div>
        </div>
      </div>';
}
