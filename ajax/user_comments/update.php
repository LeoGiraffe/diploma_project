<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$comment_id = htmlspecialchars($_POST['comment_id'], ENT_QUOTES, 'UTF-8');
$text = htmlspecialchars($_POST['text'], ENT_QUOTES, 'UTF-8');

$check = $conn->prepare("SELECT comment FROM comments WHERE id = ?");
$check->execute([$comment_id]);
$row = $check->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Комментарий не найден'
    ]);
    exit;
}

if ($row['comment'] === $text) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Комментарий не изменился'
    ]);
    exit;
}

$update = $conn->prepare("UPDATE comments SET comment = ? WHERE id = ?");
$update->execute([$text, $comment_id]);

echo json_encode([
    'status' => 'success',
    'message' => 'Комментарий обновлён'
]);
exit;