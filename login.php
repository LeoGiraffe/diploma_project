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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Войти</span>
            </div>
            <h1>Уже присоединились</h1>
            <p>Войдите в свой аккаунт, чтобы продолжить обучение. Здесь вас ждут ваши курсы, прогресс и личные
                сообщения.</p>
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
            <h1>Войти</h1>
        </div>
        <form class="login">

            <p>email</p>
            <input type="email" name="email" placeholder="Введите email" required class="box">

            <p>пароль</p>
            <input type="password" name="password" placeholder="Введите пароль" required class="box">

            <p class="link">
                Еще нет аккаунта? <a href="register.php">Регистрация</a>
            </p>

            <input type="submit" class="btn" value="Войти">
        </form>

    </section>





    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
    <script src="js/app.js"></script>
    <script src="js/modules/user/login.js"></script>
</body>

</html>