<?php

include '../../components/connect.php';

header('Content-Type: application/json');


$id = unique_id();

$name = htmlspecialchars(
    $_POST['name'],
    ENT_QUOTES,
    'UTF-8'
);

$profession = htmlspecialchars(
    $_POST['profession'],
    ENT_QUOTES,
    'UTF-8'
);

$email = filter_var(
    $_POST['email'],
    FILTER_SANITIZE_EMAIL
);

$password = sha1($_POST['password']);

$cpass = sha1($_POST['cpass']);


// image

$image = $_FILES['image']['name'];

$image = htmlspecialchars(
    $image,
    ENT_QUOTES,
    'UTF-8'
);

$ext = pathinfo(
    $image,
    PATHINFO_EXTENSION
);

$image_size = $_FILES['image']['size'];

if($image_size > 2000000){

    echo json_encode([
        'status' => 'error',
        'message' => 'Изображение слишком большое'
    ]);

    exit;
}

$rename = unique_id() . '.' . $ext;

$image_tmp_name = $_FILES['image']['tmp_name'];

$image_folder =
    '../../uploaded_files/' . $rename;


// check user

$select_tutor = $conn->prepare("
    SELECT * FROM tutors
    WHERE email = ?
");

$select_tutor->execute([$email]);


if ($select_tutor->rowCount() > 0) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Пользователь уже существует'
    ]);

    exit;
}


// passwords check

if ($password != $cpass) {

    echo json_encode([
        'status' => 'error',
        'message' => 'Пароли не совпадают'
    ]);

    exit;
}


// insert

$insert_tutor = $conn->prepare("
    INSERT INTO tutors
    (
        id,
        name,
        profession,
        email,
        password,
        image
    )
    VALUES(?,?,?,?,?,?)
");

$insert_tutor->execute([
    $id,
    $name,
    $profession,
    $email,
    $cpass,
    $rename
]);


// upload image

move_uploaded_file(
    $image_tmp_name,
    $image_folder
);


echo json_encode([
    'status' => 'success',
    'message' => 'Регистрация успешна',
    'redirect' => 'login.php'
]);

exit;