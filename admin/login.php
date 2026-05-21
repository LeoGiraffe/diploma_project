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
    <title>admin login</title>
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <?php


    ?>
    <div class="form-container">
        <form id="loginForm" class="login">
            <h3>Войти</h3>
            <p>email<span>*</span></p>
            <input type="email" name="email" placeholder="Введите email" maxlength="50" required class="box">
            <p>пароль<span>*</span></p>
            <input type="password" name="password" placeholder="Ведите пароль" maxlength="20" required class="box">

            <p class="link">Еще нет аккаунта?<a href="register.php"> Зарегистрируйтесь</a></p>
            <input type="submit" name="submit" class="btn" value="Войти">
        </form>
    </div>
 <script src="../js/app.js"></script>
<script src="../js/modules/auth.js"></script>
</body>

</html>