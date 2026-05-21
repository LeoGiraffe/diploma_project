<?php

include '../../components/connect.php';

header('Content-Type: application/json');


if (!isset($_COOKIE['tutor_id'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Авторизуйтесь'
    ]);

    exit;
}

$tutor_id = $_COOKIE['tutor_id'];


// data

$video_id = htmlspecialchars(
    $_POST['video_id'],
    ENT_QUOTES,
    'UTF-8'
);

$status = htmlspecialchars(
    $_POST['status'],
    ENT_QUOTES,
    'UTF-8'
);

$title = htmlspecialchars(
    $_POST['title'],
    ENT_QUOTES,
    'UTF-8'
);

$description = htmlspecialchars(
    $_POST['description'],
    ENT_QUOTES,
    'UTF-8'
);

$playlist = htmlspecialchars(
    $_POST['playlist'],
    ENT_QUOTES,
    'UTF-8'
);


// verify

$verify = $conn->prepare("
    SELECT *
    FROM content
    WHERE id = ?
    AND tutor_id = ?
");

$verify->execute([
    $video_id,
    $tutor_id
]);


if ($verify->rowCount() == 0) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Контент не найден'
    ]);

    exit;
}


$content = $verify->fetch(PDO::FETCH_ASSOC);


// update main

$update = $conn->prepare("
    UPDATE content
    SET
        title = ?,
        description = ?,
        playlist_id = ?,
        status = ?
    WHERE id = ?
");

$update->execute([
    $title,
    $description,
    $playlist,
    $status,
    $video_id
]);


// image

if (!empty($_FILES['image']['name'])) {

    $image = $_FILES['image']['name'];

    $ext = pathinfo(
        $image,
        PATHINFO_EXTENSION
    );

    $rename =
        unique_id() . '.' . $ext;

    $tmp =
        $_FILES['image']['tmp_name'];

    $size =
        $_FILES['image']['size'];

    if ($size > 2000000) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Изображение слишком большое'
        ]);

        exit;
    }

    move_uploaded_file(
        $tmp,
        '../../uploaded_files/' . $rename
    );

    if (
        !empty($content['thumb']) &&
        file_exists(
            '../../uploaded_files/' .
            $content['thumb']
        )
    ) {
        unlink(
            '../../uploaded_files/' .
            $content['thumb']
        );
    }

    $update_thumb = $conn->prepare("
        UPDATE content
        SET thumb = ?
        WHERE id = ?
    ");

    $update_thumb->execute([
        $rename,
        $video_id
    ]);
}


// video

if (!empty($_FILES['video']['name'])) {

    $video = $_FILES['video']['name'];

    $ext = pathinfo(
        $video,
        PATHINFO_EXTENSION
    );

    $rename =
        unique_id() . '.' . $ext;

    $tmp =
        $_FILES['video']['tmp_name'];

    move_uploaded_file(
        $tmp,
        '../../uploaded_files/' . $rename
    );

    if (
        !empty($content['video']) &&
        file_exists(
            '../../uploaded_files/' .
            $content['video']
        )
    ) {
        unlink(
            '../../uploaded_files/' .
            $content['video']
        );
    }

    $update_video = $conn->prepare("
        UPDATE content
        SET video = ?
        WHERE id = ?
    ");

    $update_video->execute([
        $rename,
        $video_id
    ]);
}


echo json_encode([
    'status' => 'success',
    'message' => 'Контент обновлен'
]);

exit;