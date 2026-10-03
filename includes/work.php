<?php
/**
 * Selected work, in two groups:
 * - Launched: one full-height liquid-glass panel per project (scales in while scrolling),
 *   linking to the project's own page when it has one.
 * - Ongoing: compact glass cards with an "In development" badge.
 */
$launched = array_values(array_filter($projects, 'is_launched'));
$ongoing = array_values(array_filter($projects, fn ($p) => !is_launched($p)));

/** "Launched  01 ———" group label. */
function work_group_label(string $label, int $count): string
{
    return '<div class="mx-auto mb-8 flex max-w-6xl items-center gap-4 px-3 text-[13px] font-medium uppercase tracking-[0.2em] text-m-label md:px-6">'
        . e($label) . '<span class="font-mono tracking-normal text-m-muted">' . pad($count) . '</span>'
        . '<span class="h-px flex-1 bg-m-line/15"></span></div>';
}

/** Intrinsic [width, height] of a project icon, so wide logos keep their shape. */
function icon_size(string $path): array
{
    $file = __DIR__ . '/../' . $path;
    $size = is_file($file) ? getimagesize($file) : false;
    return $size ? [$size[0], $size[1]] : [1, 1];
}

/** Technology chips. */
function tech_chips(array $technologies): string
{
    $html = '';
    foreach ($technologies as $tech) {
        $html .= '<li class="rounded-full bg-m-text/[0.08] px-3 py-1 text-xs text-m-text/80">' . e($tech) . '</li>';
    }
    return '<ul class="flex flex-wrap gap-2">' . $html . '</ul>';
}
?>
      <section id="work" class="relative px-3 pb-24 md:px-6">
        <div class="mx-auto mb-16 max-w-6xl px-3 md:mb-24 md:px-6">
          <?= eyebrow('Selected work') ?>
          <h2 class="text-5xl font-semibold tracking-[-0.04em] md:text-8xl" data-reveal><?= $launched ? 'Shipped &amp; Developing.' : 'Launching soon.' ?></h2>
        </div>

<?php if ($launched): ?>
        <?= work_group_label('Launched', count($launched)) ?>
        <div class="flex flex-col gap-6">
<?php foreach ($launched as $i => $project): $page = project_page_url($project); ?>
          <article class="lg relative mx-auto flex min-h-[92svh] w-full max-w-[110rem] flex-col justify-between gap-10 overflow-hidden p-6 md:p-12" style="transform: scale(0.9); border-radius: 48px<?= !empty($project['tint']) ? '; --tint: ' . e($project['tint']) : '' ?>" data-launch>
<?php if (!empty($project['tint'])): ?>
            <div class="project-glow" aria-hidden="true"></div>
<?php endif; ?>
            <div class="relative flex items-start justify-between gap-6">
              <span class="font-mono text-sm text-m-muted"><?= pad($i + 1) ?> / <?= pad(count($launched)) ?></span>
              <span class="lg inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-medium tracking-wide text-m-label">
                <span class="h-1.5 w-1.5 rounded-full bg-[#30d158]"></span>
                <?= e(project_status_label($project)) ?><?= !empty($project['version']) ? ' · v' . e($project['version']) : '' ?>
              </span>
            </div>

            <div class="relative grid items-center gap-10 md:grid-cols-[1fr_1.15fr] md:gap-16">
              <div>
<?php if (!empty($project['icon'])): [$iconW, $iconH] = icon_size($project['icon']); ?>
                <img src="<?= e(asset($project['icon'])) ?>" alt="" width="<?= $iconW ?>" height="<?= $iconH ?>" loading="lazy" class="project-icon<?= $iconW > $iconH ? ' project-icon--wide' : '' ?> mb-6">
<?php endif; ?>
                <h3 class="text-[18vw] font-semibold leading-[0.85] tracking-[-0.06em] md:text-[8vw]"><?= e($project['title']) ?></h3>
              </div>
<?php if (($project['visual'] ?? null) === 'ipod'): ?>
              <?= ipod('mx-auto w-[min(62vw,320px)] md:w-[min(26vw,340px)]') ?>
<?php elseif (($project['visual'] ?? null) === 'paper'): ?>
              <?= paper_stack($project, 'mx-auto w-[min(62vw,300px)] md:w-[min(24vw,340px)]') ?>
<?php elseif (!empty($project['image'])): ?>
              <div class="lg rounded-[28px] p-2 md:p-3">
                <img src="<?= e(asset($project['image'])) ?>" alt="<?= e($project['imageAlt'] ?? $project['title']) ?>" loading="lazy" class="w-full rounded-[22px]">
              </div>
<?php endif; ?>
            </div>

            <div class="lg lg-strong relative grid gap-6 rounded-[28px] p-6 md:grid-cols-[1.4fr_1fr_auto] md:items-end md:p-8" style="transform: translateY(120px)" data-launch-panel>
              <p class="max-w-lg text-lg leading-relaxed text-m-text/80"><?= e($project['description']) ?></p>
              <?= tech_chips($project['technologies']) ?>
              <div class="flex flex-wrap items-center gap-2">
<?php if ($page): ?>
                <a href="<?= e($page) ?>" class="inline-flex items-center gap-2 rounded-full bg-white px-5 py-2 text-sm font-medium text-black transition-transform duration-300 active:scale-[0.97]">View project <?= icon('arrow-up-right') ?></a>
<?php endif; ?>
                <?= project_links($project) ?>
              </div>
            </div>
          </article>
<?php endforeach; ?>
        </div>
<?php endif; ?>

<?php if ($ongoing): ?>
        <div class="<?= $launched ? 'mt-24 md:mt-32' : '' ?>">
          <?= work_group_label('Ongoing', count($ongoing)) ?>
          <div class="mx-auto grid max-w-[110rem] gap-4 md:grid-cols-2">
<?php foreach ($ongoing as $i => $project): ?>
            <article class="lg flex min-h-[22rem] flex-col justify-between gap-10 rounded-[28px] p-7 md:p-9" style="--reveal-delay: <?= $i * 0.08 ?>s" data-reveal>
              <div class="flex items-center justify-between gap-4">
                <span class="inline-flex items-center gap-2 rounded-full bg-m-text/[0.08] px-3 py-1 text-xs text-m-label">
                  <span class="relative flex h-1.5 w-1.5">
                    <span class="absolute inset-0 animate-ping rounded-full bg-m-accent/60"></span>
                    <span class="relative h-1.5 w-1.5 rounded-full bg-m-accent"></span>
                  </span>
                  <?= e(project_status_label($project)) ?>
                </span>
                <span class="font-mono text-sm text-m-muted"><?= pad($i + 1) ?></span>
              </div>
              <div>
                <h3 class="text-4xl font-semibold tracking-[-0.04em] md:text-5xl"><?= e($project['title']) ?></h3>
                <p class="mt-4 max-w-md leading-relaxed text-m-muted"><?= e($project['description']) ?></p>
              </div>
              <div class="flex flex-col gap-5">
                <?= tech_chips($project['technologies']) ?>
                <?= project_links($project) ?>
              </div>
            </article>
<?php endforeach; ?>
          </div>
        </div>
<?php endif; ?>
      </section>
