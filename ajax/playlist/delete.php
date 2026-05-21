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

$playlist_id = htmlspecialchars(
    $_POST['playlist_id'],
    ENT_QUOTES,
    'UTF-8'
);


$verify_playlist = $conn->prepare("
    SELECT * FROM playlist
    WHERE id = ?
    AND tutor_id = ?
    LIMIT 1
");

$verify_playlist->execute([
    $playlist_id,
    $tutor_id
]);


if ($verify_playlist->rowCount() == 0) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Плейлист не найден'
    ]);

    exit;
}


$playlist = $verify_playlist->fetch(PDO::FETCH_ASSOC);


// delete thumb

$thumb_path = '../../uploaded_files/' . $playlist['thumb'];

if (file_exists($thumb_path)) {
    unlink($thumb_path);
}


// delete bookmarks

$delete_bookmark = $conn->prepare("
    DELETE FROM bookmark
    WHERE playlist_id = ?
");

$delete_bookmark->execute([$playlist_id]);


// delete content

$select_content = $conn->prepare("
    SELECT * FROM content
    WHERE playlist_id = ?
");

$select_content->execute([$playlist_id]);

while ($content = $select_content->fetch(PDO::FETCH_ASSOC)) {

    $video_path = '../../uploaded_files/' . $content['video'];

    $thumb_content = '../../uploaded_files/' . $content['thumb'];

    if (file_exists($video_path)) {
        unlink($video_path);
    }

    if (file_exists($thumb_content)) {
        unlink($thumb_content);
    }
}


// delete content rows

$delete_content = $conn->prepare("
    DELETE FROM content
    WHERE playlist_id = ?
");

$delete_content->execute([$playlist_id]);


// delete playlist

$delete_playlist = $conn->prepare("
    DELETE FROM playlist
    WHERE id = ?
");

$delete_playlist->execute([$playlist_id]);


echo json_encode([
    'status' => 'success',
    'message' => 'Плейлист успешно удален'
]);

exit;