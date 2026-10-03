<?php
/** Spindle's project page. Content paraphrased from the project's README. */

$specs = [
    ['Platform', 'macOS 14 or later'],
    ['Runs on', 'Apple silicon & Intel'],
    ['Version', $project['version']],
    ['Built with', 'Swift'],
    ['License', 'MIT'],
];

$highlights = [
    ['Any app, not just Music', 'It reads what is playing from the system media controls, so Music, Spotify, Safari, Chrome, IINA and VLC all show up — artwork included.'],
    ['A click wheel that works', 'Turn it to change the volume or move through the menu; the centre plays and pauses. Every step ticks — the sound is synthesised, not sampled.'],
    ['Lives on your desktop', 'Not a WidgetKit widget: a borderless panel pinned to the wallpaper behind your windows, sized to the macOS widget grid, on every Space.'],
    ['Your library, browsable', 'Playlists, Artists, Albums and Songs from Apple Music — or from Spotify through its Web API, signed in with PKCE and kept in your keychain.'],
    ['Nine skins', 'Including Liquid Glass and Frosted Glass, plus one you colour yourself with a hue wheel and sliders for opacity, borders and blur.'],
    ['Asks for very little', 'No Screen Recording, Accessibility or Full Disk Access. It only goes online to talk to Spotify — and only if you connect it.'],
];

/**
 * Control, what it does while playing, what it does in a menu, and where its numbered marker
 * sits on the wheel diagram (x, y in the diagram's 300 × 480 viewBox; some controls have two).
 */
$controls = [
    ['Scroll anywhere, or turn the wheel', 'Volume', 'Moves the highlight', [[262, 238]]],
    ['Centre button', 'Play / pause', 'Select', [[150, 330]]],
    ['MENU', 'Opens the menu', 'Back up one level', [[150, 262]]],
    ['Right / left of the wheel', 'Next / previous track', 'Next / previous track', [[82, 330], [218, 330]]],
    ['Bottom of the wheel', 'Opens the player you pick', 'Same', [[150, 398]]],
    ['Click the screen', 'Opens the menu', 'Selects that row', [[150, 100]]],
    ['Drag the scrubber', 'Jumps to that point', '—', [[118, 166]]],
];

/** What still works since macOS 15.4 restricted MediaRemote (verified in the README). */
$approaches = [
    ['Reading now-playing directly from the app', 'Blocked', '0 keys'],
    ['Reading it from inside /usr/bin/perl', 'Works', '31 keys, artwork included'],
    ['Sending play, pause and skip commands', 'Works', ''],
    ['Setting shuffle and repeat', 'Works', ''],
    ['Seeking', 'Works', ''],
    ['Asking which app is playing', 'Blocked', ''],
    ['Reading shuffle and repeat back', 'No usable API', ''],
];

$download = $project['demo'];
?>
      <!-- Hero -->
      <section class="px-6 pb-16 pt-36 md:px-12 md:pb-24 md:pt-44">
        <div class="mx-auto max-w-6xl">
          <a href="<?= e(asset('#work')) ?>" class="inline-flex items-center gap-2 text-sm text-m-label link-accent">← All work</a>

          <div class="mt-12 grid items-center gap-16 md:grid-cols-[1.2fr_0.8fr] md:gap-10">
            <div class="min-w-0">
              <div class="flex flex-wrap items-center gap-5" data-reveal>
                <img src="<?= e(asset($project['icon'])) ?>" alt="Spindle app icon" width="88" height="88" class="h-20 w-20 md:h-[88px] md:w-[88px]">
                <span class="lg inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-medium tracking-wide text-m-label">
                  <span class="h-1.5 w-1.5 rounded-full bg-[#30d158]"></span>
                  Launched · v<?= e($project['version']) ?>
                </span>
              </div>

              <h1 class="mt-10 text-[22vw] font-semibold leading-[0.85] tracking-[-0.065em] md:text-[min(10vw,9rem)]" data-reveal><?= e($project['title']) ?>.</h1>
              <p class="mt-8 max-w-2xl text-balance text-2xl font-medium leading-snug tracking-[-0.02em] md:text-3xl" data-reveal>
                A macOS desktop widget shaped like a 2000s-era portable music player.
                <span class="text-m-muted">It shows whatever is playing, from any app — the album cover filling the screen, the title laid over it, and a working scroll wheel.</span>
              </p>

              <div class="mt-10 flex flex-wrap items-center gap-3" data-reveal>
                <a href="<?= e($download) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 btn-accent rounded-full px-6 py-3 text-sm font-medium transition-transform duration-300 active:scale-[0.97]">Download for Mac <?= icon('arrow-up-right') ?></a>
                <a href="<?= e($project['github']) ?>" target="_blank" rel="noopener noreferrer" class="lg lg-press inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-medium"><?= icon('github') ?>View on GitHub</a>
              </div>
            </div>

            <div data-reveal="right">
              <?= ipod('mx-auto w-[min(76vw,380px)] md:mr-0 md:w-[min(30vw,420px)]') ?>
            </div>
          </div>

          <dl class="mt-16 grid grid-cols-2 gap-x-8 gap-y-6 border-t border-m-line/10 pt-8 md:grid-cols-5">
