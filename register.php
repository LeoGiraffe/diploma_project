<?php

include 'components/connect.php';



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';

}








?>




<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>

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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Регистрация</span>
            </div>
            <h1>Регистрация</h1>
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
            <span>Присоединяйтесь к нам</span>
            <h1>Создать аккаунт</h1>
        </div>
        <form class="register-form" action="" method="post" enctype="multipart/form-data">
            <div class="flex">
                <div class="col">
                    <p>имя<span>*</span></p>
                    <input type="text" name="name" placeholder="Введите имя" maxlength="50" required class="box">
                    <p>email<span>*</span></p>
                    <input type="email" name="email" placeholder="Введите email" maxlength="50" required class="box">
                </div>
                <div class="col">
                    <p>пароль<span>*</span></p>
                    <input type="password" name="password" placeholder="Придумайте пароль" maxlength="20" required
                        class="box">
                    <p>пароль<span>*</span></p>
                    <input type="password" name="cpass" placeholder="Подтвердите пароль" maxlength="20" required
                        class="box">
                </div>
            </div>
            <p>Выберите фотографию<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box" class="choose_photo">
            <p class="link">Уже зарегестрированы? <a href="login.php">Войти</a></p>
            <input type="submit" name="submit" class="btn" value="зарегистрируйтесь">
        </form>

    </section>





    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
    <script src="js/app.js"></script>

    <script src="js/modules/user/register.js"></script>
</body>

</html>