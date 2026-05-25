<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? null;
$list_id = $_POST['list_id'] ?? null;

if (!$user_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Вы не вошли в аккаунт'
    ]);
    exit;
}

if (!$list_id) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Нет ID плейлиста'
    ]);
    exit;
}

$check = $conn->prepare("SELECT * FROM bookmark WHERE playlist_id = ? AND user_id = ?");
$check->execute([$list_id, $user_id]);

if ($check->rowCount() > 0) {

    $delete = $conn->prepare("DELETE FROM bookmark WHERE playlist_id = ? AND user_id = ?");
    $delete->execute([$list_id, $user_id]);

    echo json_encode([
        'status' => 'success',
        'action' => 'removed',
        'message' => 'Удалено из закладок'
    ]);
    exit;

} else {

    $insert = $conn->prepare("INSERT INTO bookmark (user_id, playlist_id) VALUES (?, ?)");
    $insert->execute([$user_id, $list_id]);

    echo json_encode([
        'status' => 'success',
        'action' => 'added',
        'message' => 'Добавлено в закладки'
    ]);
    exit;
}