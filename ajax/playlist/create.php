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

$tutor_id = $_COOKIE['tutor_id'];

$title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');

$description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

$status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

$image = $_FILES['image']['name'];

$ext = pathinfo($image, PATHINFO_EXTENSION);

$rename = unique_id() . '.' . $ext;

$image_tmp_name = $_FILES['image']['tmp_name'];

$image_folder = '../../uploaded_files/' . $rename;

$id = unique_id();

$insert = $conn->prepare("
    INSERT INTO playlist
    (id, tutor_id, title, description, thumb, status)
    VALUES (?, ?, ?, ?, ?, ?)
");

$insert->execute([
    $id,
    $tutor_id,
    $title,
    $description,
    $rename,
    $status
]);

move_uploaded_file($image_tmp_name, $image_folder);

echo json_encode([
    'status' => 'success',
    'message' => 'Плейлист успешно создан'
]);