<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$email = htmlspecialchars(
    $_POST['email'],
    ENT_QUOTES,
    'UTF-8'
);

$password = sha1($_POST['password']);


$select_tutor = $conn->prepare("
    SELECT * FROM tutors
    WHERE email = ?
    AND password = ?
    LIMIT 1
");

$select_tutor->execute([
    $email,
    $password
]);


if ($select_tutor->rowCount() > 0) {

    $row = $select_tutor->fetch(PDO::FETCH_ASSOC);

    setcookie(
        'tutor_id',
        $row['id'],
        time() + 60 * 60 * 24 * 30,
        '/'
    );

    echo json_encode([
        'status' => 'success',
        'message' => 'Успешный вход',
        'redirect' => 'dashboard.php'
    ]);

    exit;
}


echo json_encode([
    'status' => 'error',
    'message' => 'Неправильный логин или пароль'
]);

exit;