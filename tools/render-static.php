<?php
/**
 * Рендер сайта в статический HTML — для превью на домене, где нет PHP.
 *
 *   php render-static.php <папка сайта> <папка результата> <префикс>
 *
 * Пример:
 *   php render-static.php ~/www/sos-bureniednr.ru/_preview /tmp/static /burenie-preview
 *
 * Формы в статике не отправляются: это превью внешнего вида, не рабочий стенд.
 */

declare(strict_types=1);

[$src, $out, $base] = [
    rtrim($argv[1] ?? '', '/'),
    rtrim($argv[2] ?? '', '/'),
    rtrim($argv[3] ?? '', '/'),
];

if ($src === '' || $out === '') {
    fwrite(STDERR, "usage: render-static.php <src> <out> [base]\n");
    exit(1);
}

// index.php вычисляет BASE из SCRIPT_NAME — подсовываем нужный префикс
$_SERVER['SCRIPT_NAME']   = $base . '/index.php';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['HTTP_HOST']      = 'sos-bureniednr.ru';

require $src . '/inc/config.php';

$paths = ['/', '/uslugi/', '/ceny/', '/geografiya/', '/stati/', '/o-kompanii/',
          '/kontakty/', '/rekvizity/', '/politika/', '/soglasie/', '/usloviya/', '/spasibo/'];
foreach (array_keys(SERVICES) as $s) $paths[] = '/uslugi/' . $s . '/';
foreach (array_keys(CITIES)   as $c) $paths[] = '/geografiya/' . $c . '/';
foreach (array_keys(ARTICLES) as $a) $paths[] = '/stati/' . $a . '/';

$ok = 0;
$fail = [];

foreach ($paths as $p) {
    $_SERVER['REQUEST_URI'] = $base . $p;

    // index.php завершается через exit() — ловим вывод в отдельном процессе
    $cmd = sprintf(
        'SOS_BASE=%s REQUEST_URI=%s php -f %s',
        escapeshellarg($base),
        escapeshellarg($base . $p),
        escapeshellarg($src . '/index.php')
    );
    $html = shell_exec($cmd);

    if (!$html || !str_contains($html, '</html>')) {
        $fail[] = $p;
        continue;
    }

    $dir = $out . rtrim($p, '/');
    @mkdir($dir, 0755, true);
    file_put_contents($dir . '/index.html', $html);
    $ok++;
}

// карта сайта — отдельно, это XML
echo "готово: $ok страниц\n";
if ($fail) {
    echo "не отрендерились:\n  " . implode("\n  ", $fail) . "\n";
    exit(1);
}
