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

/**
 * Условные обозначения пород: узор вместо плоской заливки.
 * Ключ берём из имени переменной цвета (--l-sand → sand).
 */
function layer_key(string $color): string
{
    return preg_match('/--l-([a-z-]+)/', $color, $m) ? $m[1] : '';
}

function core_patterns(string $uid): string
{
    $d  = 'rgba(0,0,0,.30)';
    $d2 = 'rgba(0,0,0,.20)';
    $lt = 'rgba(255,255,255,.28)';

    $o = '<defs>';

    // почва: перегной — крапины и короткие корешки
    $o .= '<pattern id="' . $uid . '-soil" width="14" height="12" patternUnits="userSpaceOnUse">'
        . '<path fill="none" d="M2 3v3M9 6v3" stroke="' . $d . '" stroke-width="1.1" stroke-linecap="round"/>'
        . '<circle cx="11" cy="2" r="1.1" fill="' . $d . '"/>'
        . '<circle cx="5" cy="9" r="1.3" fill="' . $d2 . '"/>'
        . '</pattern>';

    // суглинок: прерывистая горизонтальная штриховка вразбежку
    $o .= '<pattern id="' . $uid . '-loam" width="18" height="11" patternUnits="userSpaceOnUse">'
        . '<path fill="none" d="M0 3h8M10 8h8" stroke="' . $d . '" stroke-width="1.2" stroke-linecap="round"/>'
        . '<circle cx="14" cy="3" r="1" fill="' . $d2 . '"/>'
        . '<circle cx="4" cy="8" r="1" fill="' . $d2 . '"/>'
        . '</pattern>';

    // песок: классический крап
    $o .= '<pattern id="' . $uid . '-sand" width="11" height="11" patternUnits="userSpaceOnUse">'
        . '<circle cx="2" cy="2.5" r="1.15" fill="' . $d . '"/>'
        . '<circle cx="7.5" cy="5" r="1" fill="' . $d2 . '"/>'
        . '<circle cx="4" cy="8.5" r="1.1" fill="' . $d . '"/>'
        . '<circle cx="9.5" cy="9.5" r=".9" fill="' . $d2 . '"/>'
        . '</pattern>';

    // водоносный песок: тот же крап плюс светлые блики — зерно в воде
    $o .= '<pattern id="' . $uid . '-sand-wet" width="11" height="11" patternUnits="userSpaceOnUse">'
        . '<circle cx="2" cy="2.5" r="1.15" fill="' . $d . '"/>'
        . '<circle cx="7.5" cy="5" r="1" fill="' . $d2 . '"/>'
        . '<circle cx="4" cy="8.5" r="1.1" fill="' . $d . '"/>'
        . '<circle cx="9.5" cy="2" r=".9" fill="' . $lt . '"/>'
        . '<circle cx="6" cy="9.8" r=".8" fill="' . $lt . '"/>'
        . '</pattern>';

    // плотная глина: частая сплошная горизонтальная штриховка
    $o .= '<pattern id="' . $uid . '-clay" width="14" height="7" patternUnits="userSpaceOnUse">'
        . '<path fill="none" d="M0 2.5h14" stroke="' . $d2 . '" stroke-width="1"/>'
        . '<path fill="none" d="M3 5.5h8" stroke="' . $d . '" stroke-width="1" stroke-linecap="round"/>'
        . '</pattern>';

    // известняк: кирпичная кладка
    $o .= '<pattern id="' . $uid . '-lime" width="22" height="14" patternUnits="userSpaceOnUse">'
        . '<path fill="none" d="M0 .5h22M0 7.5h22" stroke="' . $d . '" stroke-width="1"/>'
        . '<path fill="none" d="M11 .5v7M0 7.5v6.5M22 7.5v6.5" stroke="' . $d . '" stroke-width="1"/>'
        . '</pattern>';

    return $o . '</defs>';
}

function core_svg(int $h = 460, int $colW = 120, bool $ticks = true): string
{
    static $seq = 0;

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

    $uid = 'core' . ++$seq;
    $o .= core_patterns($uid);

    foreach ($layers as $l) {
        $y1 = $y($l['from']);
        $y2 = $y($l['to']);
        $o .= sprintf('<rect x="0" y="%.1f" width="%d" height="%.1f" fill="%s"/>',
            $y1, $colW, max(1, $y2 - $y1), $l['color']);
        if ($l['water']) {
            $o .= sprintf('<rect x="0" y="%.1f" width="%d" height="%.1f" fill="var(--sky)" opacity="%s"/>',
                $y1, $colW, max(1, $y2 - $y1), layer_water_opacity($l['water']));
        }
        if ($key = layer_key($l['color'])) {
            $o .= sprintf('<rect x="0" y="%.1f" width="%d" height="%.1f" fill="url(#%s-%s)"/>',
                $y1, $colW, max(1, $y2 - $y1), $uid, $key);
        }
        $o .= sprintf('<line x1="0" y1="%.1f" x2="%d" y2="%.1f" stroke="rgba(0,0,0,.42)"/>', $y1, $colW, $y1);
    }
    $o .= sprintf('<line x1="0" y1="%.1f" x2="%d" y2="%.1f" stroke="rgba(0,0,0,.42)"/>', $y($max), $colW, $y($max));

    if ($ticks) {
        $marks = [0, 22, 45, 70, $max];
        foreach ($marks as $m) {
            $ty = $y($m);
            $o .= sprintf('<line x1="%d" y1="%.1f" x2="%d" y2="%.1f" stroke="var(--line-deep)"/>',
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
    $o .= '<div class="corex__col">' . core_svg(400, 116, false) . '</div>';
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
