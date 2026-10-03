<?php
/**
 * The MacBook's display: a macOS menu bar and a code editor showing index.html,
 * written from the real data. hero.js "types" it as you scroll.
 */
$tokenColor = [
    'tag' => 'text-[#ff7b72]',
    'attr' => 'text-[#ffa657]',
    'str' => 'text-[#a5d6ff]',
    'text' => 'text-[#e6edf3]',
    'comment' => 'text-[#8b949e] italic',
    'punct' => 'text-[#c9d1d9]',
];
$menuItems = ['Code', 'File', 'Edit', 'Selection', 'View', 'Go', 'Window'];
$fileTree = [
    [0, 'my-website', 'folder'], [1, 'app', 'folder'], [2, 'components', 'folder'], [2, 'pages', 'folder'],
    [3, 'index.html', 'active'], [3, 'projects.html', ''], [3, 'contact.html', ''],
    [1, 'styles', 'folder'], [2, 'globals.css', ''], [2, 'variables.css', ''],
    [1, 'package.json', ''], [1, 'README.md', ''],
];

$open = function (string $tag, array $attrs = []): array {
    $tokens = [['<', 'punct'], [$tag, 'tag']];
    foreach ($attrs as $k => $v) {
        array_push($tokens, [' ' . $k, 'attr'], ['=', 'punct'], ['"' . $v . '"', 'str']);
    }
    $tokens[] = ['>', 'punct'];
    return $tokens;
};
$close = fn (string $tag): array => [['</', 'punct'], [$tag, 'tag'], ['>', 'punct']];

$lines = [
    [0, [['<!DOCTYPE html>', 'comment']]],
    [0, $open('html', ['lang' => 'en'])],
    [1, $open('head')],
    [2, $open('meta', ['charset' => 'UTF-8'])],
    [2, [...$open('title'), [$site['name'] . ' — ' . $site['role'], 'text'], ...$close('title')]],
    [1, $close('head')],
    [1, $open('body')],
    [2, $open('main', ['class' => 'portfolio'])],
    [3, [...$open('h1'), [implode(' ', array_map(fn ($r) => $r . '.', $roles)), 'text'], ...$close('h1')]],
    [3, [...$open('p'), [$site['description'], 'text'], ...$close('p')]],
    [3, $open('section', ['id' => 'work'])],
    [4, [['<!-- ' . count($projects) . ' projects in development -->', 'comment']]],
    [3, $close('section')],
    [2, $close('main')],
    [1, $close('body')],
    [0, $close('html')],
];

// <pre> preserves whitespace, so the code lines are built without any newlines.
$code = '';
foreach ($lines as $n => [$indent, $tokens]) {
    $code .= '<div class="flex" data-line><span class="w-10 shrink-0 select-none pr-4 text-right text-white/25">' . ($n + 1) . '</span>'
        . '<span class="min-w-0 truncate" style="padding-left: ' . ($indent * 1.5) . 'em" data-line-content>';
    foreach ($tokens as [$text, $kind]) {
        $code .= '<span class="' . $tokenColor[$kind] . '" data-token>' . e($text) . '</span>';
    }
    if ($n === count($lines) - 1) {
        $code .= '<span class="ml-px inline-block h-[1.1em] w-[2px] translate-y-[0.2em] animate-pulse" style="background-color: #ff9f0a" data-caret></span>';
    }
    $code .= '</span></div>';
}
?>
                <div class="flex flex-col bg-m-bg font-mono text-white h-full w-full">
                  <div class="flex h-7 shrink-0 items-center justify-between bg-black/30 px-4 font-sans text-[13px] text-white/85">
                    <div class="flex items-center gap-5">
                      <span class="font-semibold">●</span>
<?php foreach ($menuItems as $i => $item): ?>
                      <span<?= $i === 0 ? ' class="font-semibold"' : '' ?>><?= e($item) ?></span>
<?php endforeach; ?>
                    </div>
                    <span class="text-white/70"><?= e($site['name']) ?></span>
                  </div>

                  <div class="flex min-h-0 flex-1">
                    <aside class="flex w-56 shrink-0 flex-col gap-0.5 border-r border-white/[0.06] bg-black/15 px-3 py-4 text-[13px] text-white/55">
                      <span class="mb-3 px-1 text-[11px] uppercase tracking-[0.16em] text-white/35">Explorer</span>
<?php foreach ($fileTree as [$depth, $name, $type]): ?>
                      <span style="padding-left: <?= $depth * 12 + 4 ?>px" class="truncate rounded-md py-1 pr-2<?= $type === 'active' ? ' bg-white/[0.08] text-white' : '' ?><?= $type === 'folder' ? ' text-white/70' : '' ?>"><?= $type === 'folder' ? '▾ ' : '' ?><?= e($name) ?></span>
<?php endforeach; ?>
                    </aside>

                    <div class="flex min-w-0 flex-1 flex-col">
                      <div class="flex items-center border-b border-white/[0.06] bg-black/15 text-[13px]">
                        <span class="border-r border-white/[0.06] bg-m-bg px-5 py-2.5 text-white/90">index.html</span>
                      </div>
                      <pre class="flex-1 overflow-hidden px-3 py-5 text-[15px] leading-[1.8]" data-code><?= $code ?></pre>
                      <div class="flex h-6 shrink-0 items-center justify-between bg-black/15 px-4 text-[11px] text-white/45">
                        <span>main</span>
                        <span>HTML · UTF-8</span>
                      </div>
                    </div>
                  </div>
                </div>
