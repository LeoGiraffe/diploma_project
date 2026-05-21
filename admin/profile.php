<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}

$select_profile = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
$select_profile->execute([$tutor_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

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
    <title>tutor profile</title>
    <!-- boxicons -->
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- css -->

</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="tutor-profile" style="min-height: calc(100vh - 19rem)">
        <h1 class="heading">Профиль</h1>
        <div class="details">
            <div class="tutor">
                <img src="../uploaded_files/<?php echo $fetch_profile['image']; ?>">
                <h3><?php echo $fetch_profile['name']; ?></h3>
                <span><?php echo $fetch_profile['profession']; ?></span>
                <a href="update.php" class="btn">Редактировать профиль</a>
            </div>
            <div class="flex">
                <div class="box">
                    <span><?php echo $total_playlists; ?></span>
                    <p>Плейлистов</p>
                    <a href="playlist.php" class="btn">Посмотреть</a>
                </div>
                <div class="box">
                    <span><?php echo $total_contents; ?></span>
                    <p>Материалов</p>
                    <a href="content.php" class="btn">Посмотреть</a>
                </div>
                <div class="box">
                    <span><?php echo $total_likes; ?></span>
                    <p>Лайков</p>
                    <a href="content.php" class="btn">Посмотреть</a>
                </div>
                <div class="box">
                    <span><?php echo $total_comments; ?></span>
                    <p>Комментариев</p>
                    <a href="comments.php" class="btn">Посмотреть</a>
                </div>
            </div>
        </div>
    </section>
    <?php include '../components/footer.php'; ?>
    <script src="../js/admin_script.js"></script>
</body>

</html>