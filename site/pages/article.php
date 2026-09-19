<?php
/** @var string $slug @var array $art */
$content = __DIR__ . '/../content/articles/' . $slug . '.php';

page_start([
    'title'  => $art['title'] . ' — ' . SITE['name'],
    'desc'   => $art['meta'],
    'path'   => article_path($slug),
    'ogtype' => 'article',
    'schema' => [
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => $art['title'],
        'description'   => $art['excerpt'],
        'datePublished' => $art['date'],
        'dateModified'  => $art['date'],
        'inLanguage'    => 'ru-RU',
        'author'        => ['@type' => 'Organization', 'name' => SITE['name'], '@id' => SITE['base'] . '/#org'],
        'publisher'     => ['@id' => SITE['base'] . '/#org'],
        'mainEntityOfPage' => abs_url(article_path($slug)),
    ],
]);
echo crumbs([['Главная', '/'], ['Статьи', '/stati/'], [$art['title'], article_path($slug)]]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1"><?= e($art['title']) ?></h1>
    <p class="lead"><?= e($art['excerpt']) ?></p>
  </div>
</div>

<section class="sec">
  <div class="wrap split">
    <article class="prose">
      <?php if (is_file($content)) {
          include $content;
      } else { ?>
        <p>Статья готовится.</p>
      <?php } ?>
    </article>

    <aside>
      <div class="form-card sticky" id="zayavka">
        <h2 class="d3">Спросить про свой участок</h2>
        <p class="form-card__note">Инженер приедет, посмотрит участок и назовёт сумму. Бесплатно и ни к чему вас не обязывает.</p>
        <?php
        $lead_source = 'Статья: ' . $art['title'];
        $lead_id = 'lead-art';
        $lead_comment = true;
        include __DIR__ . '/../inc/parts/lead-form.php';
        ?>
      </div>
    </aside>
  </div>
</section>

<section class="sec sec--s1 sec--tight">
  <div class="wrap">
    <h2 class="h-minor">Ещё статьи</h2>
    <div class="posts">
      <?php
      $rest = ARTICLES;
      unset($rest[$slug]);
      foreach (array_slice($rest, 0, 3, true) as $s2 => $a2): ?>
        <a class="post" href="<?= e(article_url($s2)) ?>">
          <time datetime="<?= e($a2['date']) ?>"><?= e(ru_date($a2['date'])) ?></time>
          <h3><?= e($a2['title']) ?></h3>
          <p><?= e($a2['excerpt']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php page_end(); ?>
