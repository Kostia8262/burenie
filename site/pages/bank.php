<?php
page_start([
    'title' => 'Реквизиты для оплаты — ИП Пименов Ю. Ю.',
    'desc'  => 'Банковские реквизиты ИП Пименов Юрий Юрьевич для оплаты работ по бурению и обустройству скважин.',
    'path'  => '/rekvizity/',
    'noindex' => true,
]);
echo crumbs([['Главная', '/'], ['Реквизиты', '/rekvizity/']]);
?>

<div class="phead">
  <div class="wrap">
    <h1 class="d1">Реквизиты для оплаты</h1>
    <p class="lead">Работаем с физическими и юридическими лицами, по договору и по безналичному расчёту.</p>
  </div>
</div>

<section class="sec">
  <div class="wrap">
    <div class="tbl__wrap" style="max-width:720px">
      <table class="tbl">
        <tbody>
        <?php foreach (BANK as $k => $v): ?>
          <tr><th><?= e($k) ?></th><td class="num"><?= e($v) ?></td></tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="note">Перед оплатой уточните сумму и назначение платежа у менеджера: <a href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>.</p>
  </div>
</section>

<?php page_end(); ?>
