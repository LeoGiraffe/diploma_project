<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
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
    <title>Редактировать профиль</title>
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="form-container" style="min-height: calc(100vh - 19rem); padding: 5rem;">
        <form id="profileUpdateForm" enctype="multipart/form-data" class="register">
            <h3>Редактировать профиль</h3>
            <div class="flex">
                <div class="col">
                    <p>имя<span>*</span></p>
                    <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50"
                        class="box">
                    <p>Должность<span>*</span></p>
                    <select name="profession" required class="box">
                        <option value="" disabled selected><?= $fetch_profile['profession']; ?></option>
                        <option value="Разработчик игр">Разработчик игр</option>
                        <option value="Разработчик мобильных приложений">Разработчик мобильных приложений</option>
                    </select>
                    <p>email<span>*</span></p>
                    <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="50"
                        class="box">
                </div>
                <div class="col">
                    <p>старый пароль<span>*</span></p>
                    <input type="password" name="old_pass" placeholder="Введите старый пароль" maxlength="20"
                        class="box">
                    <p>Новый пароль<span>*</span></p>
                    <input type="password" name="new_pass" placeholder="Придумайте новый пароль" maxlength="20"
                        class="box">
                    <p>Подтвердите пароль<span>*</span></p>
                    <input type="password" name="cpass" placeholder="Введите новый пароль" maxlength="20" class="box">

                </div>
            </div>
            <p>Сменить фотографию<span>*</span></p>
            <input type="file" name="image" accept="image/*" class="box">
            <button type="submit" class="btn">
                Сохранить
            </button>
        </form>
    </div>
    <?php include '../components/footer.php'; ?>
    <script src="../js/admin_script.js"></script>
     <script src="../js/app.js"></script>
    <script src="../js/modules/profile-update.js"></script>
</body>

</html>