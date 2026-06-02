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
    <title>Курсы</title>

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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Курсы</span>
            </div>
            <h1>Наши курсы</h1>
            <p>Выбирайте курс, который подходит именно вам. Программирование, дизайн, маркетинг, управление — более 50
                направлений для старта или развития карьеры. Учитесь у практиков, выполняйте реальные задачи и получайте
                сертификат после обучения.</p>
        </div>
        <img src="image/banner.png" alt="">


    </div>


<!-------------------------courses---------------->


    <div class="courses">
        <div class="heading">
            <span>Топ популярных курсов</span>
            <h1>Присоединяйтесь к нам</h1>
        </div>
        <div class="box-container">
            <?php
            $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC ");
            $select_courses->execute(['active']);
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