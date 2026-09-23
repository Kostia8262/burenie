<?php
/**
 * Форма заявки. Перед include можно задать:
 *   $lead_source — откуда пришла заявка (уходит менеджеру)
 *   $lead_title  — заголовок над формой
 *   $lead_note   — строка под заголовком
 *   $lead_id     — id формы, если их на странице несколько
 */
$lead_source = $lead_source ?? ($_SERVER['REQUEST_PATH'] ?? '/');
$lead_id     = $lead_id ?? 'zayavka';
?>
<form class="form" data-lead data-tel="<?= e(main_phone()) ?>" action="<?= e(u('/zayavka/')) ?>" method="post" id="<?= e($lead_id) ?>">
  <input type="hidden" name="source" value="<?= e($lead_source) ?>">
  <label class="hp" aria-hidden="true">Не заполняйте это поле <input type="text" name="website" tabindex="-1" autocomplete="off"></label>

  <div class="field">
    <label for="<?= e($lead_id) ?>-name">Как к вам обращаться</label>
    <input id="<?= e($lead_id) ?>-name" name="name" type="text" autocomplete="name" required maxlength="80" placeholder="Юрий">
  </div>

  <div class="field">
    <label for="<?= e($lead_id) ?>-tel">Телефон</label>
    <input id="<?= e($lead_id) ?>-tel" name="phone" type="tel" autocomplete="tel" required placeholder="+7 (949) 000-00-00">
  </div>

  <div class="field">
    <label for="<?= e($lead_id) ?>-place">Где участок</label>
    <input id="<?= e($lead_id) ?>-place" name="place" type="text" maxlength="120" placeholder="Донецк, Пролетарский р-н">
  </div>

  <?php if (!empty($lead_comment)): ?>
  <div class="field">
    <label for="<?= e($lead_id) ?>-msg">Что нужно</label>
    <textarea id="<?= e($lead_id) ?>-msg" name="comment" maxlength="1200" placeholder="Скважина под ключ, дом на две семьи"></textarea>
  </div>
  <?php endif; ?>

  <button class="btn btn--full btn--lg" type="submit">Жду расчёт<?= icon('arrow') ?></button>
  <p class="form-msg" data-msg hidden></p>
  <p class="form__agree">
    Нажимая кнопку, вы даёте <a href="<?= e(u('/soglasie/')) ?>">согласие на обработку
    персональных данных</a> в объёме, описанном в
    <a href="<?= e(u('/politika/')) ?>">политике конфиденциальности</a>.
    Телефон нужен только для ответа по заявке.
  </p>
</form>
