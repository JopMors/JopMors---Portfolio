<?php
/** Small helpers shared by the partials. */

/** Escape text for HTML output. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** 1 → "01". */
function pad(int $n): string
{
    return str_pad((string) $n, 2, '0', STR_PAD_LEFT);
}

/** First four-digit year in a period ("2019 – 2024" → 2019). */
function start_year(string $period): int
{
    return preg_match('/\d{4}/', $period, $m) ? (int) $m[0] : 0;
}

function is_ongoing(string $period): bool
{
    return (bool) preg_match('/present/i', $period);
}

/** The last year of an entry; ongoing entries run until $now. */
function end_year(array $entry, float $now): float
{
    if ($entry['ongoing']) {
        return $now;
    }
    preg_match_all('/\d{4}/', $entry['period'], $m);
    return $m[0] ? (float) end($m[0]) : $entry['start'] + 1;
}

function duration_label(array $entry, float $now): string
{
    $years = max((int) round(end_year($entry, $now) - $entry['start']), 1);
    return $years . ' ' . ($years === 1 ? 'year' : 'years');
}

/** "Zuyderland Ziekenhuis" → "ZZ". */
function monogram(string $org): string
{
    $words = array_slice(preg_split('/\s+/', trim($org)), 0, 2);
    return implode('', array_map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)), $words));
}

function is_launched(array $project): bool
{
    return $project['status'] === 'launched';
}

/** 'statusLabel' in data.php overrides the default badge text. */
function project_status_label(array $project): string
{
    return $project['statusLabel'] ?? (is_launched($project) ? 'Launched' : 'In development');
}

/** URL of a launched project's own page, or null if it has none. */
function project_page_url(array $project): ?string
{
    return is_launched($project) && !empty($project['slug']) ? asset('projects/' . $project['slug'] . '/') : null;
}

/**
 * Path to a file in the site root, from the current page. Pages in
 * sub-folders (projects/<slug>/) set $base = '../../' before including.
 */
function asset(string $path): string
{
    global $base;
    return ($base ?? '') . $path;
}

/**
 * GitHub as a glass pill and the demo (Download, Read the thesis…) in the accent colour;
 * missing links show a quiet "soon".
 * 'closedSource' => true leaves the GitHub button out entirely.
 */
function project_links(array $project): string
{
    $links = [
        ['GitHub', $project['github'] ?? null, 'github', 'lg lg-press'],
        [$project['demoLabel'] ?? 'Live demo', $project['demo'] ?? null, 'arrow-up-right', 'btn-accent'],
    ];
    if (!empty($project['closedSource'])) {
        array_shift($links);
    }
    $html = '';
    foreach ($links as [$label, $href, $iconName, $style]) {
        $html .= $href
            ? '<a href="' . e($href) . '" target="_blank" rel="noopener noreferrer" class="' . $style . ' inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium">' . icon($iconName) . e($label) . '</a>'
            : '<span aria-disabled="true" class="inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm opacity-50 border-white/10">' . icon($iconName) . e($label) . ' · soon</span>';
    }
    return '<div class="flex flex-wrap items-center gap-2">' . $html . '</div>';
}

/** Inline Lucide icons (the same set the original site uses). */
function icon(string $name, string $class = 'h-4 w-4'): string
{
    $paths = [
        'arrow-up-right' => '<path d="M7 7h10v10"></path><path d="M7 17 17 7"></path>',
        'plus' => '<path d="M5 12h14"></path><path d="M12 5v14"></path>',
        'github' => '<path d="M15 22v-4a4.8 4.8 0 0 0-1-3.5c3 0 6-2 6-5.5.08-1.25-.27-2.48-1-3.5.28-1.15.28-2.35 0-3.5 0 0-1 0-3 1.5-2.64-.5-5.36-.5-8 0C6 2 5 2 5 2c-.3 1.15-.3 2.35 0 3.5A5.403 5.403 0 0 0 4 9c0 3.5 3 5.5 6 5.5-.39.49-.68 1.05-.85 1.65-.17.6-.22 1.23-.15 1.85v4"></path><path d="M9 18c-4.51 2-5-2-7-2"></path>',
        'menu' => '<line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line>',
        'x' => '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>',
        'check' => '<path d="M20 6 9 17l-5-5"></path>',
    ];
    $strokeWidth = $name === 'check' ? '2.5' : '2';
    return '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="' . $strokeWidth . '" stroke-linecap="round" stroke-linejoin="round" class="' . e($class) . '" aria-hidden="true">' . $paths[$name] . '</svg>';
}

/** Small light-gray section label with a leading rule. */
function eyebrow(string $text): string
{
    return '<p class="mb-6 flex items-center gap-3 text-[13px] font-medium uppercase tracking-[0.2em] text-m-label"><span class="h-px w-8 bg-m-label/50"></span>' . e($text) . '</p>';
}

/** Editorial serif italics. */
const SERIF = 'font-[family-name:var(--font-serif)] font-normal italic';

/** A document cover lying on two blank sheets, for papers such as the thesis. */
function paper_stack(array $project, string $class = ''): string
{
    $sheet = 'absolute inset-0 rounded-[6px] bg-white/80 shadow-[0_20px_60px_rgba(0,0,0,0.35)]';
    return '<div class="relative ' . e($class) . '">'
        . '<div class="' . $sheet . ' rotate-[6deg] opacity-40"></div>'
        . '<div class="' . $sheet . ' rotate-[3deg] opacity-60"></div>'
        . '<img src="' . e(asset($project['image'])) . '" alt="' . e($project['imageAlt'] ?? $project['title']) . '" width="772" height="1000" loading="lazy" class="relative w-full rounded-[6px] shadow-[0_30px_80px_rgba(0,0,0,0.45)]">'
        . '</div>';
}

require_once __DIR__ . '/ipod.php';
