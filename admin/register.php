<?php
include '../components/connect.php';

?>
<style>
    <?php include '../css/admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin registrer</title>
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <?php


    ?>
    <div class="form-container">
        <form id="registerForm" enctype="multipart/form-data" class="register">
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
                    <input type="password" name="password" placeholder="Придумайте пароль" maxlength="20" required
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
    <script src="../js/app.js"></script>
<script src="../js/modules/register.js"></script>
</body>

</html>