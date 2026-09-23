<?php $cur = $_SERVER['REQUEST_PATH'] ?? '/'; ?>
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
      <?php foreach (NAV as $item): ?>
        <a href="<?= e(u($item['u'])) ?>"<?= str_starts_with($cur, $item['u']) ? ' aria-current="page"' : '' ?>><?= e($item['t']) ?></a>
      <?php endforeach; ?>
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
