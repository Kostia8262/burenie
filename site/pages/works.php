<?php
/**
 * Наши работы. Снимки с объектов из WORKS — все, что есть.
 *
 * Страница сознательно скромная: своих фотографий у нас немного, и вместо
 * «портфолио из ста объектов» здесь честные семь кадров с объяснением, что на
 * каждом видно. Выдуманных адресов, глубин и имён заказчиков тут нет и не
 * должно появиться.
 */

page_start([
    'title' => 'Наши работы — фото с объектов, СОС Бурение',
    'desc'  => 'Как выглядит наша работа на участке: малогабаритная установка во дворе, прокачка скважины, монтаж адаптера, кессона и насоса. Фотографии с объектов в Донецке и ДНР.',
    'path'  => '/raboty/',
    // Ключ 'schema', а не 'schemas': одиночную сущность принимают обе версии
    // page_start(), а 'schemas' появился позже и не во всех ветках есть.
    'schema' => [
        '@context'        => 'https://schema.org',
        '@type'           => 'ImageGallery',
        '@id'             => abs_url('/raboty/') . '#gallery',
        'name'            => 'Работы СОС Бурение',
        'inLanguage'      => 'ru-RU',
        'associatedMedia' => array_map(fn($w) => [
            '@type'       => 'ImageObject',
            'contentUrl'  => abs_url($w['src']),
            'caption'     => $w['cap'],
            'description' => $w['text'],
        ], WORKS),
    ],
]);

echo crumbs([['Главная', '/'], ['Наши работы', '/raboty/']]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1">Как это выглядит на участке</h1>
    <p class="lead">
      Снимки с наших объектов. Их немного и они не постановочные: это та самая
      установка, которая приедет к вам, и то самое оборудование, которое мы
      ставим. Фотографий чужих работ здесь нет.
    </p>
    <div class="phead__meta">
      <span>Донецк, Макеевка и вся ДНР</span>
      <span>Своя установка и своя бригада</span>
      <span>Паспорт скважины и гарантия</span>
    </div>
  </div>
</div>

<section class="sec">
  <div class="wrap">
    <div class="works">
      <?php foreach (WORKS as $i => $w): ?>
        <figure class="work">
          <img class="work__img"
               src="<?= e(u($w['src'])) ?>"
               srcset="<?= e(u(shot_src($w['src'], 480))) ?> 480w, <?= e(u($w['src'])) ?> 960w"
               sizes="(max-width: 700px) calc(100vw - 2.3rem), 420px"
               alt="<?= e($w['alt']) ?>"
               width="960" height="1280"
               <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>
               decoding="async">
          <figcaption>
            <b><?= e($w['cap']) ?></b>
            <span><?= e($w['text']) ?></span>
          </figcaption>
        </figure>
      <?php endforeach; ?>
    </div>

    <p class="note">
      Снимков будет больше: мы фотографируем не каждый объект, а те, где видно
      что-то полезное — нестандартный заезд, обустройство в тесноте, работу
      зимой. Если хотите посмотреть на похожий на ваш случай, спросите по
      телефону, часто находится.
    </p>
  </div>
</section>

<section class="sec sec--s1 sec--tight">
  <div class="wrap split">
    <div>
      <h2 class="d3">Посмотрим ваш участок</h2>
      <p class="lead">
        Инженер приедет, оценит подъезд и место под установку и скажет, как
        работа пойдёт именно у вас. Выезд и расчёт бесплатные.
      </p>
    </div>
    <div class="form-card" id="zayavka">
      <h2 class="d3">Оставьте телефон — посчитаем</h2>
      <?php
      $lead_source = 'Наши работы';
      $lead_id = 'lead-works';
      $lead_comment = true;
      include __DIR__ . '/../inc/parts/lead-form.php';
      ?>
    </div>
  </div>
</section>

<?php page_end(); ?>
