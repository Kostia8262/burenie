<?php
/** Мелкие функции, которыми пользуются шаблоны. */

function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Телефон в виде, пригодном для href="tel:". */
function tel_href(string $phone): string
{
    return 'tel:' . preg_replace('/[^\d+]/', '', $phone);
}

function main_phone(): string
{
    return SITE['phones'][0];
}

/** Внутренняя ссылка с учётом подпапки (нужно для превью-стенда). */
function u(string $path): string
{
    return BASE . $path;
}

/** Абсолютный URL страницы. */
function abs_url(string $path): string
{
    return SITE['base'] . $path;
}

function service_path(string $slug): string
{
    return '/uslugi/' . $slug . '/';
}

function city_path(string $slug): string
{
    return '/geografiya/' . $slug . '/';
}

function article_path(string $slug): string
{
    return '/stati/' . $slug . '/';
}

function service_url(string $slug): string
{
    return u(service_path($slug));
}

function city_url(string $slug): string
{
    return u(city_path($slug));
}

function article_url(string $slug): string
{
    return u(article_path($slug));
}

/** Услуги одной группы. */
function services_in(string $group): array
{
    return array_filter(SERVICES, fn($s) => $s['group'] === $group);
}

/** Дата статьи по-русски. */
function ru_date(string $iso): string
{
    static $m = [1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня',
        'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
    $t = strtotime($iso);
    return (int) date('j', $t) . ' ' . $m[(int) date('n', $t)] . ' ' . date('Y', $t);
}

/**
 * Время чтения статьи — считается по её же тексту, а не выдумывается.
 * 180 слов в минуту, теги выброшены, меньше минуты не показываем.
 */
function read_time(string $slug): int
{
    static $cache = [];
    if (isset($cache[$slug])) {
        return $cache[$slug];
    }
    $file = __DIR__ . '/../content/articles/' . $slug . '.php';
    if (!is_file($file)) {
        return $cache[$slug] = 1;
    }
    // PHP-вставки внутри атрибутов ломают strip_tags: он глотает текст до
    // следующего '>'. Поэтому сначала выкидываем сами вставки.
    $raw  = preg_replace('/<\?.*?\?>/s', ' ', (string) file_get_contents($file));
    $text = strip_tags((string) $raw);
    $words = preg_match_all('/[\p{L}\p{N}]+/u', $text);
    return $cache[$slug] = max(1, (int) round($words / 180));
}

/** Склонение: 1 скважина / 2 скважины / 5 скважин. */
function plural(int $n, string $one, string $few, string $many): string
{
    $n = abs($n) % 100;
    $n1 = $n % 10;
    if ($n > 10 && $n < 20) return $many;
    if ($n1 > 1 && $n1 < 5) return $few;
    if ($n1 === 1) return $one;
    return $many;
}

/** Хлебные крошки: [['Название','/url'], ...]. Последний — без ссылки. */
function crumbs(array $items): string
{
    $out = '<nav class="crumbs wrap" aria-label="Хлебные крошки">';
    $ld = [];
    $n = count($items);
    foreach ($items as $i => [$title, $url]) {
        $ld[] = [
            '@type'    => 'ListItem',
            'position' => $i + 1,
            'name'     => $title,
            'item'     => abs_url($url),
        ];
        if ($i === $n - 1) {
            $out .= '<span aria-current="page">' . e($title) . '</span>';
        } else {
            $out .= '<a href="' . e(u($url)) . '">' . e($title) . '</a><span>/</span>';
        }
    }
    $out .= '</nav>';
    $out .= schema([
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => $ld,
    ]);
    return $out;
}

function schema(array $data): string
{
    return '<script type="application/ld+json">'
        . json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        . '</script>';
}

/**
 * Иллюстрация-схема из assets/img/illu/. Если файла нет — пустая строка,
 * поэтому новая услуга или статья без картинки просто выводится без неё.
 * Это рисунки, а не снимки объектов: своих фото у нас почти нет.
 */
function illu(string $name, string $class, bool $lazy = true): string
{
    $rel = '/assets/img/illu/' . $name . '.webp';
    $file = __DIR__ . '/..' . $rel;
    if (!is_file($file)) {
        return '';
    }
    [$w, $h] = @getimagesize($file) ?: [640, 480];
    return '<img class="' . e($class) . '" src="' . e(u($rel)) . '" alt="" width="' . $w
        . '" height="' . $h . '"' . ($lazy ? ' loading="lazy"' : ' fetchpriority="high"')
        . ' decoding="async">';
}
