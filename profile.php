<?php

include 'components/connect.php';



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';

    header('location:login.php');
}

$select_likes = $conn->prepare('SELECT * FROM `likes` WHERE user_id=?');
$select_likes->execute([$user_id]);
$likes = $select_likes->rowCount();

$select_comments = $conn->prepare('SELECT * FROM `comments` WHERE user_id=?');
$select_comments->execute([$user_id]);
$comments = $select_comments->rowCount();

$select_bookmarks = $conn->prepare('SELECT * FROM `bookmark` WHERE user_id=?');
$select_bookmarks->execute([$user_id]);
$bookmarks = $select_bookmarks->rowCount();









?>




<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>

    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <!-----------banner----------->



  
    <section class="profile">
<div class="head">
    <h1>Мой профиль</h1>
</div>
<div class="details">
    <div class="user">
        <img src="uploaded_files/<?= $fetch_profile['image']; ?>" >
        <h3><?= $fetch_profile['name']; ?></h3>
        <p>Ученик</p>
        <a href="update.php" class="btn">Редактировать профиль</a>
    </div>
    <div class="box-container">
        <div class="box">
            <div class="flex">
                <i class="bx bxs-bookmarks"></i>
                <h3><?= $bookmarks; ?></h3>
                <span>Добавлено в избранное</span>
            </div>
            <a href="bookmark.php" class="btn">Перейти</a>
        </div>
        <div class="box">
            <div class="flex">
                <i class="bx bxs-heart"></i>
                <h3><?= $likes; ?></h3>
                <span>Добавлено в понравившиеся</span>
            </div>
            <a href="likes.php" class="btn">Перейти</a>
        </div>
        <div class="box">
            <div class="flex">
                <i class="bx bxs-chat"></i>
                <h3><?= $comments; ?></h3>
                <span>Комментариев</span>
            </div>
            <a href="comments.php" class="btn">Перейти</a>
        </div>
    </div>
</div>


    </section>




    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>

</html>