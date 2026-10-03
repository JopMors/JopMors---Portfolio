<?php /** One sentence; each word lights up as it scrolls through the viewport. */ ?>
      <section id="statement" class="relative px-6 pb-32 pt-24 md:px-12 md:pb-48 md:pt-32">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow($site['name'] . ', in one sentence') ?>
          <p class="flex flex-wrap text-balance text-[2.4rem] font-semibold leading-[1.08] tracking-[-0.035em] sm:text-6xl md:text-7xl lg:text-[5.5rem]" data-scroll-words>
<?php foreach (explode(' ', $site['description']) as $word): ?>
            <span class="mr-[0.25em]" style="opacity: 0.16" data-word><?= e($word) ?></span>
<?php endforeach; ?>
          </p>
        </div>
      </section>
