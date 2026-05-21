<?php

include '../../components/connect.php';

header('Content-Type: application/json');

if (!isset($_COOKIE['tutor_id'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Необходимо авторизоваться'
    ]);

    exit;
}

$delete_id = htmlspecialchars(
    $_POST['comment_id'],
    ENT_QUOTES,
    'UTF-8'
);


$verify = $conn->prepare("
    SELECT * FROM comments
    WHERE id = ?
");

$verify->execute([$delete_id]);


if ($verify->rowCount() == 0) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Комментарий уже удален'
    ]);

    exit;
}


$delete = $conn->prepare("
    DELETE FROM comments
    WHERE id = ?
");

$delete->execute([$delete_id]);


echo json_encode([
    'status' => 'success',
    'message' => 'Комментарий удален'
]);