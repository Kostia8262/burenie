<?php
/** @var string $slug @var array $svc */

$content = __DIR__ . '/../content/services/' . $slug . '.php';

page_start([
    'title' => $svc['h1'] . ' в Донецке и ДНР — ' . SITE['name'],
    'desc'  => $svc['meta'],
    'path'  => service_path($slug),
    'schema' => [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => $svc['h1'],
        'description' => $svc['short'],
        'serviceType' => $svc['title'],
        'provider'    => ['@id' => SITE['base'] . '/#org'],
        'areaServed'  => array_values(array_map(
            fn($c) => ['@type' => 'City', 'name' => $c['name']],
            CITIES
        )),
        'url' => abs_url(service_path($slug)),
    ],
]);

echo crumbs([['Главная', '/'], ['Услуги', '/uslugi/'], [$svc['title'], service_path($slug)]]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1"><?= e($svc['h1']) ?></h1>
    <p class="lead"><?= e($svc['short']) ?></p>
    <div class="phead__meta">
      <span>Донецк, Макеевка и вся ДНР</span>
      <span>Выезд и расчёт — <b>бесплатно</b></span>
      <span>Паспорт скважины и гарантия</span>
    </div>
  </div>
</div>

<section class="sec">
  <div class="wrap split">
    <article class="prose">
      <?php if (is_file($content)) {
          include $content;
      } else { ?>
        <p><?= e($svc['short']) ?></p>
        <p>
          Расскажите про участок по телефону — мы подскажем, подходит ли этот
          вариант именно вам, и посчитаем смету после выезда.
        </p>
      <?php } ?>
    </article>

    <aside>
      <div class="form-card sticky" id="zayavka">
        <h2 class="d3">Посчитаем по вашему участку</h2>
        <p class="form-card__note">Инженер приедет, посмотрит участок и назовёт сумму. Бесплатно и ни к чему вас не обязывает.</p>
        <?php
        $lead_source = $svc['title'];
        $lead_id = 'lead-svc';
        $lead_comment = true;
        include __DIR__ . '/../inc/parts/lead-form.php';
        ?>
      </div>
    </aside>
  </div>
</section>

<section class="sec sec--s1 sec--tight">
  <div class="wrap">
    <h2 class="h-minor">Смотрят вместе с этим</h2>
    <div class="grid grid--3">
      <?php
      $same = services_in($svc['group']);
      unset($same[$slug]);
      foreach (array_slice($same, 0, 3, true) as $s2 => $d2): ?>
        <a class="card" href="<?= e(service_url($s2)) ?>">
          <h3 class="card-t"><?= e($d2['title']) ?></h3>
          <p><?= e($d2['short']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php page_end(); ?>
