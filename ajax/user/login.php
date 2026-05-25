<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$password = sha1($_POST['password']);

$select_user = $conn->prepare("
    SELECT * FROM users
    WHERE email = ?
    AND password = ?
    LIMIT 1
");

$select_user->execute([
    $email,
    $password
]);

if ($select_user->rowCount() > 0) {

    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    setcookie(
        'user_id',
        $row['id'],
        time() + 60 * 60 * 24 * 30,
        '/'
    );

    echo json_encode([
        'status' => 'success',
        'message' => 'Успешный вход',
        'redirect' => 'index.php'
    ]);

    exit;
}

echo json_encode([
    'status' => 'error',
    'message' => 'Неправильный логин или пароль'
]);

exit;