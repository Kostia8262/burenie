</main>

<section class="cta">
  <div class="wrap cta__in">
    <div>
      <h2 class="d2">Приедем, посмотрим участок и посчитаем</h2>
      <p>Выезд инженера и смета — бесплатно и ни к чему вас не обязывают. Обычно приезжаем в течение двух дней.</p>
    </div>
    <div style="display:flex;flex-wrap:wrap;gap:.8rem">
      <a class="btn btn--lg" href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
      <a class="btn btn--lg btn--ghost" href="<?= e(u('/kontakty/#zayavka')) ?>" style="color:#fff;border-color:rgba(255,255,255,.5)">Оставить заявку</a>
    </div>
  </div>
</section>

<footer class="ftr">
  <div class="wrap">
    <div class="ftr__grid">
      <div>
        <a class="logo" href="<?= e(u('/')) ?>" style="margin-bottom:1.2rem">
          <?php include __DIR__ . '/logo.php'; ?>
          <span class="logo__txt">
            <span class="logo__name">СОС Бурение</span>
            <span class="logo__sub">Донецк · ДНР</span>
          </span>
        </a>
        <p style="color:var(--on-deep-2);font-size:.93rem;max-width:34ch">
          Бурение и обустройство скважин на воду в Донецке, Макеевке и по всей ДНР.
          Малогабаритная установка, паспорт скважины, гарантия на работы.
        </p>
        <div class="soc">
          <a href="<?= e(SITE['tg']) ?>" rel="noopener" target="_blank" aria-label="Telegram">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.9 4.3 18.6 20c-.2 1.1-.9 1.4-1.8.9l-5-3.7-2.4 2.3c-.3.3-.5.5-1 .5l.4-5.1L18.1 6c.4-.4-.1-.6-.6-.2L6.9 12.6l-5-1.6c-1.1-.3-1.1-1 .2-1.5l19.4-7.5c.9-.3 1.7.2 1.4 2.3z"/></svg>
          </a>
          <a href="mailto:<?= e(SITE['email']) ?>" aria-label="Почта">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M2 5h20v14H2V5zm2 2v.5l8 5 8-5V7H4zm16 10V9.9l-8 5-8-5V17h16z"/></svg>
          </a>
        </div>
      </div>

      <div>
        <h3>Бурение</h3>
        <ul>
          <?php foreach (services_in('burenie') as $slug => $s): ?>
            <li><a href="<?= e(service_url($slug)) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h3>Обустройство</h3>
        <ul>
          <?php foreach (services_in('obustroystvo') as $slug => $s): ?>
            <li><a href="<?= e(service_url($slug)) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
        <h3 style="margin-top:1.8rem">Ещё</h3>
        <ul>
          <?php foreach (services_in('soputstvuyushchee') as $slug => $s): ?>
            <li><a href="<?= e(service_url($slug)) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h3>Контакты</h3>
        <?php foreach (SITE['phones'] as $p): ?>
          <a class="ftr__tel" href="<?= e(tel_href($p)) ?>"><?= e($p) ?></a>
        <?php endforeach; ?>
        <ul style="margin-top:1.1rem">
          <li><a href="mailto:<?= e(SITE['email']) ?>"><?= e(SITE['email']) ?></a></li>
          <li><a href="<?= e(SITE['tg']) ?>" rel="noopener" target="_blank"><?= e(SITE['tg_name']) ?></a></li>
          <li style="color:var(--on-deep-2);font-size:.95rem"><?= e(SITE['address']) ?></li>
          <li style="color:var(--on-deep-2);font-size:.95rem"><?= e(SITE['hours']) ?></li>
        </ul>
        <ul style="margin-top:1.1rem">
          <li><a href="<?= e(u('/geografiya/')) ?>">Где мы работаем</a></li>
          <li><a href="<?= e(u('/rekvizity/')) ?>">Реквизиты для оплаты</a></li>
          <li><a href="<?= e(u('/politika/')) ?>">Политика конфиденциальности</a></li>
        </ul>
      </div>
    </div>

    <div class="ftr__bottom">
      <span>&copy; <?= date('Y') ?> <?= e(SITE['legal']) ?> · ИНН <?= e(SITE['inn']) ?></span>
      <span>Сайт не является публичной офертой. Цены и сроки подтверждаются после выезда инженера.</span>
    </div>
  </div>
</footer>

<script src="<?= e(u('/assets/js/app.js')) ?>?v=<?= ASSET_V ?>" defer></script>
</body>
</html>
