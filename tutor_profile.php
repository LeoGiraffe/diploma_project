<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}



if (isset($_GET['tutor_email'])) {
    $tutor_email = $_GET['tutor_email'];
    $tutor_email = htmlspecialchars($tutor_email, ENT_QUOTES, 'UTF-8');

    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? LIMIT 1");
    $select_tutor->execute([$tutor_email]);
    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
    $tutor_id = $fetch_tutor['id'];



    $count_playlists = $conn->prepare('SELECT * FROM `playlist` WHERE tutor_id = ?');
    $count_playlists->execute([$tutor_id]);
    $total_playlists = $count_playlists->rowCount();


    $count_likes = $conn->prepare('SELECT * FROM `likes` WHERE tutor_id = ?');
    $count_likes->execute([$tutor_id]);
    $total_likes = $count_likes->rowCount();


    $count_comments = $conn->prepare('SELECT * FROM `comments` WHERE tutor_id = ?');
    $count_comments->execute([$tutor_id]);
    $total_comments = $count_comments->rowCount();


    $count_videos = $conn->prepare('SELECT * FROM `content` WHERE tutor_id = ?');
    $count_videos->execute([$tutor_id]);
    $total_videos = $count_videos->rowCount();
} else {
    header('location: teachers.php');
    exit();
}



?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль преподователя</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <!-- Banner -->
    <div class="banner">
        <div class="detail">
            <div class="title">
                <a href="index.php">Главная</a>
                <span><i class="bx bx-chevron-right"></i>Профиль преподователя</span>
            </div>
            <h1>Преподаватели</h1>
            <p>Наши преподаватели — это практикующие эксперты из ведущих компаний. Они делятся реальным опытом, кейсами
                и знаниями, которые действительно нужны в работе.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>
            </div>
        </div>
        <img src="image/banner.png" alt="">
    </div>

    <!-- tutor prifile -->
    <section class="tutor-profile">
        <div class="heading">
            <h1>Подробнее о преподавателе</h1>
        </div>
        <div class="details">
            <div class="tutor">
                <img src="uploaded_files/<?= htmlspecialchars($fetch_tutor['image']) ?>" alt="Tutor">
                <div>
                    <h3><?= htmlspecialchars($fetch_tutor['name']) ?></h3>
                    <span><?= htmlspecialchars($fetch_tutor['profession'] ?? 'Преподаватель') ?></span>
                </div>
                <div class="flex">
                 <p>Плейлисты: <span>(<?= $total_playlists ?>)</span></p>
                <p>Материалов: <span>(<?= $total_videos ?>)</span></p>
                <p>Лайки: <span>(<?= $total_likes ?>)</span></p>
                <p>Комментарии: <span>(<?= $total_comments ?>)</span></p>
                </div>
            </div>
        </div>


    </section>

 <!-- course -->

 <div class="courses">
        <div class="heading">
            <span>Топ популярных курсов</span>
            <h1>Присоединяйтесь к нам</h1>
        </div>
        <div class="box-container">
            <?php
            $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE tutor_id = ? AND status = ? ORDER BY date DESC ");
            $select_courses->execute([$tutor_id, 'active']);
            if ($select_courses->rowCount() > 0) {
                while ($fetch_courses = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                    $course_id = $fetch_courses['id'];


                    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                    $select_tutor->execute([$fetch_courses['tutor_id']]);
                    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>">
                            <div>
                                <h3><?= $fetch_tutor['name']; ?></h3>
                                <span><?= $fetch_courses['date']; ?></span>
                            </div>
                        </div>

                        <img src="uploaded_files/<?= $fetch_courses['thumb']; ?>" class="thumb">
                        <h3 class="title"><?= $fetch_courses['title']; ?></h3>
                        <a href="playlist.php?get_id=<?= $course_id; ?>">Подробнее</a>
                    </div>

                    <?php
                }
            } else {
                echo '<p class="empty">Курсов пока нет!</p>';
            }
            ?>
        </div>
       
    </div>










    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>

</html>