<?php foreach ($specs as [$label, $value]): ?>
            <div>
              <dt class="text-xs font-medium uppercase tracking-[0.18em] text-m-label"><?= e($label) ?></dt>
              <dd class="mt-2 text-lg tracking-tight"><?= e($value) ?></dd>
            </div>
<?php endforeach; ?>
          </dl>
        </div>
      </section>

      <!-- The skins -->
      <section class="px-3 pb-24 md:px-6 md:pb-32">
        <figure class="lg mx-auto max-w-5xl p-3 md:p-5" style="transform: scale(0.92); border-radius: 40px" data-scale-in>
          <img src="<?= e(asset($project['image'])) ?>" alt="<?= e($project['imageAlt']) ?>" class="w-full rounded-[24px]">
          <figcaption class="mt-4 px-2 pb-1 text-sm text-m-muted">Four of the nine skins: Mini Silver, Mini Blue, Mini Pink and Mini Green.</figcaption>
        </figure>
      </section>

      <!-- What it does -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('What it does') ?>
          <h2 class="max-w-4xl text-5xl font-semibold tracking-[-0.045em] md:text-7xl" data-reveal>Now playing, <span class="text-m-muted <?= SERIF ?>">from anything.</span></h2>
          <div class="plain-grid mt-16 grid md:grid-cols-3">
<?php foreach ($highlights as $i => [$title, $body]): ?>
            <div style="--reveal-delay: <?= ($i % 3) * 0.08 ?>s" data-reveal>
              <span class="font-mono text-sm text-m-muted"><?= pad($i + 1) ?></span>
              <h3 class="mt-3 text-2xl font-semibold tracking-[-0.03em]"><?= e($title) ?></h3>
              <p class="mt-3 leading-relaxed text-m-muted"><?= e($body) ?></p>
            </div>
<?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Controls -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('Controls') ?>
          <h2 class="text-5xl font-semibold tracking-[-0.045em] md:text-7xl" data-reveal>The wheel, <span class="text-m-muted <?= SERIF ?>">faithfully.</span></h2>
          <p class="mt-6 max-w-2xl text-lg leading-relaxed text-m-muted" data-reveal>Drag around the ring or simply scroll anywhere on the widget. Nothing is wheel-only: the screen is a control too, the volume bar can be dragged, and the scrubber seeks. <span class="text-m-text">The player at the top of this page works the same way — try it.</span></p>

          <div class="mt-16 grid items-center gap-14 md:grid-cols-[0.8fr_1.2fr] md:gap-20">
            <svg class="wheel-diagram mx-auto w-full" viewBox="0 0 300 480" role="img" aria-label="Spindle's controls, numbered to match the list" data-reveal>
              <rect x="20" y="10" width="260" height="460" rx="36" class="wheel-diagram__body"/>
              <rect x="44" y="34" width="212" height="156" rx="14" class="wheel-diagram__screen"/>
              <rect x="64" y="128" width="120" height="9" rx="3" class="wheel-diagram__text"/>
              <rect x="64" y="144" width="72" height="7" rx="3" class="wheel-diagram__text"/>
              <rect x="64" y="164" width="172" height="4" rx="2" class="wheel-diagram__track"/>
              <rect x="64" y="164" width="54" height="4" rx="2" class="wheel-diagram__progress"/>
              <circle cx="150" cy="330" r="100" class="wheel-diagram__wheel"/>
              <circle cx="150" cy="330" r="38" class="wheel-diagram__button"/>
              <path d="M 226 252 A 112 112 0 0 1 258 298" class="wheel-diagram__turn"/>
              <path d="M 252 290 L 259 301 L 264 288" class="wheel-diagram__turn"/>
<?php foreach ($controls as $i => [, , , $points]): foreach ($points as [$x, $y]): ?>
              <g class="wheel-diagram__marker"><circle cx="<?= $x ?>" cy="<?= $y ?>" r="12"/><text x="<?= $x ?>" y="<?= $y ?>"><?= $i + 1 ?></text></g>
<?php endforeach; endforeach; ?>
            </svg>
            <ol class="controls-legend">
<?php foreach ($controls as $i => [$control, $playing, $menu]): ?>
              <li style="--reveal-delay: <?= $i * 0.04 ?>s" data-reveal>
                <span class="wheel-diagram__key font-mono"><?= $i + 1 ?></span>
                <div>
                  <p class="font-medium tracking-tight"><?= e($control) ?></p>
                  <p class="mt-1 text-sm leading-relaxed text-m-muted">Now playing: <span class="text-m-text/80"><?= e($playing) ?></span><?php if ($menu !== '—'): ?> · In a menu: <span class="text-m-text/80"><?= e($menu) ?></span><?php endif; ?></p>
                </div>
              </li>
