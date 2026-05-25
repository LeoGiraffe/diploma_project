<?php

include '../../components/connect.php';

header('Content-Type: application/json');

$user_id = $_COOKIE['user_id'] ?? '';

if ($user_id == '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Не авторизован'
    ]);
    exit;
}

$select_user = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$select_user->execute([$user_id]);
$user = $select_user->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Пользователь не найден'
    ]);
    exit;
}

/* ---------------- DATA ---------------- */

$name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);

/* ---------------- UPDATE NAME ---------------- */

if ($name !== '' && $name != $user['name']) {
    $update = $conn->prepare("UPDATE users SET name = ? WHERE id = ?");
    $update->execute([$name, $user_id]);
}

/* ---------------- UPDATE EMAIL ---------------- */

if ($email !== '' && $email != $user['email']) {

    $check = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
    $check->execute([$email, $user_id]);

    if ($check->rowCount() > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Email уже занят'
        ]);
        exit;
    }

    $update = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
    $update->execute([$email, $user_id]);
}

/* ---------------- IMAGE ---------------- */

if (!empty($_FILES['image']['name'])) {

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];
    $size = $_FILES['image']['size'];

    if ($size > 2000000) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Слишком большой файл'
        ]);
        exit;
    }

    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $new_name = uniqid() . '.' . $ext;

    move_uploaded_file($tmp, '../../uploaded_files/' . $new_name);

    if (!empty($user['image'])) {
        @unlink('../../uploaded_files/' . $user['image']);
    }

    $update = $conn->prepare("UPDATE users SET image = ? WHERE id = ?");
    $update->execute([$new_name, $user_id]);
}

/* ---------------- PASSWORD ---------------- */

$old = sha1($_POST['old_password'] ?? '');
$new = sha1($_POST['new_password'] ?? '');
$confirm = sha1($_POST['cpass'] ?? '');

if ($old !== sha1('')) {

    if ($old != $user['password']) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Старый пароль неверный'
        ]);
        exit;
    }

    if ($new != $confirm) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Пароли не совпадают'
        ]);
        exit;
    }

    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update->execute([$new, $user_id]);
}

echo json_encode([
    'status' => 'success',
    'message' => 'Профиль обновлён'
]);