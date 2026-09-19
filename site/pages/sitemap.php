<?php
/**
 * Карта сайта. Отдаётся по /sitemap.xml
 * Служебные страницы (политика, реквизиты, согласие, спасибо) сюда не попадают —
 * они закрыты в robots.txt и помечены noindex.
 */
$urls = [
    ['/', '1.0', null],
    ['/uslugi/', '0.9', null],
    ['/ceny/', '0.9', null],
    ['/geografiya/', '0.8', null],
    ['/stati/', '0.8', null],
    ['/o-kompanii/', '0.6', null],
    ['/kontakty/', '0.7', null],
];
foreach (SERVICES as $slug => $s) $urls[] = [service_path($slug), '0.9', null];
foreach (CITIES as $slug => $c)   $urls[] = [city_path($slug), '0.8', null];
// у статей дата настоящая — её и отдаём
foreach (ARTICLES as $slug => $a) $urls[] = [article_path($slug), '0.7', $a['date']];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as [$u, $p, $mod]) {
    echo '  <url><loc>' . htmlspecialchars(abs_url($u), ENT_XML1) . '</loc>'
       . ($mod ? '<lastmod>' . $mod . '</lastmod>' : '')
       . '<changefreq>monthly</changefreq><priority>' . $p . "</priority></url>\n";
}
echo "</urlset>\n";
