<?php
/**
 * Каталог услуг: в каждой группе одна главная услуга крупно, остальные —
 * строками. Одинаковая сетка плиток на 16 позиций не даёт никакой иерархии.
 */
function service_directory(): string
{
    $o = '';
    foreach (SERVICE_GROUPS as $gk => $gname) {
        $list = services_in($gk);
        $lead = FEATURED[$gk];
        $feat = $list[$lead];
        unset($list[$lead]);

        $o .= '<div class="dir">';
        $o .= '<div class="dir__head">' . group_icon($gk)
            . '<div><h2>' . e($gname) . '</h2><p>' . e(GROUP_LEAD[$gk]) . '</p></div></div>';

        $o .= '<div class="dir__body">';
        $o .= '<a class="feat" href="' . e(service_url($lead)) . '">'
            . '<span class="feat__art"><img src="' . e(u('/assets/img/illu/' . $gk . '.webp'))
            . '" alt="" width="640" height="560" loading="lazy" decoding="async"></span>'
            . '<h3>' . e($feat['title']) . '</h3>'
            . '<p>' . e($feat['short']) . '</p>'
            . (empty($feat['bullets']) ? '' :
                '<ul class="feat__list">'
                . implode('', array_map(fn($b) => '<li>' . e($b) . '</li>', $feat['bullets']))
                . '</ul>')
            . '<span class="more">Подробнее об услуге' . icon('arrow') . '</span>'
            . '</a>';

        $o .= '<ul class="rows">';
        foreach ($list as $slug => $s) {
            $o .= '<li><a class="row" href="' . e(service_url($slug)) . '">'
                . '<b>' . e($s['title']) . '</b>'
                . icon('arrow')
                . '<span>' . e($s['short']) . '</span>'
                . '</a></li>';
        }
        $o .= '</ul></div></div>';
    }
    return $o;
}

/** Полоса-разрез между крупными блоками страницы. */
function strata_rule(): string
{
    $layers = LAYERS;
    $max = (int) end($layers)['to'];
    $o = '<div class="strata" aria-hidden="true">';
    foreach ($layers as $l) {
        $w = ($l['to'] - $l['from']) / $max * 100;
        $o .= sprintf('<i style="flex:%.2f;background:%s"></i>', $w, $l['color']);
    }
    return $o . '</div>';
}
