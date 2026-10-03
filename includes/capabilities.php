<?php /** Capabilities over the Bay Bridge photo: the tools behind each process step + a magnifying glass dock of languages. */ ?>
      <section id="capabilities" class="relative overflow-hidden text-white" data-capabilities>
        <div class="absolute inset-0" data-parallax-photo>
          <img src="assets/img/bay-bridge-muted.webp" alt="The Bay Bridge and the San Francisco skyline at dusk" loading="lazy" class="absolute inset-0 h-full w-full object-cover object-[35%_50%]">
        </div>
        <!-- Blend the photograph into the page above and below. -->
        <div class="absolute inset-x-0 top-0 h-56 bg-gradient-to-b from-m-bg to-transparent"></div>
        <div class="absolute inset-x-0 bottom-0 h-56 bg-gradient-to-t from-m-bg to-transparent"></div>

        <div class="relative mx-auto max-w-6xl px-6 py-48 md:px-12 md:py-64">
          <?= eyebrow('Capabilities') ?>
          <h2 class="capabilities-heading text-balance text-3xl leading-tight md:text-5xl <?= SERIF ?>" data-reveal>The toolkit behind each step.</h2>
          <div class="grid gap-4 md:grid-cols-3">
<?php foreach ($capabilities as $i => $c): ?>
            <div class="lg lg-dark capability-card flex flex-col justify-between rounded-[28px] p-7" style="--reveal-delay: <?= $i * 0.08 ?>s" data-reveal>
              <div>
                <span class="font-mono text-sm text-white/60"><?= pad($i + 1) ?></span>
                <h3 class="mt-2 text-4xl font-semibold tracking-[-0.03em]"><?= e($c['title']) ?></h3>
              </div>
              <ul class="tool-chips mt-8 flex flex-wrap gap-2" style="--tint: <?= e($c['tint'] ?? '255 255 255') ?>" aria-label="<?= e($c['title']) ?> tools">
<?php foreach ($c['tools'] ?? [] as $tool): ?>
                <li class="tool-chip rounded-full px-3 py-1 text-sm"><?= e($tool) ?></li>
<?php endforeach; ?>
              </ul>
            </div>
<?php endforeach; ?>
          </div>

          <div class="mt-14 flex justify-center" data-reveal>
            <div class="lg lg-dark flex h-[84px] max-w-full items-end gap-3 overflow-x-auto rounded-[28px] px-4 pb-3.5 md:overflow-visible" data-dock>
<?php foreach ($skills as $skill): ?>
              <div role="img" aria-label="<?= e($skill['name']) ?>" class="lg group relative grid shrink-0 place-items-center rounded-[18px]" style="width: 56px; height: 56px" data-dock-icon>
                <img src="<?= e($skill['logo']) ?>" alt="" width="48" height="48" class="h-1/2 w-1/2 object-contain">
                <span class="lg lg-dark pointer-events-none absolute -top-11 left-1/2 hidden -translate-x-1/2 whitespace-nowrap rounded-full px-3 py-1 text-xs opacity-0 transition-opacity duration-200 group-hover:opacity-100 md:block"><?= e($skill['name']) ?></span>
              </div>
<?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
