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

$tutor_id = $_COOKIE['tutor_id'];

$select_tutor = $conn->prepare(
    'SELECT * FROM `tutors`
     WHERE id = ?
     LIMIT 1'
);

$select_tutor->execute([
    $tutor_id
]);

$tutor = $select_tutor->fetch(
    PDO::FETCH_ASSOC
);

$prev_pass = $tutor['password'];
$prev_image = $tutor['image'];

$name =
    htmlspecialchars(
        trim($_POST['name'])
    );

$profession =
    htmlspecialchars(
        trim($_POST['profession'])
    );

$email =
    filter_var(
        $_POST['email'],
        FILTER_SANITIZE_EMAIL
    );

if (!empty($name)) {

    $update = $conn->prepare(
        "UPDATE `tutors`
         SET name = ?
         WHERE id = ?"
    );

    $update->execute([
        $name,
        $tutor_id
    ]);
}

if (!empty($profession)) {

    $update = $conn->prepare(
        "UPDATE `tutors`
         SET profession = ?
         WHERE id = ?"
    );

    $update->execute([
        $profession,
        $tutor_id
    ]);
}

if (!empty($email)) {

    $check = $conn->prepare(
        "SELECT *
         FROM `tutors`
         WHERE email = ?
         AND id != ?"
    );

    $check->execute([
        $email,
        $tutor_id
    ]);

    if ($check->rowCount() > 0) {

        echo json_encode([
            'status' => 'error',
            'message' => 'Email уже занят'
        ]);

        exit;
    }

    $update = $conn->prepare(
        "UPDATE `tutors`
         SET email = ?
         WHERE id = ?"
    );

    $update->execute([
        $email,
        $tutor_id
    ]);
}

if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] === 0
) {

    $image =
        $_FILES['image']['name'];

    if (!empty($image)) {

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
            '../../uploaded_files/' .
            $rename
        );

        $update = $conn->prepare(
            "UPDATE `tutors`
             SET image = ?
             WHERE id = ?"
        );

        $update->execute([
            $rename,
            $tutor_id
        ]);

        if (
            !empty($prev_image) &&
            file_exists(
                '../../uploaded_files/' .
                $prev_image
            )
        ) {

            unlink(
                '../../uploaded_files/' .
                $prev_image
            );
        }
    }
}

$old_pass =
    sha1($_POST['old_pass']);

$new_pass =
    sha1($_POST['new_pass']);

$cpass =
    sha1($_POST['cpass']);

$empty_pass =
    sha1('');

if ($old_pass != $empty_pass) {

    if ($old_pass != $prev_pass) {

        echo json_encode([
            'status' => 'error',
            'message' =>
                'Старый пароль неверный'
        ]);

        exit;
    }

    if ($new_pass != $cpass) {

        echo json_encode([
            'status' => 'error',
            'message' =>
                'Пароли не совпадают'
        ]);

        exit;
    }

    $update = $conn->prepare(
        "UPDATE `tutors`
         SET password = ?
         WHERE id = ?"
    );

    $update->execute([
        $new_pass,
        $tutor_id
    ]);
}

echo json_encode([
    'status' => 'success',
    'message' => 'Профиль обновлен'
]);