<?php endforeach; ?>
            </ol>
          </div>
        </div>
      </section>

      <!-- Engineering -->
      <section class="px-6 py-24 md:px-12 md:py-36">
        <div class="mx-auto grid max-w-6xl gap-14 md:grid-cols-[1fr_1.15fr] md:gap-20">
          <div>
            <?= eyebrow('Under the hood') ?>
            <h2 class="text-5xl font-semibold tracking-[-0.045em] md:text-6xl" data-reveal>How it reads <span class="text-m-muted <?= SERIF ?>">now playing.</span></h2>
            <div class="mt-8 space-y-5 text-lg leading-relaxed text-m-muted" data-reveal>
              <p>Since macOS 15.4, the private MediaRemote framework returns an empty dictionary to any process that isn't an Apple platform binary — an ordinary app can no longer simply ask what's playing.</p>
              <p>Spindle ships a small library and loads it inside <code class="rounded-md bg-m-text/[0.08] px-1.5 py-0.5 font-mono text-[0.9em] text-m-text">/usr/bin/perl</code>, which is a platform binary, using the technique from <a href="https://github.com/ungive/mediaremote-adapter" target="_blank" rel="noopener noreferrer" class="text-m-text underline decoration-m-line/30 underline-offset-4 hover:decoration-m-text">ungive/mediaremote-adapter</a>. It subscribes to MediaRemote's change notifications and streams JSON back to the app — push-based and deduplicated, so idle playback costs nothing.</p>
              <p>The elapsed time it reports is a reading taken at a timestamp, not a live value, so the scrubber extrapolates from the timestamp instead of trusting the number. If a future macOS closes this route, Spindle falls back to AppleScript for Music and Spotify.</p>
            </div>
          </div>

          <div class="lg self-start rounded-[28px] p-2 md:p-3" data-reveal>
            <p class="px-5 pb-2 pt-4 text-xs uppercase tracking-[0.15em] text-m-muted">Tested on macOS 15.4+</p>
<?php foreach ($approaches as [$approach, $result, $note]): $works = $result === 'Works'; ?>
            <div class="flex items-start justify-between gap-6 border-t border-m-line/[0.08] px-5 py-4">
              <span class="tracking-tight"><?= e($approach) ?><?php if ($note): ?><span class="mt-1 block font-mono text-xs text-m-muted"><?= e($note) ?></span><?php endif; ?></span>
              <span class="inline-flex shrink-0 items-center gap-2 rounded-full bg-m-text/[0.08] px-3 py-1 text-xs <?= $works ? 'text-m-text' : 'text-m-muted' ?>">
                <span class="h-1.5 w-1.5 rounded-full <?= $works ? 'bg-[#30d158]' : 'bg-m-muted/60' ?>"></span>
                <?= e($result) ?>
              </span>
            </div>
<?php endforeach; ?>
          </div>
        </div>
      </section>

      <!-- Get it -->
      <section class="px-3 pb-32 pt-12 md:px-6">
        <div class="lg mx-auto max-w-6xl rounded-[28px] px-6 py-16 md:px-14 md:py-20" data-reveal>
          <div class="grid grid-cols-[minmax(0,1fr)] gap-12 md:grid-cols-[1.1fr_1fr] md:items-end">
            <div class="min-w-0">
              <img src="<?= e(asset($project['icon'])) ?>" alt="" width="64" height="64" loading="lazy" class="h-16 w-16">
              <h2 class="mt-8 text-5xl font-semibold tracking-[-0.045em] md:text-7xl">Get Spindle.</h2>
              <p class="mt-4 text-lg text-m-muted">Free and open source · macOS 14 or later · Apple silicon &amp; Intel</p>
              <div class="mt-8 flex flex-wrap items-center gap-3">
                <a href="<?= e($download) ?>" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 btn-accent rounded-full px-6 py-3 text-sm font-medium transition-transform duration-300 active:scale-[0.97]">Download for Mac <?= icon('arrow-up-right') ?></a>
                <a href="<?= e($project['github']) ?>" target="_blank" rel="noopener noreferrer" class="lg lg-press inline-flex items-center gap-2 rounded-full px-6 py-3 text-sm font-medium"><?= icon('github') ?>Source code</a>
              </div>
            </div>
            <div class="min-w-0 text-sm leading-relaxed text-m-muted">
              <p class="font-medium text-m-label">First launch</p>
              <p class="mt-2">Spindle isn't signed with a paid Apple Developer ID, so macOS blocks it the first time. Open <span class="text-m-text">System Settings → Privacy &amp; Security</span>, click <span class="text-m-text">Open Anyway</span>, and confirm. You only do this once. Or in Terminal:</p>
              <pre class="mt-4 overflow-x-auto rounded-2xl bg-black/30 px-4 py-3 font-mono text-xs text-m-text">xattr -dr com.apple.quarantine "/Applications/Spindle.app"</pre>
            </div>
          </div>
        </div>
        <p class="mx-auto mt-8 max-w-6xl px-3 text-xs leading-relaxed text-m-muted md:px-0">Spindle is an independent project and is not affiliated with, endorsed by, or connected to Apple Inc. All artwork is original; product names belong to their respective owners.</p>
      </section>
