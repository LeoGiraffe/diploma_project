<?php
include '../../components/connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Неверный метод запроса'
    ]);
    exit;
}

$id = unique_id();

$name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

$password = sha1($_POST['password']);
$cpass = sha1($_POST['cpass']);

$image = $_FILES['image']['name'];
$ext = pathinfo($image, PATHINFO_EXTENSION);
$rename = unique_id() . '.' . $ext;

$image_size = $_FILES['image']['size'];
$tmp = $_FILES['image']['tmp_name'];
$folder = '../../uploaded_files/' . $rename;

// проверка email
$select = $conn->prepare("SELECT id FROM users WHERE email = ?");
$select->execute([$email]);

if ($select->rowCount() > 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Email уже существует'
    ]);
    exit;
}

// проверка пароля
if ($password !== $cpass) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Пароли не совпадают'
    ]);
    exit;
}

// размер файла
if ($image_size > 2000000) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Файл слишком большой'
    ]);
    exit;
}

// insert
$insert = $conn->prepare("
    INSERT INTO users (id, name, email, password, image)
    VALUES (?, ?, ?, ?, ?)
");
$insert->execute([$id, $name, $email, $password, $rename]);

move_uploaded_file($tmp, $folder);

// auto login cookie
setcookie('user_id', $id, time() + 60*60*24*30, '/');

echo json_encode([
    'status' => 'success',
    'message' => 'Регистрация успешна'
]);