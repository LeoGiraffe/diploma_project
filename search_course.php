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
    <title>Поиск курсов</title>
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
                <span><i class="bx bx-chevron-right"></i> Поиск курсов</span>
            </div>
            <h1>Поиск курсов</h1>
            <p>Найдите курс, который подходит именно вам. Ищите по названию, категории, уровню сложности или преподавателю. Обучение начинается с правильного выбора.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>
            </div>
        </div>
        <img src="image/banner.png" alt="">
    </div>

    <!-- Course Section -->
    <section class="courses">
        <div class="heading">
            <h1>Результаты поиска</h1>
        </div>
        
        <form action="" method="post" class="search_tutor">
            <input type="text " name="search_course" maxlength="100" required placeholder="Поиск курса по названию" value="<?= isset($_POST['search_course']) ? htmlspecialchars($_POST['search_course']) : '' ?>">
            <button type="submit" name="search_course_btn" class="bx bx-search-alt-2"></button>
        </form>

        <div class="box-container">
            <?php
            if (isset($_POST['search_course_btn']) && !empty($_POST['search_course'])) {
                $search_course = $_POST['search_course'];
                $search_course = htmlspecialchars($search_course, ENT_QUOTES, 'UTF-8');
                
                $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE title LIKE ? AND status = ?");
                $select_courses->execute(["%$search_course%", 'active']);
                
                if ($select_courses->rowCount() > 0) {
                    while ($fetch_courses = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                        $course_id = $fetch_courses['id'];

                        $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                        $select_tutor->execute([$fetch_courses['tutor_id']]);
                        $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
                        
                    
                        $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
                        $count_videos->execute([$course_id]);
                        $total_videos = $count_videos->rowCount();
            ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="uploaded_files/<?= htmlspecialchars($fetch_tutor['image'] ?? 'default.png') ?>" alt="Tutor">
                            <div>
                                <h3><?= htmlspecialchars($fetch_tutor['name'] ?? 'Преподаватель') ?></h3>
                                <span><?= htmlspecialchars($fetch_courses['date']) ?></span>
                            </div>
                        </div>

                        <img src="uploaded_files/<?= htmlspecialchars($fetch_courses['thumb']) ?>" class="thumb" alt="Course thumb">
                        <h3 class="title"><?= htmlspecialchars($fetch_courses['title']) ?></h3>
                        <p class="description"><?= htmlspecialchars(substr($fetch_courses['description'], 0, 100)) ?>...</p>
                        <div class="info">
                            <span><i class="bx bx-video"></i> <?= $total_videos ?> видео</span>
                        </div>
                        <a href="playlist.php?get_id=<?= $course_id ?>" class="btn">Подробнее</a>
                    </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">Курсов по названию "' . htmlspecialchars($search_course) . '" не найдено</p>';
                }
            } else {
                echo '<p class="empty">Введите название курса для поиска</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>