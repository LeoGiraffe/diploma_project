<?php

include '../../components/connect.php';

header('Content-Type: application/json');

if (!isset($_COOKIE['tutor_id'])) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Не авторизован'
    ]);

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'status' => 'error',
        'message' => 'Неверный запрос'
    ]);

    exit;
}

$playlist_id =
    htmlspecialchars(
        $_POST['playlist_id']
    );

$title =
    htmlspecialchars(
        trim($_POST['title'])
    );

$description =
    htmlspecialchars(
        trim($_POST['description'])
    );

$status =
    htmlspecialchars(
        trim($_POST['status'])
    );

$update_playlist = $conn->prepare(
    'UPDATE `playlist`
     SET title = ?,
         description = ?,
         status = ?
     WHERE id = ?'
);

$update_playlist->execute([
    $title,
    $description,
    $status,
    $playlist_id
]);

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === 0 &&
    !empty($_FILES['image']['name'])
) {

    $old_image =
        $_POST['old_image'];

    $image =
        $_FILES['image']['name'];

    $ext =
        pathinfo(
            $image,
            PATHINFO_EXTENSION
        );

    $rename =
        unique_id() .
        '.' .
        $ext;

    $tmp_name =
        $_FILES['image']['tmp_name'];

    $size =
        $_FILES['image']['size'];

    if ($size > 2000000) {

        echo json_encode([
            'status' => 'error',
            'message' =>
                'Размер изображения слишком большой'
        ]);

        exit;
    }

    move_uploaded_file(
        $tmp_name,
        '../../uploaded_files/' . $rename
    );

    $update_image = $conn->prepare(
        "UPDATE `playlist`
         SET thumb = ?
         WHERE id = ?"
    );

    $update_image->execute([
        $rename,
        $playlist_id
    ]);

    if (
        !empty($old_image) &&
        file_exists(
            '../../uploaded_files/' .
            $old_image
        )
    ) {

        unlink(
            '../../uploaded_files/' .
            $old_image
        );
    }
}

echo json_encode([
    'status' => 'success',
    'message' => 'Плейлист обновлен'
]);