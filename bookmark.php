<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location: login.php'); // Исправлено: home.php -> login.php
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Избранное</title>
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
                <span><i class="bx bx-chevron-right"></i>Избранное</span>
            </div>
            <h1>Избранное</h1>
            <p>Войдите в свой аккаунт, чтобы продолжить обучение. Здесь вас ждут ваши курсы, прогресс и личные сообщения.</p>
            <div class="flex-btn">
                <a href="contact.php" class="btn">Свяжитесь с нами</a>
            </div>
        </div>
        <img src="image/banner.png" alt="">
    </div>

    <section class="courses">
        <div class="heading">
            <h1>Избранные плейлисты</h1>
        </div>
        <div class="box-container">
            <?php
            $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ?");
            $select_bookmark->execute([$user_id]);

            if ($select_bookmark->rowCount() > 0) {
                while ($fetch_bookmark = $select_bookmark->fetch(PDO::FETCH_ASSOC)) {
                    $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND status = ?");
                    $select_courses->execute([$fetch_bookmark['playlist_id'], 'active']);
                    
                    if ($select_courses->rowCount() > 0) {
                        $fetch_courses = $select_courses->fetch(PDO::FETCH_ASSOC); // Этого не хватало!
                        $course_id = $fetch_courses['id'];

                        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                        $select_tutor->execute([$fetch_courses['tutor_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
            ?>
                        <div class="box">
                            <div class="tutor">
                                <img src="uploaded_files/<?= htmlspecialchars($fetch_tutor['image']) ?>" alt="Tutor">
                                <div>
                                    <h3><?= htmlspecialchars($fetch_tutor['name']) ?></h3>
                                    <span><?= htmlspecialchars($fetch_tutor['profession'] ?? 'Преподаватель') ?></span>
                                </div>
                            </div>
                            <img src="uploaded_files/<?= htmlspecialchars($fetch_courses['thumb']) ?>" class="thumb" alt="Course thumb">
                            <h3 class="title"><?= htmlspecialchars($fetch_courses['title']) ?></h3>
                            <a href="playlist.php?get_id=<?= $course_id ?>" class="btn">Перейти к плейлисту</a>
                        </div>
            <?php
                    }
                }
            } else {
                echo '<p class="empty">Нет избранных плейлистов!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>