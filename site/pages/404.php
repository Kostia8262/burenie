<?php
/**
 * Страница ошибки. Одна на 404 и 403 — меняются только заголовок и текст.
 * @var int $code
 */
$code = $code ?? 404;
$is403 = $code === 403;

page_start([
    'title'   => $is403 ? 'Доступ закрыт' : 'Страница не найдена',
    'desc'    => $is403 ? 'Этот раздел закрыт.' : 'Такой страницы на сайте нет.',
    'path'    => '/404/',
    'noindex' => true,
]);
?>
<div class="phead">
  <div class="wrap">
    <h1 class="d1"><?= $is403 ? 'Сюда нельзя' : 'Сухая скважина' ?></h1>
    <p class="lead">
      <?php if ($is403): ?>
        Этот адрес закрыт — там служебные файлы сайта, смотреть в них нечего.
        Вернитесь к услугам или позвоните, если искали что-то конкретное.
      <?php else: ?>
        По этому адресу ничего нет. Возможно, страница переехала при
        обновлении сайта — загляните в услуги или позвоните, мы подскажем.
      <?php endif; ?>
    </p>
    <p class="btn-row">
      <a class="btn" href="<?= e(u('/uslugi/')) ?>">Все услуги<?= icon('arrow') ?></a>
      <a class="btn btn--ghost" href="<?= e(tel_href(main_phone())) ?>">
        <?= icon('phone') ?><?= e(main_phone()) ?>
      </a>
    </p>
  </div>
</div>

<section class="sec sec--s1">
  <div class="wrap">
    <h2 class="h-minor">Куда обычно идут</h2>
    <div class="posts">
      <?php foreach (['pod-klyuch', 'malogabaritnoe', 'na-pesok'] as $s): ?>
        <a class="post" href="<?= e(service_url($s)) ?>">
          <?= illu('svc/' . $s, 'post__art') ?>
          <h3><?= e(SERVICES[$s]['title']) ?></h3>
          <p><?= e(SERVICES[$s]['short']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php page_end(); ?>
