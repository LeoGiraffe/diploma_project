<?php
include '../components/connect.php';

if (isset($_POST['submit'])) {
    $id = unique_id();
    $name = $_POST['name'];
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

    $profession = $_POST['profession'];
    $profession = htmlspecialchars($profession, ENT_QUOTES, 'UTF-8');

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $password = sha1($_POST['password']);

    $cpass = sha1($_POST['cpass']);


    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ?");
    $select_tutor->execute([$email]);

    if ($select_tutor->rowCount() > 0) {
        $message[] = 'user already exist';
    } else {
        if ($password != $cpass) {
            $message[] = 'Пароли не совпадают';
        } else {
            $insert_tutor = $conn->prepare("INSERT INTO `tutors`(id, name, profession, email, password, image) VALUES(?,?,?,?,?,?)");
            $insert_tutor->execute([$id, $name, $profession, $email, $cpass, $rename]);
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = "Новый преподователь зарегестрирован";
        }
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
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>зарегистрируйтесь</h3>
            <div class="flex">
                <div class="col">
                    <p>имя<span>*</span></p>
                    <input type="text" name="name" placeholder="Введите имя" maxlength="50" required class="box">
                    <p>Должность<span>*</span></p>
                    <select name="profession" required class="box">
                        <option value="" disabled selected>Выберите должность</option>
                        <option value="Разработчик игр">Разработчик игр</option>
                        <option value="Разработчик мобильных приложений">Разработчик мобильных приложений</option>
                    </select>
                    <p>email<span>*</span></p>
                    <input type="email" name="email" placeholder="Введите email" maxlength="50" required class="box">
                </div>
                <div class="col">
                    <p>пароль<span>*</span></p>
                    <input type="password" name="password" placeholder="ПРидумайте пароль" maxlength="20" required
                        class="box">
                    <p>пароль<span>*</span></p>
                    <input type="password" name="cpass" placeholder="Подтвердите пароль" maxlength="20" required
                        class="box">
                    <p>Выберите фотографию<span>*</span></p>
                    <input type="file" name="image" accept="image/*" required class="box">
                </div>
            </div>
            <p class="link">Уже зарегестрированы? <a href="login.php">Войти</a></p>
            <input type="submit" name="submit" class="btn" value="зарегистрируйтесь">
        </form>
    </div>
</body>

</html>