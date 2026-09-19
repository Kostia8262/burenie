<?php
/**
 * Фирменный элемент сайта — геологический разрез.
 *
 * core_svg()  — колонка слоёв строго в масштабе глубины (SVG).
 * core_full() — та же колонка плюс подписи слоёв обычным текстом: так они
 *               читаются, тянутся по ширине и попадают в индекс поисковиков.
 */

/** Насыщенность водяной подкраски слоя. */
function layer_water_opacity(string|bool $water): string
{
    return match ($water) {
        'лучшая'  => '.55',
        'рабочая' => '.38',
        'плохая'  => '.16',
        default   => '0',
    };
}

function core_svg(int $h = 460, int $colW = 120, bool $ticks = true): string
{
    $layers = LAYERS;
    $max  = (int) end($layers)['to'];
    $padT = 14;
    $padB = 20;
    $tickW = $ticks ? 66 : 0;
    $width = $colW + $tickW;
    $y = fn(float $m): float => $padT + ($m / $max) * ($h - $padT - $padB);

    $o = '<svg class="core__svg" viewBox="0 0 ' . $width . ' ' . $h . '" '
       . 'role="img" aria-label="Разрез грунта: типичные водоносные горизонты Донбасса от 0 до ' . $max . ' метров" '
       . 'xmlns="http://www.w3.org/2000/svg">';

    foreach ($layers as $l) {
        $y1 = $y($l['from']);
        $y2 = $y($l['to']);
        $o .= sprintf('<rect x="0" y="%.1f" width="%d" height="%.1f" fill="%s"/>',
            $y1, $colW, max(1, $y2 - $y1), $l['color']);
        if ($l['water']) {
            $o .= sprintf('<rect x="0" y="%.1f" width="%d" height="%.1f" fill="var(--sky)" opacity="%s"/>',
                $y1, $colW, max(1, $y2 - $y1), layer_water_opacity($l['water']));
        }
        $o .= sprintf('<line x1="0" y1="%.1f" x2="%d" y2="%.1f" stroke="rgba(0,0,0,.42)"/>', $y1, $colW, $y1);
    }
    $o .= sprintf('<line x1="0" y1="%.1f" x2="%d" y2="%.1f" stroke="rgba(0,0,0,.42)"/>', $y($max), $colW, $y($max));

    if ($ticks) {
        $marks = [0, 22, 45, 70, $max];
        foreach ($marks as $m) {
            $ty = $y($m);
            $o .= sprintf('<line x1="%d" y1="%.1f" x2="%d" y2="%.1f" stroke="var(--hair-deep)"/>',
                $colW, $ty, $colW + 16, $ty);
            $o .= sprintf('<text class="core__depth" x="%d" y="%.1f">%d м</text>',
                $colW + 22, $ty + 4, $m);
        }
    }

    $cx   = (int) ($colW / 2);
    $bitY = $y($max) - 7;
    $o .= sprintf('<path class="core__pipe" d="M %d 0 V %.1f" pathLength="100"/>', $cx, $bitY);
    $o .= sprintf('<polygon class="core__bit" points="%d,%.1f %d,%.1f %d,%.1f"/>',
        $cx - 7, $bitY, $cx + 7, $bitY, $cx, $bitY + 14);

    return $o . '</svg>';
}

/** Разрез с текстовыми подписями. */
function core_full(): string
{
    $o = '<div class="corex">';
    $o .= '<div class="corex__col">' . core_svg(560, 96, false) . '</div>';
    $o .= '<dl class="corex__list">';
    foreach (LAYERS as $l) {
        $o .= '<div class="corex__row">'
            . sprintf('<span class="corex__swatch" style="--sw:%s;--wo:%s" aria-hidden="true"></span>',
                $l['color'], layer_water_opacity($l['water']))
            . '<dt><span class="corex__depth mono">' . $l['from'] . '–' . $l['to'] . ' м</span> '
            . '<span class="corex__name">' . e($l['name']) . '</span></dt>'
            . '<dd>' . e($l['note']) . '</dd>'
            . '</div>';
    }
    return $o . '</dl></div>';
}
