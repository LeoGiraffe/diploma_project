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
    <title>Контакты</title>

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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Контакты</span>
            </div>
            <h1>Контакты</h1>
            <p>Создайте аккаунт за пару минут и получите доступ ко всем курсам. Учитесь в своём темпе, сохраняйте
                прогресс и общайтесь с преподавателями. Регистрация бесплатна — платите только за те курсы, которые
                выберете.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="courses.php" class="btn">Курсы</a>

            </div>

        </div>
        <img src="image/banner.png" alt="">
    </div>
    <!-----------conatct----------->
    <section class="contact">
        <div class="adress_detail">
            <div class="box">
                <i class="bx bxs-phone"></i>
                <h3>Номер телефона</h3>
                <a href="tel: +7-(123)-456-78-90">+7-(123)-456-78-90</a>
                <a href="tel: +7-(123)-456-78-90">+7-(123)-456-78-90</a>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"></i>
                <h3>Электронная почта</h3>
                <a href="4iM0Q@example.com"> 4iM0Q@example.com</a>
                <a href="4iM0Q@example.com"> 4iM0Q@example.com</a>
            </div>
            <div class="box">
                <i class="bx bxs-envelope"></i>
                <h3>Адресс офиса</h3>
                <a href="#">г. Москва, ул. Пушкина, 123</a>
            </div>
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/contact.jpg">
            </div>
            <form class="contact-form">
                <div class="heading">
                    <span>Образование доступное каждому</span>
                    <h1>Свяжитесь с нами</h1>
                </div>
                <div class="input-field">
                    <p>Имя<span>*</span></p>
                    <input type="text" name="name" maxlength="100" required class="box">
                </div>
                <div class="input-field">
                    <p>email<span>*</span></p>
                    <input type="email" name="email" maxlength="100" required class="box">
                </div>
                <div class="input-field">
                    <p>Номер телефона<span>*</span></p>
                    <input type="number" name="number" min="0" maxlength="10" max="99999999999999999" required class="box">
                </div>
                <div class="input-field">
                    <p>Сообщение<span>*</span></p>
                    <textarea name="message" class="box" cols="30" rows="10" maxlength="1000" class="box"
                        rows=" "></textarea>
                    <input type="submit" value="Отправить" class="btn">
                </div>
            </form>
        </div>

    </section>

    <div style="position:relative;overflow:hidden;"><a
            href="https://yandex.ru/maps/10737/luhovicy/?utm_medium=mapframe&utm_source=maps"
            style="color:#eee;font-size:12px;position:absolute;top:0px;">Москва</a><a
            href="https://yandex.ru/maps/10737/luhovicy/house/ulitsa_pushkina_123a/Z0AYdgVoS0MHQFtufXV3dn5nbQ==/?ll=39.030983%2C54.967255&utm_medium=mapframe&utm_source=maps&z=16.68"
            style="color:#eee;font-size:12px;position:absolute;top:14px;">Улица Пушкина, 123А — Яндекс Карты</a><iframe
            src="https://yandex.ru/map-widget/v1/?ll=39.030983%2C54.967255&mode=search&ol=geo&ouri=ymapsbm1%3A%2F%2Fgeo%3Fdata%3DCgg1NjU5MzIyMBJl0KDQvtGB0YHQuNGPLCDQnNC-0YHQutC-0LLRgdC60LDRjyDQvtCx0LvQsNGB0YLRjCwg0JvRg9GF0L7QstC40YbRiywg0YPQu9C40YbQsCDQn9GD0YjQutC40L3QsCwgMTIz0JAiCg3xHBxCFXbeW0I%2C&z=16.68"
            width="100%" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe></div>




    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
    <script src="js/app.js"></script>
    <script src="js/modules/user/contact.js"></script>
</body>

</html>