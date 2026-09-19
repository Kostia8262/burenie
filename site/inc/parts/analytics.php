<?php
/**
 * Счётчики. Пока id не заданы в config.php, на страницу не попадает ничего —
 * ни скрипта, ни cookie. Цели шлёт app.js: lead_sent и phone_click.
 */

function analytics_head(): string
{
    $out = '';

    if (METRIKA_ID !== '') {
        $id = (int) METRIKA_ID;
        $out .= <<<HTML
<script>
(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
m[i].l=1*new Date();for(var j=0;j<e.length;j++){if(e[j]===r){return}}
k=t.createElement("script"),a=t.getElementsByTagName("script")[0],k.async=1,k.src=r,
a.parentNode.insertBefore(k,a)})(window,document.scripts,"script",
"https://mc.yandex.ru/metrika/tag.js","ym");
ym($id,"init",{ssr:true,webvisor:true,clickmap:true,trackLinks:true,accurateTrackBounce:true});
window.SOS_YM = $id;
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/$id" style="position:absolute;left:-9999px" alt=""></div></noscript>
HTML;
    }

    if (GA_ID !== '') {
        $id = htmlspecialchars(GA_ID, ENT_QUOTES, 'UTF-8');
        $out .= <<<HTML
<script async src="https://www.googletagmanager.com/gtag/js?id=$id"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}
gtag("js",new Date());gtag("config","$id");
</script>
HTML;
    }

    return $out;
}
