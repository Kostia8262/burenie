<?php
/**
 * Приём заявки. Пишет в лог, шлёт письмо и — если задан бот — в Telegram.
 * Отвечает JSON для fetch и редиректом для формы без JS.
 */

$ajax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';

function lead_reply(bool $ok, string $msg): never
{
    global $ajax;
    if ($ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'msg' => $msg], JSON_UNESCAPED_UNICODE);
    } elseif ($ok) {
        header('Location: /spasibo/', true, 303);
    } else {
        header('Location: /kontakty/?error=1#zayavka', true, 303);
    }
    exit;
}

// ловушка для ботов
if (!empty($_POST['website'])) {
    lead_reply(true, 'Заявка принята.');
}

$name    = trim((string) ($_POST['name'] ?? ''));
$phone   = trim((string) ($_POST['phone'] ?? ''));
$place   = trim((string) ($_POST['place'] ?? ''));
$comment = trim((string) ($_POST['comment'] ?? ''));
$source  = trim((string) ($_POST['source'] ?? ''));

$digits = preg_replace('/\D/', '', $phone);

if (mb_strlen($name) < 2) {
    lead_reply(false, 'Напишите, пожалуйста, имя.');
}
if (strlen($digits) < 10) {
    lead_reply(false, 'Проверьте номер телефона — кажется, он неполный.');
}

// не чаще одной заявки в минуту с одного адреса
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
$stamp = sys_get_temp_dir() . '/lead_' . md5($ip);
if (is_file($stamp) && time() - filemtime($stamp) < 60) {
    lead_reply(false, 'Заявка уже ушла. Если нужно срочно — позвоните: ' . main_phone());
}
@touch($stamp);

$lines = [
    'Имя:      ' . $name,
    'Телефон:  ' . $phone,
    'Участок:  ' . ($place ?: '—'),
    'Задача:   ' . ($comment ?: '—'),
    'Страница: ' . $source,
    'Время:    ' . date('d.m.Y H:i'),
];
$body = implode("\n", $lines);

@file_put_contents(LEAD_LOG, $body . "\n" . str_repeat('-', 40) . "\n", FILE_APPEND | LOCK_EX);

// письмо
$subject = '=?UTF-8?B?' . base64_encode('Заявка с сайта: ' . $name) . '?=';
$headers = implode("\r\n", [
    'From: Сайт <noreply@' . SITE['host'] . '>',
    'Reply-To: noreply@' . SITE['host'],
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . PHP_VERSION,
]);
@mail(SITE['email'], $subject, $body, $headers);

// telegram, если бот настроен
if (LEAD_TG_TOKEN !== '' && LEAD_TG_CHAT !== '') {
    $url = 'https://api.telegram.org/bot' . LEAD_TG_TOKEN . '/sendMessage';
    $payload = http_build_query([
        'chat_id' => LEAD_TG_CHAT,
        'text'    => "Заявка с сайта\n\n" . $body,
    ]);
    $ctx = stream_context_create(['http' => [
        'method'        => 'POST',
        'header'        => 'Content-Type: application/x-www-form-urlencoded',
        'content'       => $payload,
        'timeout'       => 5,
        'ignore_errors' => true,
    ]]);
    @file_get_contents($url, false, $ctx);
}

lead_reply(true, 'Заявка у нас. Перезвоним в ближайшее рабочее время.');
