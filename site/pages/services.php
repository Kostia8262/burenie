<?php
page_start([
    'title' => 'Услуги — бурение и обустройство скважин в ДНР',
    'desc'  => 'Все услуги: бурение скважин под ключ, на песок и известняк, малогабаритное бурение, обустройство с адаптером и кессоном, водоочистка, канализация, лицензия и ремонт скважин.',
    'path'  => '/uslugi/',
]);
echo crumbs([['Главная', '/'], ['Услуги', '/uslugi/']]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1">Услуги</h1>
    <p class="lead">
      Делаем весь цикл сами: бурим, обустраиваем, подключаем к дому, ставим
      водоочистку и сдаём с паспортом скважины. Подрядчиков на объект не зовём.
    </p>
  </div>
</div>

<?php foreach (SERVICE_GROUPS as $gk => $gname): ?>
<section class="sec sec--tight">
  <div class="wrap">
    <h2 class="eyebrow" style="margin-bottom:1.5rem"><?= e($gname) ?></h2>
    <div class="grid grid--3">
      <?php foreach (services_in($gk) as $slug => $s): ?>
        <a class="card" href="<?= e(service_url($slug)) ?>">
          <h3 class="card-t"><?= e($s['title']) ?></h3>
          <p><?= e($s['short']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endforeach; ?>

<section class="sec sec--tight">
  <div class="wrap split">
    <div>
      <h2 class="d3">Не знаете, что из этого вам нужно?</h2>
      <p class="lead">Это нормально. Позвоните и опишите участок и дом — подскажем, с чего начать, даже если заказывать будете не у нас.</p>
      <a class="btn" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
    </div>
  </div>
</section>

<?php page_end(); ?>
