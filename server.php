<?php
$filename = 'messages.json';

// 1. Обработка сохранения нового сообщения
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $text = htmlspecialchars($_POST['text'] ?? '');

    if ($name && $text) {
        $messages = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];
        $messages[] = ['name' => $name, 'text' => $text];
        file_put_contents($filename, json_encode($messages, JSON_UNESCAPED_UNICODE));
        
        // Отдаем новое сообщение в формате HTML для JS
        echo "<div class='message'><strong>$name:</strong> $text</div>";
    }
    exit;
}

// 2. Функция для начальной загрузки сообщений (вызывается в index.php)
function getMessages($filename) {
    if (file_exists($filename)) {
        $messages = json_decode(file_get_contents($filename), true);
        if (is_array($messages)) {
            foreach ($messages as $m) {
                echo "<div class='message'><strong>{$m['name']}:</strong> {$m['text']}</div>";
            }
        }
    }
}
?>
