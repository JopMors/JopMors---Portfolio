<?php
/**
 * Template for a launched project's own page. A page lives at
 * projects/<slug>/index.php, sets $slug and requires this file; the page's
 * sections are in includes/projects/<slug>.php.
 */
declare(strict_types=1);

$base = '../../';
require __DIR__ . '/helpers.php';
require __DIR__ . '/data.php';
require __DIR__ . '/content.php';

$project = null;
foreach ($projects as $candidate) {
    if (($candidate['slug'] ?? null) === $slug) {
        $project = $candidate;
    }
}
$contentFile = __DIR__ . '/projects/' . basename($slug) . '.php';
if (!$project || !is_file($contentFile)) {
    http_response_code(404);
    exit('Project not found.');
}

$pageTitle = $project['title'] . ' — ' . $site['name'];
$pageDescription = $project['description'];
$navCurrent = 'work';
?>
<!doctype html>
<html lang="en">
<head>
<?php include __DIR__ . '/head.php'; ?>
</head>
<body>
  <div class="bg-m-bg text-m-text antialiased selection:bg-m-accent/25">
<?php include __DIR__ . '/nav.php'; ?>
    <main>
<?php include $contentFile; ?>
    </main>
    <footer class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 border-t border-m-line/10 px-6 pb-24 pt-6 text-sm text-m-muted md:px-12 xl:px-0">
      <a href="<?= e(asset('#work')) ?>" class="inline-flex items-center gap-2 text-m-label link-accent">← All work</a>
      <span>© <?= date('Y') ?> <?= e($site['name']) ?></span>
    </footer>
  </div>
  <script type="module" src="<?= e(asset('assets/js/main.js')) ?>"></script>
</body>
</html>
