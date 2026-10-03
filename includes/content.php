<?php
/** Values derived from data.php that several sections share. */

/** Education and experience merged into one timeline, newest first. */
$background = array_merge(
    array_map(fn ($e) => [
        'kind' => 'work',
        'org' => $e['company'],
        'title' => $e['role'],
        'period' => $e['period'],
        'start' => start_year($e['period']),
        'ongoing' => is_ongoing($e['period']),
        'body' => $e['description'],
        'link' => null,
    ], $experience),
    array_map(fn ($e) => [
        'kind' => 'study',
        'org' => $e['institution'],
        'title' => $e['degree'],
        'period' => $e['period'],
        'start' => start_year($e['period']),
        'ongoing' => is_ongoing($e['period']),
        'body' => $e['detail'],
        'link' => $e['link'] ?? null,
    ], $education),
);
usort($background, fn ($a, $b) => $b['start'] <=> $a['start']);

/** "Developer · Designer · Problem Solver" → ["Developer", "Designer", "Problem Solver"] */
$roles = array_map('trim', explode('·', $site['role']));

$contactChannels = [
    ['id' => 'email', 'label' => 'Email', 'value' => $site['email'], 'href' => 'mailto:' . $site['email']],
    ['id' => 'linkedin', 'label' => 'LinkedIn', 'value' => 'Connect', 'href' => $site['socials']['linkedin']],
    ['id' => 'github', 'label' => 'GitHub', 'value' => 'See the code', 'href' => $site['socials']['github']],
];

/** Today as a fractional year (e.g. 2026.75), for "x years" labels. */
$now = (int) date('Y') + ((int) date('n') - 1) / 12;
