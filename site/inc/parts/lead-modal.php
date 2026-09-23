<?php
/**
 * Окно заявки: открывается кнопкой в шапке. Нативный <dialog> — фокус,
 * Esc и подложку браузер берёт на себя. Без JS кнопка остаётся обычной
 * ссылкой на форму в контактах, поэтому окно ничего не ломает.
 */
?>
<dialog class="modal" id="leadModal" aria-labelledby="leadModalTitle">
  <div class="modal__box">
    <button class="modal__close" type="button" data-lead-close aria-label="Закрыть">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
           stroke-linecap="round" aria-hidden="true">
        <path d="M6 6l12 12M18 6L6 18"/>
      </svg>
    </button>

    <h2 class="d3" id="leadModalTitle">Оставьте телефон — посчитаем</h2>
    <p class="form-card__note">
      Инженер приедет, посмотрит участок и назовёт сумму. Бесплатно
      и ни к чему вас не обязывает.
    </p>

    <?php
    // окно открывают кнопки из шапки, первого экрана и подвала — пишем
    // менеджеру адрес страницы, иначе источник у всех выходит одинаковый
    $lead_source  = 'Окно заявки — ' . ($_SERVER['REQUEST_PATH'] ?? '/');
    $lead_id      = 'lead-modal';
    // без поля «что нужно»: с ним карточка не помещалась в экран и получала
    // собственную полосу прокрутки. Подробности спросим по телефону
    include __DIR__ . '/lead-form.php';
    ?>

    <p class="modal__tel">
      Или позвоните сразу:
      <a href="<?= e(tel_href(main_phone())) ?>"><?= e(main_phone()) ?></a>
    </p>
  </div>
</dialog>
