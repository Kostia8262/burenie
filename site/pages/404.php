<?php
page_start([
    'title' => 'Страница не найдена',
    'desc'  => 'Такой страницы на сайте нет.',
    'path'  => '/404/',
    'noindex' => true,
]);
?>
<div class="phead">
  <div class="wrap">
    <h1 class="d1">Сухая скважина</h1>
    <p class="lead">
      По этому адресу ничего нет. Возможно, страница переехала при обновлении
      сайта — загляните в услуги или позвоните, мы подскажем.
    </p>
    <p class="btn-row">
      <a class="btn" href="<?= e(u('/uslugi/')) ?>">Все услуги</a>
      <a class="btn btn--ghost" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
    </p>
  </div>
</div>
<section class="sec">
  <div class="wrap">
    <h2 class="h-minor">Куда обычно идут</h2>
    <div class="grid grid--3">
      <?php foreach (['pod-klyuch','malogabaritnoe','na-pesok'] as $s): ?>
        <a class="card" href="<?= e(service_url($s)) ?>">
          <h3 class="card-t"><?= e(SERVICES[$s]['title']) ?></h3>
          <p><?= e(SERVICES[$s]['short']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php page_end(); ?>
