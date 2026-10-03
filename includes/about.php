<?php /** About me: a portrait, a few paragraphs and the facts at a glance. Text lives in data.php ($about). */ ?>
      <section id="about" class="px-6 py-32 md:px-12 md:py-48">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('About me') ?>
          <div class="grid gap-14 md:grid-cols-[0.8fr_1.2fr] md:gap-20">
            <div class="flex flex-col gap-6" data-reveal="left">
              <img src="<?= e(asset($about['portrait'])) ?>" alt="<?= e($about['portraitAlt']) ?>" width="675" height="900" loading="lazy" class="about-portrait w-full rounded-[28px]">
              <dl class="grid grid-cols-2 gap-x-6 gap-y-5 px-1 pt-2">
<?php foreach ($about['facts'] as [$label, $value]): ?>
                <div>
                  <dt class="text-xs font-medium uppercase tracking-[0.18em] text-m-label"><?= e($label) ?></dt>
                  <dd class="mt-1.5 tracking-tight"><?= e($value) ?></dd>
                </div>
<?php endforeach; ?>
              </dl>
            </div>

            <div class="md:pt-4">
              <h2 class="text-5xl font-semibold tracking-[-0.045em] md:text-7xl" data-reveal><?= e($about['headline']) ?> <span class="text-m-muted <?= SERIF ?>"><?= e($about['headlineAccent']) ?></span></h2>
              <div class="mt-10 space-y-6 text-lg leading-relaxed text-m-muted" data-reveal>
<?php foreach ($about['paragraphs'] as $paragraph): ?>
                <p><?= e($paragraph) ?></p>
<?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </section>
