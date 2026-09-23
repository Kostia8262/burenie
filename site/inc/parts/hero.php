<?php
/* Снимки с объектов. Порядок — как в массиве; первый кадр грузится сразу,
   остальные лениво. Чтобы добавить кадр, достаточно дописать строку. */
$shots = [
  [
    'src' => '/assets/img/photo/mgbu-1.jpg',
    'alt' => 'Малогабаритная буровая установка работает во дворе частного дома в Донецке',
    'cap' => 'Бурение малогабаритной установкой: встаёт между домом и теплицей, забор не разбираем',
  ],
  [
    'src' => '/assets/img/photo/prokachka.jpg',
    'alt' => 'Прокачка новой скважины: из трубы идёт чистая вода, рядом буровая установка',
    'cap' => 'Прокачка после бурения: гоним воду, пока не пойдёт чистая',
  ],
  [
    'src' => '/assets/img/photo/adapter.jpg',
    'alt' => 'Монтаж скважинного адаптера на обсадную трубу у фундамента дома',
    'cap' => 'Скважинный адаптер: труба к дому идёт ниже промерзания, без кессона',
  ],
  [
    'src' => '/assets/img/photo/kesson.jpg',
    'alt' => 'Пластиковый кессон над оголовком скважины на участке',
    'cap' => 'Кессон: оголовок и автоматика под землёй, зимой не перемерзают',
  ],
  [
    'src' => '/assets/img/photo/nasos.jpg',
    'alt' => 'Монтаж глубинного насоса в обсадную трубу скважины во дворе',
    'cap' => 'Монтаж насоса: подбираем по дебиту и глубине, опускаем и подключаем',
  ],
];
?>
<section class="hero">
  <div class="wrap hero__in">
    <div>
      <h1 class="d1">Бурение скважин «под ключ» в Донецке и по всей ДНР</h1>
      <p class="hero__slogan">Своя вода в доме, а не по графику подачи</p>
      <p class="hero__lead">
        Бурим малогабаритной установкой: она проходит в калитку и работает во
        дворе, забор разбирать не нужно. Отдаём паспорт скважины и гарантию
        на работы.
      </p>

      <ul class="badges">
        <li class="badge">
          <?= icon('clock') ?>
          <span>
            <b>1–2 дня</b>
            <span>от заезда установки до воды из устья</span>
          </span>
        </li>
        <li class="badge">
          <?= icon('check') ?>
          <span>
            <b>Бесплатно</b>
            <span>выезд инженера и смета по вашему участку</span>
          </span>
        </li>
      </ul>

      <div class="hero__cta">
        <a class="btn btn--lg" href="#zayavka" data-lead-open>Рассчитать стоимость</a>
        <a class="btn btn--lg btn--ghost" href="<?= e(tel_href(main_phone())) ?>" data-lead-open>
          <?= icon('phone') ?><?= e(main_phone()) ?>
        </a>
      </div>
    </div>

    <div class="shots" data-shots>
      <div class="shot">
        <div class="shots__track" tabindex="0" role="group"
             aria-roledescription="карусель"
             aria-label="Снимки с объектов">
          <?php foreach ($shots as $i => $s): ?>
            <figure class="shots__item" role="group"
                    aria-roledescription="слайд"
                    aria-label="<?= $i + 1 ?> из <?= count($shots) ?>">
              <img src="<?= e(u($s['src'])) ?>" alt="<?= e($s['alt']) ?>"
                   width="960" height="1280"
                   <?= $i === 0 ? 'fetchpriority="high"' : 'loading="lazy"' ?>>
              <figcaption><?= e($s['cap']) ?></figcaption>
            </figure>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="shots__dots" hidden>
        <?php foreach ($shots as $i => $s): ?>
          <button type="button" class="shots__dot<?= $i === 0 ? ' is-on' : '' ?>"
                  aria-label="Снимок <?= $i + 1 ?>"
                  <?= $i === 0 ? 'aria-current="true"' : '' ?>></button>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
