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

$id = unique_id();

$title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');

$description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

$status = htmlspecialchars($_POST['status'], ENT_QUOTES, 'UTF-8');

$playlist = htmlspecialchars($_POST['playlist'], ENT_QUOTES, 'UTF-8');


// IMAGE

$image = $_FILES['image']['name'];

$image_ext = pathinfo($image, PATHINFO_EXTENSION);

$image_rename = unique_id() . '.' . $image_ext;

$image_tmp = $_FILES['image']['tmp_name'];

$image_size = $_FILES['image']['size'];

$image_folder = '../../uploaded_files/' . $image_rename;


// VIDEO

$video = $_FILES['video']['name'];

$video_ext = pathinfo($video, PATHINFO_EXTENSION);

$video_rename = unique_id() . '.' . $video_ext;

$video_tmp = $_FILES['video']['tmp_name'];

$video_folder = '../../uploaded_files/' . $video_rename;



if ($image_size > 2000000) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Изображение слишком большое'
    ]);

    exit;
}


$insert = $conn->prepare("
    INSERT INTO content
    (id, tutor_id, playlist_id, title, description, video, thumb, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

$insert->execute([
    $id,
    $tutor_id,
    $playlist,
    $title,
    $description,
    $video_rename,
    $image_rename,
    $status
]);


move_uploaded_file($image_tmp, $image_folder);

move_uploaded_file($video_tmp, $video_folder);


echo json_encode([
    'status' => 'success',
    'message' => 'Материал успешно добавлен'
]);