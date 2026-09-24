<?php
/** @var string $slug @var array $city */
$content = __DIR__ . '/../content/cities/' . $slug . '.php';
$name = $city['name'];
$case = $city['case'];
$faq  = city_faq($slug, $city);

/* Короткие факты по городу: выезд, сроки, глубина, документы. */
$facts = [
    ['Выезд', empty($city['home'])
        ? 'из Донецка в ' . city_acc($name) . ' — бесплатно'
        : $name . ' — наш город, выезд бесплатно'],
    ['Срок', '1–2 дня на бурение, ещё день на обустройство'],
    ['Глубина', 'песок обычно 22–45 м, известняк — глубже 70 м'],
    ['Сезон', 'бурим круглый год, зимой тоже'],
    ['На выходе', 'паспорт скважины и гарантия на работы'],
];

page_start([
    'title' => 'Бурение скважин на воду в ' . $case . ' — цена, под ключ',
    'desc'  => 'Бурение и обустройство скважин на воду в ' . $case . '. Малогабаритная установка, паспорт скважины, гарантия на работы. Выезд инженера и расчёт бесплатно.',
    'path'  => city_path($slug),
    'schema' => [
        '@context'    => 'https://schema.org',
        '@type'       => 'Service',
        'name'        => 'Бурение скважин на воду в ' . $case,
        'provider'    => ['@id' => SITE['base'] . '/#org'],
        'areaServed'  => ['@type' => 'City', 'name' => $name],
        'url'         => abs_url(city_path($slug)),
    ],
    'schemas'   => [faq_schema($faq, city_path($slug))],
    'speakable' => '.answer',
]);
echo crumbs([['Главная', '/'], ['География', '/geografiya/'], [$name, city_path($slug)]]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1">Бурение скважин на воду в <?= e($case) ?></h1>
    <p class="lead">
      Бурим и обустраиваем скважины в <?= e($case) ?><?= empty($city['home']) ? ' — выезжаем из Донецка' : '' ?>.
      Малогабаритная установка проходит в калитку, паспорт скважины и гарантия на работы.
    </p>
    <div class="phead__cta">
      <a class="btn" href="#zayavka" data-lead-open>Рассчитать стоимость</a>
      <a class="btn btn--ghost" href="<?= e(tel_href(main_phone())) ?>">
        <?= icon('phone') ?><?= e(main_phone()) ?>
      </a>
    </div>
    <div class="phead__meta">
      <span>Выезд и расчёт — <b>бесплатно</b></span>
      <span>Бурим круглый год</span>
      <span>1–2 дня на скважину</span>
    </div>
  </div>
</div>

<section class="sec">
  <div class="wrap split">
    <article class="prose">
      <?= facts_block($facts, 'Коротко о работе в ' . e($case)) ?>
      <?php if (is_file($content)) include $content; ?>

      <h2>Что делаем в <?= e($case) ?></h2>
      <p>Полный цикл — от выезда инженера до воды в кране:</p>
      <ul>
        <li>бурение на песок и на известняк, в том числе малогабаритной установкой;</li>
        <li>обустройство: летний вариант, адаптер или кессон;</li>
        <li>подбор и монтаж насоса, автоматика, ввод в дом;</li>
        <li>анализ воды и подбор водоочистки;</li>
        <li>паспорт скважины, гарантия и обслуживание.</li>
      </ul>

      <h2>На какой глубине вода в <?= e($case) ?></h2>
      <p>
        В Донбассе песчаный горизонт обычно встречается на 22–45 метрах,
        известняковый — глубже 70. Но даже соседние улицы могут отличаться вдвое,
        поэтому глубину мы называем после выезда, а не по телефону. Хороший
        ориентир — скважины у соседей: если знаете их глубину, скажите, и мы уже
        по телефону прикинем картину. Подробно про горизонты и про то, от чего
        зависит глубина, мы написали в статье
        <a href="<?= e(article_url('na-kakuyu-glubinu-burit')) ?>">на какую глубину
        бурить</a>, а выбор между ними разобрали в статье
        <a href="<?= e(article_url('pesok-ili-izvestnyak')) ?>">песок или
        известняк</a>.
      </p>

      <h2>Как заказать</h2>
      <p>
        Позвоните <a href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
        или оставьте номер в форме. Инженер приедет, посмотрит участок и посчитает
        смету — бесплатно и ни к чему вас не обязывая. Чтобы понимать, из чего
        она сложится, загляните в разбор
        <a href="<?= e(article_url('skolko-stoit-skvazhina')) ?>">сколько стоит
        скважина</a>, а прикинуть порядок суммы можно в
        <a href="<?= e(u('/kalkulyator/')) ?>">калькуляторе</a>.
      </p>
    </article>

    <aside>
      <div class="form-card sticky" id="zayavka">
        <h2 class="d3">Скважина в <?= e($case) ?></h2>
        <p class="form-card__note">Инженер приедет, посмотрит участок и назовёт сумму. Бесплатно и ни к чему вас не обязывает.</p>
        <?php
        $lead_source = 'Город: ' . $name;
        $lead_id = 'lead-city';
        $lead_comment = true;
        include __DIR__ . '/../inc/parts/lead-form.php';
        ?>
      </div>
    </aside>
  </div>
</section>

<?= faq_block($faq, 'Вопросы о бурении в ' . $case) ?>

<section class="sec sec--tight">
  <div class="wrap">
    <h2 class="h-minor">Что почитать перед бурением</h2>
    <div class="posts">
      <?php foreach (CITY_READS as $s2): $a2 = ARTICLES[$s2]; ?>
        <a class="post" href="<?= e(article_url($s2)) ?>">
          <?= illu_of('art/' . $s2, 'post__art') ?>
          <span class="post__meta">
            <span class="post__topic"><?= e($a2['topic']) ?></span>
            <span class="post__time"><?= read_time($s2) ?> мин</span>
          </span>
          <h3><?= e($a2['title']) ?></h3>
          <p><?= e($a2['excerpt']) ?></p>
          <span class="more">Читать<?= icon('arrow') ?></span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="sec sec--s1 sec--tight">
  <div class="wrap">
    <h2 class="h-minor">Другие города</h2>
    <ul class="cities">
      <?php foreach (CITIES as $s2 => $c2): if ($s2 === $slug) continue; ?>
        <li><a href="<?= e(city_url($s2)) ?>"><?= e($c2['name']) ?></a></li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>

<?php page_end(); ?>
