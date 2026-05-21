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
    <title>Преподаватели</title>
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
                <span><i class="bx bx-chevron-right"></i>Преподаватели</span>
            </div>
            <h1>Преподаватели</h1>
            <p>Наши преподаватели — это практикующие эксперты из ведущих компаний. Они делятся реальным опытом, кейсами и знаниями, которые действительно нужны в работе.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>
            </div>
        </div>
        <img src="image/banner.png" alt="">
    </div>

    <!-- Teachers Section -->
    <section class="teachers">
        <div class="heading">
            <h1>Эксперты</h1>
        </div>
        
        <form action="search_tutor.php" method="post" class="search_tutor">
            <input type="text" name="search_tutor" maxlength="100" required placeholder="Поиск преподавателя">
            <button type="submit" name="search_tutor_btn" class="bx bx-search-alt-2"></button>
        </form>
        
        <div class="box-container">
            <div class="box">
                <h3>Стать преподавателем</h3>
                <p style="margin-bottom: 1.5rem;">Делитесь знаниями и опытом с тысячами учеников. Преподавайте на платформе Дистанциум, создавайте свои курсы и помогайте другим расти профессионально.</p>
                <a href="admin/register.php" class="btn" >Начни сейчас!</a>
            </div>

            <?php
            $select_tutors = $conn->prepare("SELECT * FROM `tutors`");
            $select_tutors->execute();
            
            if ($select_tutors->rowCount() > 0) {
                while ($fetch_tutors = $select_tutors->fetch(PDO::FETCH_ASSOC)) {
                    $tutor_id = $fetch_tutors['id'];
                    
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
            ?>
            <div class="box">
                <div class="tutor">
                    <img src="uploaded_files/<?= htmlspecialchars($fetch_tutors['image']) ?>" alt="Tutor">
                    <div>
                        <h3><?= htmlspecialchars($fetch_tutors['name']) ?></h3>
                        <span><?= htmlspecialchars($fetch_tutors['profession'] ?? 'Преподаватель') ?></span>
                    </div>
                </div>
                
                <p>Плейлисты: <span>(<?= $total_playlists ?>)</span></p>
                <p>Материалов: <span>(<?= $total_videos ?>)</span></p>
                <p>Лайки: <span>(<?= $total_likes ?>)</span></p>
                <p>Комментарии: <span>(<?= $total_comments ?>)</span></p>
                
                <form action="tutor_profile.php" method="get">
                    <input type="hidden" name="tutor_email" value="<?= htmlspecialchars($fetch_tutors['email']) ?>">
                    <input type="submit" name="tutor_fetch" class="btn" value="Смотреть профиль">
                </form>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">Нет преподавателей</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>
</html>