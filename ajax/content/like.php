<?php
include '../../components/connect.php';

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? '';
$content_id = $_POST['content_id'] ?? '';

if ($user_id == '' || $content_id == '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Сначала войдите'
    ]);
    exit;
}

$check = $conn->prepare("SELECT * FROM likes WHERE content = ? AND user_id = ?");
$check->execute([$content_id, $user_id]);

if ($check->rowCount() > 0) {
    $del = $conn->prepare("DELETE FROM likes WHERE content = ? AND user_id = ?");
    $del->execute([$content_id, $user_id]);

    echo json_encode([
        'status' => 'removed',
        'message' => 'Лайк убран'
    ]);
} else {
    $get = $conn->prepare("SELECT tutor_id FROM content WHERE id = ?");
    $get->execute([$content_id]);
    $tutor_id = $get->fetchColumn();

    $ins = $conn->prepare("INSERT INTO likes(content, user_id, tutor_id) VALUES(?,?,?)");
    $ins->execute([$content_id, $user_id, $tutor_id]);

    echo json_encode([
        'status' => 'added',
        'message' => 'Лайк добавлен'
    ]);
}
exit;