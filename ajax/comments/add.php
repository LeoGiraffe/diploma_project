<?php
include '../../components/connect.php';

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? '';
$content_id = $_POST['content_id'] ?? '';
$comment = trim($_POST['comment'] ?? '');

if ($user_id == '' || $content_id == '' || $comment == '') {
    echo json_encode(['status' => 'error', 'message' => 'Заполните поля']);
    exit;
}

$check = $conn->prepare("SELECT id FROM comments WHERE content_id=? AND user_id=? AND comment=?");
$check->execute([$content_id, $user_id, $comment]);

if ($check->rowCount() > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Комментарий уже существует']);
    exit;
}

$id = uniqid();

$get = $conn->prepare("SELECT tutor_id FROM content WHERE id=?");
$get->execute([$content_id]);
$tutor_id = $get->fetchColumn();

$ins = $conn->prepare("INSERT INTO comments(id, content_id, user_id, tutor_id, comment) VALUES(?,?,?,?,?)");
$ins->execute([$id, $content_id, $user_id, $tutor_id, $comment]);

echo json_encode([
    'status' => 'success',
    'message' => 'Комментарий добавлен'
]);
exit;