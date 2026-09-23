<?php
/**
 * Обёртка страницы. Использование:
 *   page_start(['title'=>..., 'desc'=>..., 'path'=>'/uslugi/']);
 *   ... разметка ...
 *   page_end();
 */

function page_start(array $m): void
{
    $title = $m['title'] ?? SITE['name'];
    $desc  = $m['desc'] ?? '';
    $path  = $m['path'] ?? '/';
    $og    = $m['og'] ?? '/assets/img/og.jpg';
    ?>
<!doctype html>
<html lang="ru">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($title) ?></title>
<meta name="description" content="<?= e($desc) ?>">
<link rel="canonical" href="<?= e(abs_url($path)) ?>">
<?php if (!empty($m['noindex'])): ?>
<meta name="robots" content="noindex, follow">
<?php endif; ?>
<meta name="theme-color" content="#ffffff">
<?php if (GSC_VERIFY !== ''): ?>
<meta name="google-site-verification" content="<?= e(GSC_VERIFY) ?>">
<?php endif; ?>
<meta property="og:type" content="<?= e($m['ogtype'] ?? 'website') ?>">
<meta property="og:locale" content="ru_RU">
<meta property="og:site_name" content="<?= e(SITE['name']) ?>">
<meta property="og:title" content="<?= e($title) ?>">
<meta property="og:description" content="<?= e($desc) ?>">
<meta property="og:url" content="<?= e(abs_url($path)) ?>">
<meta property="og:image" content="<?= e(abs_url($og)) ?>">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= e(u('/favicon.ico')) ?>" sizes="32x32">
<link rel="icon" href="<?= e(u('/assets/img/favicon.svg')) ?>" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= e(u('/assets/img/touch-icon.png')) ?>">
<link rel="manifest" href="<?= e(u('/manifest.webmanifest')) ?>">
<link rel="preload" href="<?= e(u('/assets/fonts/onest-400-cyrillic.woff2')) ?>" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="<?= e(u('/assets/fonts/onest-700-cyrillic.woff2')) ?>" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(u('/assets/css/main.css')) ?>?v=<?= ASSET_V ?>">
<?php
    echo schema([
        '@context'   => 'https://schema.org',
        '@type'      => 'LocalBusiness',
        '@id'        => SITE['base'] . '/#org',
        'name'       => SITE['name'],
        'legalName'  => SITE['legal'],
        'url'        => SITE['base'],
        'telephone'  => SITE['phones'],
        'email'      => SITE['email'],
        'taxID'      => SITE['inn'],
        'image'      => abs_url('/assets/img/og.jpg'),
        'priceRange' => '₽₽',
        'address'    => [
            '@type'           => 'PostalAddress',
            'addressLocality' => SITE['city'],
            'addressRegion'   => SITE['region'],
            'streetAddress'   => 'ул. Фёдора Зайцева, 75',
            'addressCountry'  => 'RU',
        ],
        'geo' => [
            '@type'     => 'GeoCoordinates',
            'latitude'  => SITE['lat'],
            'longitude' => SITE['lon'],
        ],
        'openingHours' => 'Mo-Su 08:00-20:00',
        'areaServed'   => array_values(array_map(
            fn($c) => ['@type' => 'City', 'name' => $c['name']],
            CITIES
        )),
    ]);
    if (!empty($m['schema'])) {
        echo schema($m['schema']);
    }
    echo analytics_head();
    ?>
</head>
<body>
<a class="skip" href="#main">Перейти к содержанию</a>
<?php include __DIR__ . '/parts/header.php'; ?>
<main id="main">
<?php
}

function page_end(): void
{
    include __DIR__ . '/parts/footer.php';
}
