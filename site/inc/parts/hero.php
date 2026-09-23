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

    <figure class="shot">
      <img src="<?= e(u('/assets/img/photo/mgbu-1.jpg')) ?>"
           alt="Малогабаритная буровая установка работает во дворе частного дома в Донецке"
           width="960" height="1280" fetchpriority="high">
      <figcaption>Объект в частном секторе: установка встала между домом и теплицей, забор не разбирали</figcaption>
    </figure>
  </div>
</section>
