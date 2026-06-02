<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
    header('location: login.php');
    exit();
}

if (isset($_POST['remove'])) {
    if ($user_id != '') {
        $content_id = $_POST['content_id'];
        $content_id = htmlspecialchars($content_id, ENT_QUOTES, 'UTF-8');


        $verify_likes = $conn->prepare('SELECT * FROM `likes` WHERE content = ? AND user_id = ?');
        $verify_likes->execute([$content_id, $user_id]);

        if ($verify_likes->rowCount() > 0) {
            $delete_likes = $conn->prepare('DELETE FROM `likes` WHERE content = ? AND user_id = ?');
            $delete_likes->execute([$content_id, $user_id]);
            $message[] = 'Удалено из понравившихся';
        }
    } else {
        $message[] = 'Сначала войдите в аккаунт';
    }
}









?>






<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Понравившиеся</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>


    <section class="liked-videos">
        <div class="heading">
            <h1>Понравившиеся материалы</h1>
        </div>
        <div class="box-container">
            <?php
            $select_likes = $conn->prepare("SELECT * FROM `likes` WHERE user_id = ?");
            $select_likes->execute([$user_id]);

            if ($select_likes->rowCount() > 0) {
                while ($fetch_likes = $select_likes->fetch(PDO::FETCH_ASSOC)) {

                    $select_content = $conn->prepare("SELECT * FROM `content` WHERE id = ? ORDER BY date DESC");
                    $select_content->execute([$fetch_likes['content']]);

                    if ($select_content->rowCount() > 0) {
                        while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                            $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                            $select_tutor->execute([$fetch_content['tutor_id']]);
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
                                <img src="uploaded_files/<?= htmlspecialchars($fetch_content['thumb']) ?>" class="thumb"
                                    alt="Video thumb">
                                <h3 class="title"><?= htmlspecialchars($fetch_content['title']) ?></h3>
                                <form action="" method="post" class="flex">
                                    <input type="hidden" name="content_id" value="<?= $fetch_content['id'] ?>">

                                    <a href="watch_video.php?get_id=<?= $fetch_content['id'] ?>" class="btn">Смотреть видео</a>
                                    <input type="submit" name="remove" value="Удалить из понравившихся" class="btn">
                                </form>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p class="empty">Понравившиеся материалы не найдены!</p>';
                    }
                }
            } else {
                echo '<p class="empty">Пока ничего не добавлено!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>

</html>