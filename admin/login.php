<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {


    $email = $_POST['email'];
    $email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');

    $password = sha1($_POST['password']);



    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?  AND password = ? LIMIT 1");
    $select_tutor->execute([$email, $password]);
    $row = $select_tutor->fetch(PDO::FETCH_ASSOC);

    if ($select_tutor->rowCount() > 0) {
        setcookie('tutor_id', $row['id'], time() + 60 * 60 * 24 * 30, '/');
        header('location: dashboard.php');

    } else {
        $message[] = 'Неправильный логин или пароль';
    }
}
?>
<style>
    <?php include '../css/admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin login</title>
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <?php

    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
        </div>
        ';
        }
    }
    ?>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data" class="login">
            <h3>Войти</h3>
            <p>email<span>*</span></p>
            <input type="email" name="email" placeholder="Введите email" maxlength="50" required class="box">
            <p>пароль<span>*</span></p>
            <input type="password" name="password" placeholder="Ведите пароль" maxlength="20" required class="box">

            <p class="link">Еще нет аккаунта?<a href="register.php"> Зарегистрируйтесь</a></p>
            <input type="submit" name="submit" class="btn" value="Войти">
        </form>
    </div>
</body>

</html>