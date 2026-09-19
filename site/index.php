<?php
/**
 * Фронт-контроллер. Все запросы приходят сюда через .htaccess.
 */

declare(strict_types=1);

const ASSET_V = '2026091901';

// Префикс, если сайт лежит в подпапке (превью-стенд). В бою — пустая строка.
// SOS_BASE задаётся только при статическом рендере (tools/render-static.php).
define('BASE', getenv('SOS_BASE') !== false
    ? rtrim((string) getenv('SOS_BASE'), '/')
    : rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'), chr(47) . chr(92)));

require __DIR__ . '/inc/config.php';
require __DIR__ . '/inc/helpers.php';
require __DIR__ . '/inc/core.php';
require __DIR__ . '/inc/layout.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$path = rawurldecode($path);
if (BASE !== '' && str_starts_with($path, BASE)) {
    $path = substr($path, strlen(BASE)) ?: '/';
}

// один канонический вид: всегда со слешем на конце, всегда в нижнем регистре
if ($path !== '/' && !str_ends_with($path, '/') && !str_contains(basename($path), '.')) {
    header('Location: ' . BASE . $path . '/', true, 301);
    exit;
}

$_SERVER['REQUEST_PATH'] = $path;
$seg = array_values(array_filter(explode('/', $path), 'strlen'));

/** Отдать страницу и закончить. */
function view(string $file, array $vars = []): never
{
    extract($vars, EXTR_SKIP);
    require __DIR__ . '/pages/' . $file . '.php';
    exit;
}

function not_found(): never
{
    http_response_code(404);
    view('404');
}

// ---- карта сайта -----------------------------------------------------------

if ($path === '/sitemap.xml') {
    header('Content-Type: application/xml; charset=utf-8');
    require __DIR__ . '/pages/sitemap.php';
    exit;
}

// ---- приём заявки ----------------------------------------------------------

if ($path === '/zayavka/' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    require __DIR__ . '/inc/lead.php';
    exit;
}

// ---- маршруты --------------------------------------------------------------

switch ($seg[0] ?? '') {
    case '':
        view('home');

    case 'uslugi':
        if (!isset($seg[1])) view('services');
        if (!isset(SERVICES[$seg[1]])) not_found();
        view('service', ['slug' => $seg[1], 'svc' => SERVICES[$seg[1]]]);

    case 'ceny':
        view('prices');

    case 'geografiya':
        if (!isset($seg[1])) view('geo');
        if (!isset(CITIES[$seg[1]])) not_found();
        view('city', ['slug' => $seg[1], 'city' => CITIES[$seg[1]]]);

    case 'stati':
        if (!isset($seg[1])) view('blog');
        if (!isset(ARTICLES[$seg[1]])) not_found();
        view('article', ['slug' => $seg[1], 'art' => ARTICLES[$seg[1]]]);

    case 'o-kompanii':
        view('about');

    case 'kontakty':
        view('contacts');

    case 'rekvizity':
        view('bank');

    case 'politika':
        view('privacy');

    case 'spasibo':
        view('thanks');
}

not_found();
