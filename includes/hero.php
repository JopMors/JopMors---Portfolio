<?php
/**
 * The entrance: one continuous camera push into the workspace photo, ending
 * inside the MacBook screen (animated by assets/js/hero.js).
 * The MacBook lid/display positions are in image pixels and must match the
 * constants in hero.js if you change the photo.
 */
$beats = array_slice($roles, 0, 3);
$beatWindows = [[0.12, 0.3], [0.32, 0.5], [0.52, 0.7]];
?>
      <section id="top" aria-label="Workspace" data-tone="dark" class="relative h-[400svh] bg-black md:h-[460svh]" data-hero>
        <div class="invisible sticky top-0 h-[100svh] overflow-hidden bg-black" data-hero-stage>
          <div class="absolute left-0 top-0 origin-top-left will-change-transform" style="width: 2048px; height: 1152px" data-hero-photo>
            <img src="assets/img/workspace/master.webp" alt="A desk facing the Golden Gate Bridge at dusk, a MacBook Pro open on it" fetchpriority="high" class="absolute inset-0 h-full w-full object-cover">
            <div class="absolute inset-0 opacity-0" data-hero-blur>
              <img src="assets/img/workspace/master-blur.webp" alt="" class="absolute inset-0 h-full w-full object-cover">
            </div>
          </div>

          <div class="absolute left-0 top-0 origin-top-left rounded-[7px] bg-[#070708] shadow-[inset_0_0_0_0.6px_rgba(255,255,255,0.16)]" style="width: 378px; height: 251px" data-hero-lid>
            <div class="absolute overflow-hidden rounded-[1.5px] bg-m-bg" style="left: 9px; top: 16px; width: 360px; height: 230px">
              <div class="relative origin-top-left" style="width: 1200px; height: 767px; transform: scale(0.3)">
<?php include __DIR__ . '/code-screen.php'; ?>
                <div class="absolute inset-0 bg-m-bg" style="opacity: 0" data-hero-lightup></div>
              </div>
            </div>
          </div>

          <!-- Cinematic grade: fades away as the camera reaches the screen. -->
          <div class="pointer-events-none absolute inset-0" data-hero-grade>
            <div class="absolute inset-0 bg-[radial-gradient(120%_90%_at_50%_45%,transparent_45%,rgb(0_0_0/0.5)_100%)]"></div>
            <div class="absolute inset-x-0 bottom-0 h-1/2 bg-gradient-to-t from-black/60 to-transparent"></div>
            <div class="grain absolute inset-0 opacity-[0.06] mix-blend-overlay"></div>
          </div>

          <div class="absolute inset-x-0 bottom-[14svh] px-6 md:bottom-[12svh] md:px-12" data-hero-title>
            <div class="mb-5 text-white/75"><span class="text-sm tracking-wide text-[#d2d2d7] md:text-[1rem]"><?= e($site['fullName']) ?></span></div>
            <h1 class="text-white text-[26vw] font-semibold leading-[0.8] tracking-[-0.07em] md:text-[15vw]"><?= e($site['name']) ?>.</h1>
          </div>

<?php foreach ($beats as $i => $label): ?>
          <div class="pointer-events-none absolute inset-x-0 bottom-[10svh] flex justify-center px-6" style="opacity: 0" data-hero-beat="<?= $beatWindows[$i][0] ?>,<?= $beatWindows[$i][1] ?>">
            <div class="lg flex items-baseline gap-4 rounded-full px-6 py-3 text-white">
              <span class="font-mono text-xs text-white/50"><?= pad($i + 1) ?></span>
              <span class="text-xl font-medium tracking-tight sm:text-2xl"><?= e($label) ?></span>
            </div>
          </div>
<?php endforeach; ?>

          <div class="absolute bottom-24 right-6 hidden items-center gap-3 text-xs uppercase tracking-[0.25em] text-white/60 md:right-12 md:flex" data-hero-hint>
            <span class="h-px w-10 bg-white/40"></span>
            Scroll to enter
          </div>
        </div>
      </section>
