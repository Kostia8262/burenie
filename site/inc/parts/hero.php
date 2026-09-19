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
          <svg viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="2"/>
            <path d="M24 12v13l8 5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
          </svg>
          <span>
            <b>1–2 дня</b>
            <span>на скважину от заезда до воды</span>
          </span>
        </li>
        <li class="badge">
          <svg viewBox="0 0 48 48" fill="none" aria-hidden="true">
            <circle cx="24" cy="24" r="22" stroke="currentColor" stroke-width="2"/>
            <path d="M15 24.5l6.5 6.5L33 19" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <span>
            <b>Бесплатно</b>
            <span>выезд инженера и расчёт сметы</span>
          </span>
        </li>
      </ul>

      <div class="hero__cta">
        <a class="btn btn--lg" href="#zayavka">Рассчитать стоимость бурения</a>
        <a class="btn btn--lg btn--ghost" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
      </div>
    </div>

    <div class="shot">
      <img src="<?= e(u('/assets/img/photo/mgbu-1.jpg')) ?>"
           alt="Малогабаритная буровая установка работает во дворе частного дома в Донецке"
           width="960" height="1280" fetchpriority="high">
    </div>
  </div>
</section>
