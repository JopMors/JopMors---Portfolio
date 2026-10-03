<?php
declare(strict_types=1);

require __DIR__ . '/includes/helpers.php';
require __DIR__ . '/includes/data.php';
require __DIR__ . '/includes/content.php';
?>
<!doctype html>
<html lang="en">
<head>
<?php include __DIR__ . '/includes/head.php'; ?>
</head>
<body>
  <div class="bg-m-bg text-m-text antialiased selection:bg-m-accent/25">
<?php include __DIR__ . '/includes/nav.php'; ?>
    <main>
<?php
// The page, top to bottom. Reorder or remove sections here.
include __DIR__ . '/includes/hero.php';
include __DIR__ . '/includes/statement.php';
include __DIR__ . '/includes/about.php';
include __DIR__ . '/includes/what-i-do.php';
include __DIR__ . '/includes/work.php';
include __DIR__ . '/includes/capabilities.php';
include __DIR__ . '/includes/timeline.php';
include __DIR__ . '/includes/contact.php';
?>
    </main>
  </div>
  <script type="module" src="assets/js/main.js"></script>
</body>
</html>
