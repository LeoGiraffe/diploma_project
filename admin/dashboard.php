<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}


$select_contents = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ?");
$select_contents->execute([$tutor_id]);
$total_contents = $select_contents->rowCount();

$select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ?");
$select_playlists->execute([$tutor_id]);
$total_playlists = $select_playlists->rowCount();

$select_likes = $conn->prepare("SELECT * FROM `likes` WHERE tutor_id = ?");
$select_likes->execute([$tutor_id]);
$total_likes = $select_likes->rowCount();

$select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ?");
$select_comments->execute([$tutor_id]);
$total_comments = $select_comments->rowCount();
?>
<style>
    <?php include '../css/admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- boxicons -->
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- css -->

</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="dashboard">
        <h1 class="heading">Дашбоард</h1>

        <div class="box-container">
            <div class="box">
                <h3>Добро подоловать!</h3>
                <p><?= $fetch_profile['name']; ?></p>
                <a href="profile.php" class="btn">Посмотреть профиль</a>
            </div>
            <div class="box">
                <h3><?= $total_contents; ?></h3>
                <p>Количество материалов</p>
                <a href="add_content.php" class="btn">Добавить новый материал</a>
            </div>
            <div class="box">
                <h3><?= $total_playlists; ?></h3>
                <p>Количество плейлистов</p>
                <a href="add_playlist.php" class="btn">Добавить новый плейлист</a>
            </div>
            <div class="box">
                <h3><?= $total_likes; ?></h3>
                <p>Количество лайков</p>
                <a href="contents.php" class="btn">Посмотреть материалы</a>
            </div>
            <div class="box">
                <h3><?= $total_comments; ?></h3>
                <p>Количество комментариев</p>
                <a href="comments.php" class="btn">Посмотреть комментарии</a>
            </div>
            <div class="box">
                <h3>Начать</h3>
                <div class="flex-btn">
                    <a href="login.php" class="btn" style="width:100px; font-size: 2rem;">Войти</a>
                    <a href="register.php" class="btn" style="width:auto; font-size: 2rem;">Регистрация</a>
                </div>
            </div>
        </div>
    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>