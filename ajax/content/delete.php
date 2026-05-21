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
    $_POST['video_id'],
    ENT_QUOTES,
    'UTF-8'
);


$verify = $conn->prepare("
    SELECT * FROM content
    WHERE id = ?
    LIMIT 1
");

$verify->execute([$delete_id]);


if ($verify->rowCount() == 0) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Видео не найдено'
    ]);

    exit;
}


$video = $verify->fetch(PDO::FETCH_ASSOC);


// delete thumb

$thumb_path = '../../uploaded_files/' . $video['thumb'];

if (file_exists($thumb_path)) {
    unlink($thumb_path);
}


// delete video

$video_path = '../../uploaded_files/' . $video['video'];

if (file_exists($video_path)) {
    unlink($video_path);
}


// delete likes

$delete_likes = $conn->prepare("
    DELETE FROM likes
    WHERE content = ?
");

$delete_likes->execute([$delete_id]);


// delete comments

$delete_comments = $conn->prepare("
    DELETE FROM comments
    WHERE content_id = ?
");

$delete_comments->execute([$delete_id]);


// delete content

$delete_content = $conn->prepare("
    DELETE FROM content
    WHERE id = ?
");

$delete_content->execute([$delete_id]);


echo json_encode([
    'status' => 'success',
    'message' => 'Видео успешно удалено'
]);