<?php
page_start([
    'title' => 'Контакты — СОС Бурение, Донецк',
    'desc'  => 'Телефоны, почта, Telegram и адрес: ' . SITE['address'] . '. Бурение скважин на воду в Донецке и по всей ДНР.',
    'path'  => '/kontakty/',
]);
echo crumbs([['Главная', '/'], ['Контакты', '/kontakty/']]);
?>

<div class="phead">
  <div class="wrap">
    <p class="eyebrow">Связаться</p>
    <h1 class="d1">Контакты</h1>
    <p class="lead">Звоните с 8:00 до 20:00 без выходных. На заявки с сайта отвечаем в ближайшее рабочее время.</p>
  </div>
</div>

<section class="sec">
  <div class="wrap split">
    <div class="prose">
      <h2>Телефоны</h2>
      <?php foreach (SITE['phones'] as $p): ?>
        <p><a class="ftr__tel" style="color:var(--ink)" href="<?= e(tel_href($p)) ?>"><?= e($p) ?></a></p>
      <?php endforeach; ?>

      <h2>Ещё способы</h2>
      <ul>
        <li>Telegram: <a href="<?= e(SITE['tg']) ?>" rel="noopener" target="_blank"><?= e(SITE['tg_name']) ?></a></li>
        <li>Почта: <a href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a></li>
      </ul>

      <h2>Адрес</h2>
      <p><?= e(SITE['address']) ?><br><?= e(SITE['hours']) ?></p>
      <p class="muted">
        Это офис. На объект инженер приезжает сам — приходить к нам, чтобы
        заказать расчёт, не нужно.
      </p>

      <h2>Реквизиты</h2>
      <p>ИП работает по договору, в том числе по безналу — <a href="<?= e(u('/rekvizity/')) ?>">реквизиты для оплаты</a>.</p>
    </div>

    <aside>
      <div class="form-card" id="zayavka">
        <p class="eyebrow" style="color:var(--on-deep-2)">Расчёт бесплатно</p>
        <h2 class="d3" style="margin-bottom:1.2rem">Оставить заявку</h2>
        <?php
        $lead_source = 'Страница контактов';
        $lead_id = 'lead-contacts';
        $lead_comment = true;
        include __DIR__ . '/../inc/parts/lead-form.php';
        ?>
      </div>
    </aside>
  </div>
</section>

<section class="sec sec--tight">
  <div class="wrap">
    <div style="border:1px solid var(--hair);border-radius:var(--r);overflow:hidden;line-height:0">
      <iframe title="Мы на карте" loading="lazy" style="width:100%;height:420px;border:0"
        src="https://yandex.ru/map-widget/v1/?ll=<?= e(SITE['lon']) ?>%2C<?= e(SITE['lat']) ?>&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgoxNDQ5NDk3ODAwEkbQoNC-0YHRgdC40Y8sINCU0L7QvdC10YbQuiwg0YPQu9C40YbQsCDQpNGR0LTQvtGA0LAg0JfQsNC50YbQtdCy0LAsIDc1IgoNpz0XQhU__j9C&z=16.5"></iframe>
    </div>
  </div>
</section>

<?php page_end(); ?>
