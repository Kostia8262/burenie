<?php
$cur = $_SERVER['REQUEST_PATH'] ?? '/';

/** Пункт меню активен, если открыта его страница или его подпункт. */
$nav_active = function (array $item) use ($cur): bool {
    if (!empty($item['sub'])) {
        foreach ($item['sub'] as $slug) {
            if ($cur === service_path($slug)) {
                return true;
            }
        }
        return false;
    }
    return $item['u'] !== '/uslugi/' && str_starts_with($cur, $item['u']);
};
?>
<header class="hdr">
  <div class="wrap hdr__in">
    <a class="logo" href="<?= e(u('/')) ?>" aria-label="<?= e(SITE['name']) ?> — на главную">
      <?php include __DIR__ . '/logo.php'; ?>
      <span class="logo__txt">
        <span class="logo__name">СОС Бурение</span>
        <span class="logo__sub">Донецк · ДНР</span>
      </span>
    </a>

    <nav class="nav" id="nav" aria-label="Основное меню">
      <?php foreach (NAV as $i => $item):
          $active = $nav_active($item);

          if (empty($item['sub'])): ?>
            <a class="nav__link" href="<?= e(u($item['u'])) ?>"<?= $active ? ' aria-current="page"' : '' ?>><?= e($item['t']) ?></a>
          <?php else:
            $id = 'submenu-' . $i; ?>
            <div class="nav__item" data-submenu>
              <button class="nav__link nav__toggle" type="button"
                      aria-expanded="false" aria-controls="<?= e($id) ?>"<?= $active ? ' aria-current="page"' : '' ?>>
                <?= e($item['t']) ?>
                <svg class="nav__chev" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                  <path d="m6 9 6 6 6-6"/>
                </svg>
              </button>
              <ul class="nav__sub" id="<?= e($id) ?>">
                <li class="nav__sub-all">
                  <a href="<?= e(u($item['u'])) ?>">Все услуги</a>
                </li>
                <?php foreach ($item['sub'] as $slug):
                    if (!isset(SERVICES[$slug])) continue; ?>
                  <li>
                    <a href="<?= e(service_url($slug)) ?>"<?= $cur === service_path($slug) ? ' aria-current="page"' : '' ?>>
                      <?= e(SERVICES[$slug]['title']) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif;
      endforeach; ?>

      <?php /* на узких экранах кнопка заявки уезжает из шапки сюда */ ?>
      <a class="btn btn--full nav__cta" href="<?= e(u('/kontakty/#zayavka')) ?>" data-lead-open>Оставить заявку</a>
    </nav>

    <a class="hdr__tel" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>

    <a class="btn hdr__cta" href="<?= e(u('/kontakty/#zayavka')) ?>" data-lead-open>Оставить заявку</a>

    <button class="burger" type="button" aria-expanded="false" aria-controls="nav" aria-label="Меню">
      <span></span>
    </button>
  </div>
</header>
