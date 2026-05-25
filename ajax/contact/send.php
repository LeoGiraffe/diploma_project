<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$number = htmlspecialchars($_POST['number'], ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars($_POST['message'], ENT_QUOTES, 'UTF-8');

if ($name == '' || $email == '' || $number == '' || $message == '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Заполните все поля'
    ]);
    exit;
}

$check = $conn->prepare("
    SELECT * FROM contact 
    WHERE name=? AND email=? AND number=? AND message=? 
    LIMIT 1
");

$check->execute([$name, $email, $number, $message]);

if ($check->rowCount() > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Сообщение уже отправлено'
    ]);
    exit;
}

$insert = $conn->prepare("
    INSERT INTO contact (name, email, number, message)
    VALUES (?, ?, ?, ?)
");

$insert->execute([$name, $email, $number, $message]);

echo json_encode([
    'status' => 'success',
    'message' => 'Сообщение отправлено'
]);

exit;