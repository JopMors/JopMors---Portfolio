<?php
$pageTitle = $pageTitle ?? $site['name'] . ' — ' . $site['role'];
$pageDescription = $pageDescription ?? $site['description'];
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <meta name="description" content="<?= e($pageDescription) ?>">
  <meta name="theme-color" content="#242426">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="<?= e($site['name']) ?> — Portfolio">
  <meta property="og:title" content="<?= e($pageTitle) ?>">
  <meta property="og:description" content="<?= e($pageDescription) ?>">
  <meta property="og:url" content="<?= e($site['url']) ?>">
  <meta property="og:image" content="<?= e(rtrim($site['url'], '/') . '/assets/img/og.png') ?>">
  <meta name="twitter:card" content="summary_large_image">
  <link rel="icon" type="image/png" href="<?= asset('assets/img/favicon.png') ?>">

  <link rel="preload" href="<?= asset('assets/fonts/Geist-Variable.woff2') ?>" as="font" type="font/woff2" crossorigin>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&display=swap">

  <link rel="stylesheet" href="<?= asset('assets/css/tailwind.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/liquid-glass.css') ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/site.css') ?>">
  <noscript>
    <style>
      [data-reveal], [data-word] { opacity: 1 !important; transform: none !important; filter: none !important; }
      [data-hero-stage] { visibility: visible !important; }
    </style>
  </noscript>
