<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$comment_id = $_POST['comment_id'] ?? null;

if (!$comment_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'ID не передан'
    ]);
    exit;
}

$check = $conn->prepare("SELECT id FROM comments WHERE id = ?");
$check->execute([$comment_id]);

if ($check->rowCount() == 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Комментарий уже удалён'
    ]);
    exit;
}

$delete = $conn->prepare("DELETE FROM comments WHERE id = ?");
$delete->execute([$comment_id]);

echo json_encode([
    'status' => 'success',
    'message' => 'Комментарий удалён'
]);

exit;