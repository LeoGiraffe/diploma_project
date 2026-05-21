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
    <title>Добавить плейлист</title>
    <!-- boxicons -->
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- css -->

</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="video-form">
        <h1 class="heading">Добавить материалы</h1>
        <form id="contentForm" enctype="multipart/form-data">
            <p>Статус плейлиста <span>*</span></p>
            <select name="status" class="box">
                <option value="" selected disabled>---выбрать статус---</option>
                <option value="active">Активный</option>
                <option value="deactive">Неактивный</option>
            </select>
            <p>Название материала <span>*</span></p>
            <input type="text" name="title" maxlength="150" placeholder="Введите название материала" class="box">
            <p>Описание<span>*</span></p>
            <textarea name="description" class="box" placeholder="Описание" maxlength="1000" cols="30"
                rows="10"></textarea>
            <p>Плейлист<span>*</span></p>
            <select name="playlist" class="box" required>
                <option value="" selected disabled>---выбрать плейлист---</option>
                <?php
                $select_playlist = $conn->prepare('SELECT * FROM `playlist` WHERE tutor_id = ?');
                $select_playlist->execute([$tutor_id]);
                if ($select_playlist->rowCount() > 0) {
                    while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?></option>
                        <?php
                    }

                    ?>
                    <?php
                } else {
                    echo '<p class="empty">Плейлисты еще не добавлены</p>';
                }

                ?>
            </select>

            <p>Превью<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <p>Выбрать материал<span>*</span></p>
            <input type="file" name="video" accept="video/*" required class="box">
            <input type="submit" name="submit" value="Добавить материал" class="btn">

        </form>
    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
    <script src="../js/app.js"></script>
<script src="../js/modules/content.js"></script>
</body>

</html>