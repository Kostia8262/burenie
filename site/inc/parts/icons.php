<?php
/**
 * Свой набор иконок: сетка 24, штрих 1.75, скруглённые концы.
 * Юникод-стрелки и эмодзи вместо иконок не используем.
 */

function icon(string $name, string $class = 'ico'): string
{
    $p = match ($name) {
        // буровая вышка над устьем
        'rig' => '<path d="M12 3v12"/><path d="M5 21 12 4l7 17"/><path d="M8.2 14h7.6"/>'
               . '<path d="M9.6 9.5h4.8"/><path d="M3 21h18"/>',
        // оголовок и труба, уходящая под землю
        'well' => '<path d="M4 9h16"/><path d="M8 9V6.5A1.5 1.5 0 0 1 9.5 5h5A1.5 1.5 0 0 1 16 6.5V9"/>'
                . '<path d="M10.5 9v11"/><path d="M13.5 9v11"/><path d="M3 20h18"/>',
        // капля в фильтре
        'drop' => '<path d="M12 3.5c3.2 3.9 5 6.9 5 9.4a5 5 0 0 1-10 0c0-2.5 1.8-5.5 5-9.4z"/>'
                . '<path d="M8.4 14.6h7.2"/><path d="M9.3 17.4h5.4"/>',
        // часы
        'clock' => '<circle cx="12" cy="12" r="9"/><path d="M12 6.8V12l3.4 2.1"/>',
        // галочка в круге
        'check' => '<circle cx="12" cy="12" r="9"/><path d="M7.9 12.3 11 15.4l5.2-6"/>',
        // стрелка вправо
        'arrow' => '<path d="M4.5 12h15"/><path d="m13.6 6.2 5.9 5.8-5.9 5.8"/>',
        // телефон
        'phone' => '<path d="M6.3 3.8h3l1.4 3.6-1.9 1.4a11 11 0 0 0 5.4 5.4l1.4-1.9 3.6 1.4v3a2 2 0 0 1-2.2 2A16.5 16.5 0 0 1 4.3 6 2 2 0 0 1 6.3 3.8z"/>',
        default => '',
    };

    return '<svg class="' . $class . '" viewBox="0 0 24 24" fill="none" '
        . 'stroke="currentColor" stroke-width="1.75" stroke-linecap="round" '
        . 'stroke-linejoin="round" aria-hidden="true">' . $p . '</svg>';
}

/** Иконка группы услуг. */
function group_icon(string $group): string
{
    return icon(match ($group) {
        'burenie'      => 'rig',
        'obustroystvo' => 'well',
        default        => 'drop',
    }, 'ico ico--lg');
}
