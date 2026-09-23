<?php
/* Снимки с объектов: первые пять кадров из общего списка WORKS (config.php),
   там же лежат подписи. Первый грузится сразу, остальные лениво.
   Все кадры целиком показывает страница /raboty/. */
$shots = array_slice(WORKS, 0, 5);
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
                   srcset="<?= e(u(shot_src($s['src'], 480))) ?> 480w, <?= e(u($s['src'])) ?> 960w"
                   sizes="(max-width: 500px) calc(100vw - 3.6rem), 428px"
                   width="960" height="1280"
                   loading="lazy"<?= $i === 0 ? ' fetchpriority="high"' : '' ?>>
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
