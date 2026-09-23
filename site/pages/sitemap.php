<?php
/**
 * Карта сайта. Отдаётся по /sitemap.xml
 * Служебные страницы (политика, реквизиты, согласие, спасибо) сюда не попадают —
 * они закрыты в robots.txt и помечены noindex.
 */
/**
 * Когда последний раз правили тексты услуг, городов и постоянных страниц.
 * У статей дата своя, настоящая; для остальных страниц отдельной даты нет,
 * поэтому дату держим здесь и поднимаем руками при правке текстов. Привязывать
 * её к выкатке нельзя: тогда lastmod врал бы при каждом изменении вёрстки.
 */
const CONTENT_UPDATED = '2026-09-24';

/** Список статей «обновился» тогда, когда вышла самая свежая из них. */
function articles_last_date(): string
{
    $dates = array_column(ARTICLES, 'date');
    return $dates ? max($dates) : CONTENT_UPDATED;
}

$urls = [
    ['/', '1.0', CONTENT_UPDATED],
    ['/uslugi/', '0.9', CONTENT_UPDATED],
    ['/ceny/', '0.9', CONTENT_UPDATED],
    ['/geografiya/', '0.8', CONTENT_UPDATED],
    ['/stati/', '0.8', articles_last_date()],
    ['/raboty/', '0.7', CONTENT_UPDATED],
    ['/garantiya/', '0.7', CONTENT_UPDATED],
    ['/o-kompanii/', '0.6', CONTENT_UPDATED],
    ['/kontakty/', '0.7', CONTENT_UPDATED],
];
foreach (SERVICES as $slug => $s) $urls[] = [service_path($slug), '0.9', CONTENT_UPDATED];
foreach (CITIES as $slug => $c)   $urls[] = [city_path($slug), '0.8', CONTENT_UPDATED];
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
