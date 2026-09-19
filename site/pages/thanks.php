<?php
page_start([
    'title' => 'Заявка отправлена',
    'desc'  => 'Заявка принята, мы свяжемся с вами в ближайшее рабочее время.',
    'path'  => '/spasibo/',
    'noindex' => true,
]);
?>
<div class="phead">
  <div class="wrap">
    <h1 class="d1">Заявка у нас</h1>
    <p class="lead">Перезвоним в ближайшее рабочее время. Если нужно срочно — звоните сами, так быстрее.</p>
    <p class="btn-row"><a class="btn btn--lg" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a></p>
  </div>
</div>
<section class="sec">
  <div class="wrap">
    <h2 class="h-minor">Пока ждёте</h2>
    <div class="posts">
      <?php foreach (array_slice(ARTICLES, 0, 3, true) as $slug => $a): ?>
        <a class="post" href="<?= e(article_url($slug)) ?>">
          <time datetime="<?= e($a['date']) ?>"><?= e(ru_date($a['date'])) ?></time>
          <h3><?= e($a['title']) ?></h3>
          <p><?= e($a['excerpt']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php page_end(); ?>
