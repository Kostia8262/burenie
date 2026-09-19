<?php
page_start([
    'title' => 'Где мы бурим — города ДНР',
    'desc'  => 'Бурение скважин на воду в Донецке, Макеевке, Горловке, Харцызске и других городах ДНР. Выезжаем по всей республике, установка едет на прицепе.',
    'path'  => '/geografiya/',
]);
echo crumbs([['Главная', '/'], ['География', '/geografiya/']]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1">Где мы работаем</h1>
    <p class="lead">
      База в Донецке. По республике выезжаем так же, как по городу: установка
      малогабаритная и едет на прицепе, отдельной логистики не требует.
    </p>
  </div>
</div>

<section class="sec">
  <div class="wrap">
    <div class="grid grid--3">
      <?php foreach (CITIES as $slug => $c): ?>
        <a class="card" href="<?= e(city_url($slug)) ?>">
          <h2 class="card-t">Бурение скважин в <?= e($c['case']) ?></h2>
          <p>Бурение и обустройство скважин на воду<?= !empty($c['home']) ? ' — это наш город' : '' ?>.</p>
        </a>
      <?php endforeach; ?>
    </div>
    <p class="note">
      Вашего населённого пункта нет в списке? Позвоните
      <a href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a> —
      почти всегда получается договориться.
    </p>
  </div>
</section>

<?php page_end(); ?>
