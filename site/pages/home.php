<?php
page_start([
    'title' => 'Бурение скважин на воду в Донецке и ДНР — СОС Бурение',
    'desc'  => 'Бурим и обустраиваем скважины на воду в Донецке, Макеевке и по всей ДНР. Малогабаритная установка проходит в калитку, паспорт скважины и гарантия на работы. Выезд инженера и расчёт — бесплатно.',
    'path'  => '/',
    'schema' => [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], FAQ),
    ],
]);
?>

<?php include __DIR__ . '/../inc/parts/hero.php'; ?>

<!-- ===================== услуги ===================== -->
<section class="sec" id="uslugi">
  <div class="wrap">
    <div class="sec-head rise">
      <p class="eyebrow">Что мы делаем</p>
      <h2 class="d2">От первого метра до воды в кране</h2>
      <p class="lead">
        Скважина — это не только бурение. Ниже всё, что обычно нужно, чтобы вода
        дошла до дома и осталась пригодной для питья.
      </p>
    </div>

    <?php foreach (SERVICE_GROUPS as $gk => $gname):
        $list = services_in($gk); ?>
      <h3 class="eyebrow rise" style="margin-top:2.5rem"><?= e($gname) ?></h3>
      <div class="grid grid--3 rise">
        <?php foreach ($list as $slug => $s): ?>
          <a class="card" href="<?= e(service_url($slug)) ?>">
            <h3 class="card-t"><?= e($s['title']) ?></h3>
            <p><?= e($s['short']) ?></p>
            <span class="card__more">Подробнее →</span>
          </a>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- ===================== разрез ===================== -->
<section class="sec sec--soft" id="glubina">
  <div class="wrap">
    <div class="sec-head sec-head--wide rise">
      <p class="eyebrow">Главный вопрос</p>
      <h2 class="d2">На какой глубине под вами вода</h2>
      <p class="lead">
        В Донбассе обычно два рабочих горизонта: песок на 22–45 метрах и
        известняк глубже 70. От того, на какой вы идёте, зависит и дебит, и срок
        службы, и цена. Соседние улицы при этом могут отличаться вдвое — поэтому
        точную глубину мы называем только после выезда.
      </p>
    </div>

    <div class="rise">
      <?= core_full() ?>
    </div>

    <p class="note rise" style="max-width:62ch">
      Разрез показывает типичную картину для Донбасса, а не гарантию по вашему
      участку. Перед работой мы спрашиваем про скважины у соседей и смотрим
      место — этого обычно хватает, чтобы понять горизонт заранее.
    </p>
  </div>
</section>

<!-- ===================== цена ===================== -->
<section class="sec" id="ceny">
  <div class="wrap split">
    <div class="rise">
      <p class="eyebrow">Деньги</p>
      <h2 class="d2">Почему мы не вешаем цену за метр на главную</h2>
      <p class="lead">
        Цифра «от … ₽ за метр» выглядит честно ровно до выезда. Дальше выясняется,
        что нужна труба другого диаметра, что горизонт глубже, что подъезда нет —
        и смета растёт. Мы считаем наоборот: сначала смотрим участок, потом
        называем цену, и она уже не меняется.
      </p>
      <p>Что влияет на смету:</p>
      <div class="prose">
        <ul>
          <li>глубина до рабочего горизонта;</li>
          <li>диаметр и материал обсадной трубы;</li>
          <li>грунт: песок, глина, известняк, скальные прослойки;</li>
          <li>вариант обустройства — летний, адаптер или кессон;</li>
          <li>насос и автоматика под ваш дом;</li>
          <li>подъезд к точке бурения.</li>
        </ul>
      </div>
      <a class="btn" href="<?= e(u('/ceny/')) ?>">Как мы считаем</a>
    </div>

    <div class="form-card rise" id="zayavka">
      <p class="eyebrow" style="color:var(--on-deep-2)">Расчёт бесплатно</p>
      <h3 class="d3" style="margin-bottom:1.3rem">Оставьте телефон — посчитаем</h3>
      <?php $lead_source = 'Главная — форма расчёта'; $lead_id = 'lead-home';
            include __DIR__ . '/../inc/parts/lead-form.php'; ?>
    </div>
  </div>
</section>

<!-- ===================== как работаем ===================== -->
<section class="sec">
  <div class="wrap">
    <div class="sec-head rise">
      <p class="eyebrow">Порядок работы</p>
      <h2 class="d2">Пять шагов, и в доме вода</h2>
    </div>
    <ol class="steps rise">
      <?php foreach (STEPS as $s): ?>
        <li>
          <h3><?= e($s['t']) ?></h3>
          <p><?= e($s['d']) ?></p>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<!-- ===================== география ===================== -->
<section class="sec">
  <div class="wrap split">
    <div class="rise">
      <p class="eyebrow">География</p>
      <h2 class="d2">Куда выезжаем</h2>
      <p class="lead">
        База в Донецке, работаем по всей ДНР. В соседние города выезжаем так же,
        как по городу, — установка едет на прицепе.
      </p>
      <p class="muted">
        Вашего населённого пункта нет в списке? Позвоните, почти всегда
        получается договориться.
      </p>
    </div>
    <div class="rise">
      <ul class="cities">
        <?php foreach (CITIES as $slug => $c): ?>
          <li><a href="<?= e(city_url($slug)) ?>"><?= e($c['name']) ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</section>

<!-- ===================== вопросы ===================== -->
<section class="sec">
  <div class="wrap split">
    <div class="rise">
      <p class="eyebrow">Вопросы</p>
      <h2 class="d2">О чём спрашивают чаще всего</h2>
      <p class="lead">
        Если вашего вопроса тут нет — позвоните, ответим без «оставьте заявку,
        мы перезвоним».
      </p>
      <a class="btn btn--ghost" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
    </div>

    <div class="faq rise">
      <?php foreach (FAQ as $i => $f): ?>
        <details<?= $i === 0 ? ' open' : '' ?>>
          <summary><?= e($f['q']) ?></summary>
          <div class="faq__a"><p><?= e($f['a']) ?></p></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ===================== статьи ===================== -->
<section class="sec">
  <div class="wrap">
    <div class="sec-head rise">
      <p class="eyebrow">Разбираемся</p>
      <h2 class="d2">Статьи о скважинах и воде</h2>
      <p class="lead">
        Пишем то, что обычно объясняем на выезде: как выбрать горизонт, чем
        кессон отличается от адаптера, что смотреть в анализе воды.
      </p>
    </div>
    <div class="posts rise">
      <?php foreach (array_slice(ARTICLES, 0, 3, true) as $slug => $a): ?>
        <a class="post" href="<?= e(article_url($slug)) ?>">
          <time datetime="<?= e($a['date']) ?>"><?= e(ru_date($a['date'])) ?></time>
          <h3><?= e($a['title']) ?></h3>
          <p><?= e($a['excerpt']) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
    <p style="margin-top:1.8rem"><a class="btn btn--ghost" href="<?= e(u('/stati/')) ?>">Все статьи</a></p>
  </div>
</section>

<?php page_end(); ?>
