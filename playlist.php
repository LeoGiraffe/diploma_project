<?php

include 'components/connect.php';



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';

}


if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:index.php');
}

if (isset($_POST['save_list'])) {
    if($user_id != ''){
        $list_id = $_POST['list_id'];
        $list_id = htmlspecialchars($list_id, ENT_QUOTES, 'UTF-8');
        $select_list = $conn->prepare("SELECT * FROM `bookmark` WHERE playlist_id = ? AND user_id = ?");

        $select_list->execute([$list_id, $user_id]);

        if ($select_list->rowCount() > 0) {
            $remove_bookmark = $conn->prepare("DELETE FROM `bookmark` WHERE playlist_id = ? AND user_id = ?");
            $remove_bookmark->execute([$list_id, $user_id]);
            $message[] = 'Плейлист удален из закладок';


        } else {
            $insert_bookmark = $conn->prepare("INSERT INTO `bookmark`(user_id, playlist_id) VALUES(?, ?)");
            $insert_bookmark->execute([$user_id, $list_id]);
            $message[] = 'Плейлист добавлен в закладки';
        }
    } else {
        $message[] = 'Вы не вошли в аккаунт';
    }
    
}







?>




<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Плейлист</title>

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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Плейлист</span>
            </div>
            <h1>мой плейлист</h1>
            <p>Собирайте любимые уроки в плейлисты и учитесь в удобном порядке. Создавайте подборки по темам,
                возвращайтесь к сложным моментам и отслеживайте свой прогресс.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>

            </div>

        </div>
        <img src="image/banner.png" alt="">
    </div>
    <!-----------playlist----------->





    <section class="playlist">
        <div class="heading">
            <h1>Плейлист</h1>
        </div>
        <div class="row">
            <?php
            $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? and status = ? LIMIT 1");
            $select_playlist->execute([$get_id, 'active']);

            if ($select_playlist->rowCount() > 0) {
                $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

                $playlist_id = $fetch_playlist['id'];

                $count_videos = $conn->prepare('SELECT * FROM `content` WHERE playlist_id = ?');
                $count_videos->execute([$playlist_id]);
                $total_videos = $count_videos->rowCount();

                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                $select_tutor->execute([$fetch_playlist['tutor_id']]);
                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
                $select_bookmark->execute([$user_id, $playlist_id]);
                ?>
            <div class="col">
                <form action="" method="post" class="save-list">
                    <input type="hidden" name="list_id" value="<?= $playlist_id ?>">
                    <?php if ($select_bookmark->rowCount() > 0) { ?>
                    <button type="submit" name="save_list" class="save"><i class="bx bx-bookmark"></i>
                        <span>Сохранено</span></button>
                    <?php } else { ?>
                    <button type="submit" name="save_list" class="save"><i class="bx bx-bookmark"></i>
                        <span>Сохранить</span></button>
                    <?php } ?>
                </form>
                <div class="thumb">
                    <span>
                        <?= $total_videos ?>
                    </span>
                    <img src="uploaded_files/<?= $fetch_playlist['thumb'] ?>">
                </div>
            </div>
            <div class="col">
                <div class="tutor">
                    <img src="uploaded_files/<?= $fetch_tutor['image']; ?>">
                    <div>
                        <h3>
                            <?= $fetch_tutor['name']; ?>
                        </h3>
                        <span>
                            <?= $fetch_tutor['profession']; ?>
                        </span>
                    </div>
                </div>
<div class="detail">
    <h3><?= $fetch_playlist['title']; ?></h3>
    <p><?= $fetch_playlist['description']; ?></p>
    <div class="date"><i class="bx bxs-calendar-alt"></i><span><?= $fetch_playlist['date']; ?></span></div>
</div>

            </div>
            <?php
            } else {
                echo '<p class="empty">Плейлист не найден!</p>';
            }
            
            ?>
        </div>
    </section>

<section class="video-container">
    <div class="heading">
        <h1>Видео</h1>
    </div>
    <div class="box-container">
        <?php
$select_content = $conn->prepare('SELECT * FROM `content` WHERE playlist_id = ? AND status = ? ORDER BY date DESC');
$select_content->execute([$get_id, 'active']);
if ($select_content->rowCount() > 0) {
    while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
       




?>
<a href="watch_video.php?get_id=<?= $fetch_content['id']?>" class="box">
<i class="bx bx-play"></i>
    <img src="uploaded_files/<?= $fetch_content['thumb']; ?>" alt="">
    <h3><?= $fetch_content['title']; ?></h3>
</a>

<?php
    }
}else{
    echo '<p class="empty">Видео не найдено!</p>';
}

?>
    </div>
</section>




    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>

</html>