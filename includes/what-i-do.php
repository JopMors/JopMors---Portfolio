<?php
/**
 * "What I do": the process, with a sticky drawing (assets/js/field-canvas.js) per step.
 * Drawings: "ridges", "rings" or "network"; the number is a seed that varies the shape.
 */
$fields = [
    'design' => ['rings', 5],
    'application' => ['ridges', 2],
    'data' => ['network', 9],
];
$stepCount = count($capabilities);
?>
      <section id="practice" class="px-6 py-32 md:px-12 md:py-44">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('What I do') ?>
          <div class="mt-6 grid gap-10 md:grid-cols-2 md:gap-16">
            <div class="relative aspect-square overflow-hidden rounded-[28px] bg-m-surface md:sticky md:top-[12svh] md:aspect-auto md:h-[76svh]" data-field-panel>
              <div class="absolute inset-0" data-field-layer>
                <div class="relative h-full w-full">
                  <canvas aria-hidden="true" class="absolute inset-0 h-full w-full" data-field-canvas></canvas>
                </div>
              </div>
            </div>
            <div>
<?php foreach ($capabilities as $i => $c): [$variant, $seed] = $fields[$c['id']] ?? ['ridges', 1]; ?>
              <div class="flex min-h-[60svh] flex-col justify-center border-t border-m-line/10 py-12 md:min-h-[76svh]" data-capability data-variant="<?= e($variant) ?>" data-seed="<?= (int) $seed ?>" data-tint="<?= e($c['tint'] ?? '') ?>">
                <span class="font-mono text-sm text-m-label"><?= pad($i + 1) ?> / <?= pad($stepCount) ?></span>
                <h3 class="mt-4 text-6xl font-semibold tracking-[-0.05em] md:text-8xl"><?= e($c['title']) ?></h3>
                <p class="mt-6 max-w-md text-3xl leading-tight md:text-4xl <?= SERIF ?>"><?= e($c['line']) ?></p>
                <p class="mt-6 max-w-md leading-relaxed text-m-muted"><?= e($c['detail']) ?></p>
              </div>
<?php endforeach; ?>
            </div>
          </div>
        </div>
      </section>
