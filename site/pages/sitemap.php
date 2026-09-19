<?php
/** Карта сайта. Отдаётся по /sitemap.xml */
$urls = [['/', '1.0'], ['/uslugi/', '0.9'], ['/ceny/', '0.9'], ['/geografiya/', '0.8'], ['/stati/', '0.8'], ['/o-kompanii/', '0.6'], ['/kontakty/', '0.7']];
foreach (SERVICES as $slug => $s) $urls[] = [service_path($slug), '0.9'];
foreach (CITIES as $slug => $c)   $urls[] = [city_path($slug), '0.8'];
foreach (ARTICLES as $slug => $a) $urls[] = [article_path($slug), '0.7'];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as [$u, $p]) {
    echo "  <url><loc>" . htmlspecialchars(abs_url($u), ENT_XML1) . "</loc>"
       . "<changefreq>monthly</changefreq><priority>$p</priority></url>\n";
}
echo "</urlset>\n";
