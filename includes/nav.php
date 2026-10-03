<?php
/** Floating glass navigation. Links scroll to the section with that id. */
$navItems = [
    ['label' => 'About', 'id' => 'about'],
    ['label' => 'What I do', 'id' => 'practice'],
    ['label' => 'Work', 'id' => 'work'],
    ['label' => 'Capabilities', 'id' => 'capabilities'],
    ['label' => 'Background', 'id' => 'background'],
];
$onSubpage = isset($navCurrent);

/** A nav control: smooth-scroll button on the home page, a link back home elsewhere. */
function nav_control(string $id, string $class, string $label, bool $onSubpage, string $extra = ''): string
{
    if ($onSubpage) {
        $href = $id === 'top' ? asset('') : asset('#' . $id);
        return '<a href="' . e($href ?: './') . '" class="' . $class . '"' . $extra . '>' . $label . '</a>';
    }
    return '<button class="' . $class . '" data-scroll-to="' . e($id) . '"' . $extra . '>' . $label . '</button>';
}
?>
    <header class="nav-shell fixed inset-x-0 top-0 z-[100] flex justify-center px-4 pt-4" data-nav<?= $onSubpage ? ' data-nav-current="' . e($navCurrent) . '"' : '' ?>>
      <nav class="lg lg-clear flex w-full items-center justify-between gap-2 rounded-full py-1.5 pl-5 pr-1.5 text-white md:w-auto" data-nav-bar>
        <?= nav_control('top', 'mr-3 text-[15px] font-semibold tracking-tight', e($site['name']), $onSubpage, ' aria-label="' . ($onSubpage ? 'Home' : 'Back to top') . '"') ?>

        <ul class="relative hidden items-center md:flex" data-nav-list>
          <li aria-hidden="true" class="nav-pill pointer-events-none absolute left-0 top-0 -z-10 rounded-full bg-white/[0.1]" data-nav-pill></li>
<?php foreach ($navItems as $item): ?>
          <li>
            <?= nav_control($item['id'], 'relative block rounded-full px-3.5 py-1.5 text-[13px] opacity-60 transition-opacity duration-300 hover:opacity-100', e($item['label']), $onSubpage, ' data-nav-link="' . e($item['id']) . '"') ?>
          </li>
<?php endforeach; ?>
        </ul>

        <div class="flex items-center gap-1">
          <?= nav_control('contact', 'rounded-full bg-white px-4 py-1.5 text-[13px] font-medium text-black transition-transform duration-300 active:scale-95', 'Say hello', $onSubpage) ?>
          <button class="grid h-8 w-8 place-items-center rounded-full md:hidden" aria-label="Toggle menu" aria-expanded="false" data-nav-toggle>
            <span data-nav-icon-open><?= icon('menu') ?></span>
            <span class="hidden" data-nav-icon-close><?= icon('x') ?></span>
          </button>
        </div>
      </nav>

      <div class="nav-sheet lg lg-strong absolute inset-x-4 top-[4.25rem] rounded-[28px] p-2 text-white md:hidden" data-nav-sheet>
<?php foreach ($navItems as $item): ?>
        <?= nav_control($item['id'], 'block w-full rounded-[20px] px-4 py-3.5 text-left text-lg tracking-tight opacity-60', e($item['label']), $onSubpage, ' data-nav-link="' . e($item['id']) . '"') ?>
<?php endforeach; ?>
      </div>
    </header>
