<?php

include 'components/connect.php';



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location:login.php');

}

if (isset($_POST['submit'])) {
    $select_user = $conn->prepare('SELECT * FROM `users` WHERE id = ? LIMIT 1');
    $select_user->execute([$user_id]);
    $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_user['password'];
    $prev_image = $fetch_user['image'];

    $name = $_POST['name'];
    $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');


    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!empty($name)) {
        $update_name = $conn->prepare("UPDATE `users` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $user_id]);
        $message[] = 'Имя успешно обновлено';
    }
    
    if (!empty($email)) {
        $select_email = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND id != ?");
        $select_email->execute([$email, $user_id]);
        if ($select_email->rowCount() > 0) {
            $message[] = "Этот mail уже занят";
        } else {
            $update_email = $conn->prepare("UPDATE `users` SET email = ? WHERE id = ?");
            $update_email->execute([$email, $user_id]);
            $message[] = 'Email успешно обновлен';
        }
    }

    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_files/' . $rename;

    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Размер изображения слишком большой';
        } else {
            $update_image = $conn->prepare("UPDATE `users` SET image = ? WHERE id = ?");
            $update_image->execute([$rename, $user_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($prev_image != '' AND $prev_image != $rename) {
                unlink('uploaded_files/' . $prev_image);
            }
            $message[] = 'Фото успешно обновлено';
        }
    }

    $empty_pass = 'ada6afc8d40f8f0230014fbc2f20eb5c2b60a252';
    $old_pass = sha1($_POST['old_password']);
    $new_pass = sha1($_POST['new_password']);
    $cpass = sha1($_POST['cpass']);

    if ($old_pass != $empty_pass) {
        if ($old_pass != $prev_pass) {
            $message[] = 'Старый пароль не совпадает';
        } elseif ($new_pass != $cpass) {
            $message[] = 'Новый пароль не совпадает';
        } else {
            if ($new_pass != $empty_pass) {
                $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
                $update_pass->execute([$cpass, $tutor_id]);
                $message[] = 'Пароль успешно обновлен';
            } else {
                $message[] = 'Пожалуйста введите новый пароль';
            }
        }
    }
}





?>




<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать профиль</title>

    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <!-----------banner----------->


    <div class="banner">
        <div class="detail">
            <div class="title">
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Редактировать профиль</span>
            </div>
            <h1>Редактировать профиль</h1>
            <p>Создайте аккаунт за пару минут и получите доступ ко всем курсам. Учитесь в своём темпе, сохраняйте
                прогресс и общайтесь с преподавателями. Регистрация бесплатна — платите только за те курсы, которые
                выберете.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>

            </div>

        </div>
        <img src="image/banner.png" alt="">
    </div>
    <!-----------registration----------->
    <section class="form-container">
        <div class="heading">
            <h1>Редактировать профиль</h1>
        </div>
       <form class="register" id="profileForm" enctype="multipart/form-data">
            <div class="flex">
                <div class="col">
                    <p>имя<span>*</span></p>
                    <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50"
                        class="box">
                    <p>email<span>*</span></p>
                    <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="50"
                         class="box">
                    <p>Обновить фотографию<span>*</span></p>
                    <input type="file" name="image" accept="image/*" class="box">
                </div>
                <div class="col">
                    <p>старый пароль<span>*</span></p>
                    <input type="password" name="old_password" placeholder="Cтарый пароль" maxlength="20" 
                        class="box">
                    <p>пароль<span>*</span></p>
                    <input type="password" name="new_password" placeholder="Придумайте новый пароль" maxlength="20" 
                        class="box">
                    <p>пароль<span>*</span></p>
                    <input type="password" name="cpass" placeholder="Подтвердите пароль" maxlength="20" 
                        class="box">
                </div>
            </div>
            <input type="submit" name="submit" class="btn" value="Редактировать профиль">
        </form>

    </section>





    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
    <script src="js/app.js"></script>
    <script src="js/modules/user/profile-update.js"></script>
</body>

</html>