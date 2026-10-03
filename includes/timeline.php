<?php /** "Timeline.": work on the left, study on the right, along a spine that draws itself. */ ?>
      <section id="background" class="px-6 py-32 md:px-12 md:py-48">
        <div class="mx-auto max-w-6xl">
          <?= eyebrow('Background') ?>
          <h2 class="text-5xl font-semibold tracking-[-0.04em] md:text-7xl" data-reveal>Timeline.</h2>

          <div class="mt-16 hidden grid-cols-[1fr_7rem_1fr] items-center text-[13px] font-medium uppercase tracking-[0.2em] text-m-label md:grid">
            <span class="text-right">Work</span>
            <span class="flex justify-center">
              <span class="lg inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-[11px] normal-case tracking-normal">
                <span class="relative flex h-2 w-2">
                  <span class="absolute inset-0 animate-ping rounded-full bg-m-accent/60"></span>
                  <span class="relative h-2 w-2 rounded-full bg-m-accent"></span>
                </span>
                Now
              </span>
            </span>
            <span>Study</span>
          </div>

          <div class="relative mt-12 md:mt-4" data-spine>
            <div class="absolute bottom-0 left-[5px] top-0 w-px bg-m-line/10 md:left-1/2"></div>
            <div class="absolute left-[5px] top-0 w-px bg-gradient-to-b from-m-label via-m-label/70 to-m-label/0 shadow-[0_0_12px_rgba(255,255,255,0.35)] md:left-1/2" style="height: 0%" data-spine-fill></div>
            <ol class="flex flex-col gap-8 md:gap-2">
<?php foreach ($background as $entry): $isWork = $entry['kind'] === 'work'; ?>
              <li class="relative pl-8 md:grid md:min-h-[15rem] md:grid-cols-[1fr_7rem_1fr] md:items-center md:pl-0">
                <span aria-hidden="true" class="pointer-events-none hidden select-none text-[9rem] font-semibold leading-none tracking-[-0.06em] text-m-text/[0.05] md:row-start-1 md:block <?= $isWork ? 'md:col-start-3 md:pl-6' : 'md:col-start-1 md:pr-6 md:text-right' ?>" data-reveal="rise"><?= (int) $entry['start'] ?></span>

                <div class="absolute left-0 top-8 md:relative md:left-auto md:top-auto md:col-start-2 md:row-start-1 md:flex md:h-full md:items-center md:justify-center">
                  <span class="absolute top-1/2 hidden h-px w-1/2 bg-m-line/15 md:block <?= $isWork ? 'left-0' : 'right-0' ?>"></span>
                  <span class="block h-[11px] w-[11px] rounded-full border border-m-label/60 bg-m-bg md:hidden"></span>
                  <span class="relative hidden rounded-full bg-m-bg md:inline-block">
                    <span class="lg inline-block rounded-full px-3.5 py-1.5 font-mono text-xs text-m-label"><?= (int) $entry['start'] ?></span>
                  </span>
                </div>

                <article class="py-2 md:row-start-1 <?= $isWork ? 'tl-mirror md:col-start-1 md:pr-2' : 'md:col-start-3 md:pl-2' ?>" data-reveal="<?= $isWork ? 'left' : 'right' ?>">
                  <div class="tl-head flex items-start gap-4">
                    <span class="lg lg-bubble grid h-11 w-11 shrink-0 place-items-center rounded-full text-xs font-semibold tracking-wide text-m-label"><?= e(monogram($entry['org'])) ?></span>
                    <div class="min-w-0 flex-1">
                      <div class="tl-meta flex flex-wrap items-center gap-2 text-xs">
                        <span class="font-medium uppercase tracking-[0.18em] text-m-label md:hidden"><?= $isWork ? 'Work' : 'Study' ?></span>
                        <span class="font-mono text-m-muted"><?= e($entry['period']) ?></span>
<?php if ($entry['ongoing']): ?>
                        <span class="inline-flex items-center gap-1.5 rounded-full lg-bubble px-2.5 py-0.5 text-m-label">
                          <span class="h-1.5 w-1.5 rounded-full bg-m-accent"></span>
                          Current
                        </span>
<?php endif; ?>
                      </div>
                      <h3 class="mt-2 text-2xl font-semibold tracking-[-0.03em]"><?= e($entry['org']) ?></h3>
                      <p class="mt-1 text-m-muted"><?= e($entry['title']) ?></p>
                    </div>
                  </div>

<?php if ($entry['body']): ?>
                  <div class="overflow-hidden" style="height: 0; opacity: 0" data-expand hidden>
                    <p class="tl-body pt-4 text-sm leading-relaxed text-m-muted"><?= e($entry['body']) ?></p>
                  </div>
<?php endif; ?>

                  <div class="tl-actions mt-4 flex items-center gap-6 text-sm">
<?php if ($entry['link']): ?>
                    <a href="<?= e(asset($entry['link']['href'])) ?>" class="link-accent inline-flex items-center gap-1.5 text-m-text"><?= e($entry['link']['label']) ?> <?= icon('arrow-up-right') ?></a>
<?php else: ?>
                    <span class="text-m-muted"><?= e(duration_label($entry, $now)) ?></span>
<?php endif; ?>
<?php if ($entry['body']): ?>
                    <button aria-expanded="false" class="inline-flex items-center gap-1.5 text-m-label link-accent" data-expand-toggle>
                      <span data-expand-label>More</span>
                      <?= icon('plus', 'h-4 w-4 transition-transform duration-500') ?>
                    </button>
<?php endif; ?>
                  </div>
                </article>
              </li>
<?php endforeach; ?>
            </ol>
          </div>
        </div>
      </section>
