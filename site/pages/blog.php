<?php
page_start([
    'title' => 'Статьи о скважинах, воде и бурении',
    'desc'  => 'Разбираем то, что обычно объясняем на выезде: глубина горизонтов, цена скважины, кессон или адаптер, анализ воды, ремонт и обслуживание скважин.',
    'path'  => '/stati/',
]);
echo crumbs([['Главная', '/'], ['Статьи', '/stati/']]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1">Статьи</h1>
    <p class="lead">
      То, что мы обычно рассказываем заказчику на участке. Без «закажите у нас»
      в каждом абзаце — просто как устроены скважины и вода.
    </p>
  </div>
</div>

<section class="sec">
  <div class="wrap">
    <div class="posts">
      <?php foreach (ARTICLES as $slug => $a): ?>
        <a class="post" href="<?= e(article_url($slug)) ?>">
          <time datetime="<?= e($a['date']) ?>"><?= e(ru_date($a['date'])) ?></time>
          <h2><?= e($a['title']) ?></h2>
          <p><?= e($a['excerpt']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php page_end(); ?>
