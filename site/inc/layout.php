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
<?php if (empty($m['nocanonical'])): ?>
<link rel="canonical" href="<?= e(abs_url($path)) ?>">
<?php endif; ?>
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
<?php if (empty($m['nocanonical'])): ?>
<meta property="og:url" content="<?= e(abs_url($path)) ?>">
<?php endif; ?>
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
    echo schema(site_graph($m));
    if (!empty($m['schema'])) {
        echo schema($m['schema']);
    }
    // 'schemas' — когда странице нужно больше одной сущности: например
    // услуга (Service) и её вопросы (FAQPage) сразу.
    foreach ($m['schemas'] ?? [] as $extra) {
        echo schema($extra);
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

/**
 * Общая разметка, единая для всех страниц: организация, сайт и текущая
 * страница одним @graph со ссылками друг на друга. Раздельные блоки
 * поисковик тоже прочитает, но связать в одну карточку компании ему сложнее,
 * а ИИ-ответы Яндекса и Google собираются именно из связанных сущностей.
 */
function site_graph(array $m): array
{
    $path  = $m['path'] ?? '/';
    $title = $m['title'] ?? SITE['name'];
    $desc  = $m['desc'] ?? '';

    $org = [
        '@type'       => 'LocalBusiness',
        '@id'         => SITE['base'] . '/#org',
        'name'        => SITE['name'],
        'legalName'   => SITE['legal'],
        'description' => 'Бурение и обустройство скважин на воду в Донецке, Макеевке '
                       . 'и по всей ДНР: малогабаритная установка, паспорт скважины, гарантия на работы.',
        'url'         => SITE['base'],
        'telephone'   => SITE['phones'],
        'email'       => SITE['email'],
        'taxID'       => SITE['inn'],
        'vatID'       => SITE['inn'],
        'identifier'  => [
            '@type' => 'PropertyValue',
            'name'  => 'ИНН',
            'value' => SITE['inn'],
        ],
        'image'   => abs_url('/assets/img/og.jpg'),
        'logo'    => [
            '@type'  => 'ImageObject',
            '@id'    => SITE['base'] . '/#logo',
            'url'    => abs_url('/assets/img/icon-512.png'),
            'width'  => 512,
            'height' => 512,
        ],
        'sameAs'        => [SITE['tg']],
        'priceRange'    => '₽₽',
        'currenciesAccepted' => 'RUB',
        'paymentAccepted'    => 'Наличные, банковский перевод',
        'knowsLanguage' => 'ru',
        'slogan'        => 'От первого метра до воды в кране',
        'contactPoint'  => [[
            '@type'             => 'ContactPoint',
            'contactType'       => 'customer service',
            'telephone'         => SITE['phones'][0],
            'email'             => SITE['email'],
            'areaServed'        => 'RU-DPR',
            'availableLanguage' => 'Russian',
        ]],
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
        // строкой openingHours поисковики читают хуже — отдаём разбором
        'openingHoursSpecification' => [[
            '@type'     => 'OpeningHoursSpecification',
            'dayOfWeek' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday',
                            'Friday', 'Saturday', 'Sunday'],
            'opens'     => '08:00',
            'closes'    => '20:00',
        ]],
        'areaServed'   => array_values(array_map(
            fn($c) => ['@type' => 'City', 'name' => $c['name']],
            CITIES
        )),
        'hasOfferCatalog' => offer_catalog(),
    ];

    $site = [
        '@type'      => 'WebSite',
        '@id'        => SITE['base'] . '/#website',
        'url'        => SITE['base'],
        'name'       => SITE['name'],
        'inLanguage' => 'ru-RU',
        'publisher'  => ['@id' => SITE['base'] . '/#org'],
    ];

    $page = [
        '@type'      => 'WebPage',
        '@id'        => abs_url($path) . '#webpage',
        'url'        => abs_url($path),
        'name'       => $title,
        'inLanguage' => 'ru-RU',
        'isPartOf'   => ['@id' => SITE['base'] . '/#website'],
        'about'      => ['@id' => SITE['base'] . '/#org'],
        'publisher'  => ['@id' => SITE['base'] . '/#org'],
    ];
    if ($desc !== '') {
        $page['description'] = $desc;
    }
    // Абзац, который ИИ-поисковику разрешено зачитать вслух как прямой ответ.
    if (!empty($m['speakable'])) {
        $page['speakable'] = [
            '@type'       => 'SpeakableSpecification',
            'cssSelector' => $m['speakable'],
        ];
    }

    return [
        '@context' => 'https://schema.org',
        '@graph'   => [$org, $site, $page],
    ];
}

/**
 * Каталог услуг для схемы организации: группы из SERVICE_GROUPS, внутри —
 * услуги этой группы.
 *
 * Цена появляется только у проходки и только как «за один метр». Голым
 * 'price' => 3000 поисковик прочитал бы «скважина за 3000 рублей», и в
 * ИИ-ответе эта цифра уйдёт к человеку без единой оговорки — поэтому здесь
 * UnitPriceSpecification с referenceQuantity в метрах и minPrice, раз цена
 * «от». Условие отбора то же, что у видимого чипа на странице услуги
 * (pages/service.php), чтобы разметка не обещала больше, чем говорит текст.
 */
function offer_catalog(): array
{
    $groups = [];
    foreach (SERVICE_GROUPS as $group => $label) {
        $items = [];
        foreach (services_in($group) as $slug => $s) {
            $offer = [
                '@type'       => 'Offer',
                'url'         => abs_url(service_path($slug)),
                'itemOffered' => [
                    '@type'       => 'Service',
                    'name'        => $s['title'],
                    'description' => $s['short'],
                    'url'         => abs_url(service_path($slug)),
                    'serviceType' => $label,
                    'provider'    => ['@id' => SITE['base'] . '/#org'],
                ],
            ];
            if ($price = drill_price_spec($s)) {
                $offer['priceSpecification'] = $price;
            }
            $items[] = $offer;
        }
        if ($items) {
            $groups[] = [
                '@type'           => 'OfferCatalog',
                'name'            => $label,
                'itemListElement' => $items,
            ];
        }
    }
    return [
        '@type'           => 'OfferCatalog',
        'name'            => 'Услуги ' . SITE['name'],
        'itemListElement' => $groups,
    ];
}

/**
 * Цена проходки за метр — или null, если услуга метрами не считается.
 * Обсадная труба, обустройство и насос в неё не входят: об этом говорит и
 * страница цен, и главная, поэтому то же сказано в description.
 */
function drill_price_spec(array $svc): ?array
{
    if (!PRICES_CONFIRMED
        || ($svc['group'] ?? '') !== 'burenie'
        || ($svc['unit'] ?? '') !== 'метр') {
        return null;
    }
    return [
        '@type'             => 'UnitPriceSpecification',
        'minPrice'          => PRICE_DRILL_FROM,
        'priceCurrency'     => 'RUB',
        'unitCode'          => 'MTR',
        'referenceQuantity' => [
            '@type'    => 'QuantitativeValue',
            'value'    => 1,
            'unitCode' => 'MTR',
        ],
        'description' => 'Проходка в обычном грунте. Обсадная труба, обустройство '
                       . 'и насос считаются отдельно, по известняку дороже.',
    ];
}

function page_end(): void
{
    include __DIR__ . '/parts/footer.php';
}
