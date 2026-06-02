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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Просмотр</span>
            </div>
            <h1>Просмотр</h1>
            <p>Собирайте любимые уроки в плейлисты и учитесь в удобном порядке. Создавайте подборки по темам,
                возвращайтесь к сложным моментам и отслеживайте свой прогресс.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>

            </div>

        </div>
        <img src="image/banner.png" alt="">
    </div>

    <!-----------edit section----------->
   







    <!-----------video----------->





    <section class="watch-video">

        <?php
        $select_content = $conn->prepare('SELECT * FROM `content` WHERE id = ? AND status = ?');
        $select_content->execute([$get_id, 'active']);
        if ($select_content->rowCount() > 0) {
            while ($fetch_content = $select_content->fetch(PDO::FETCH_ASSOC)) {
                $content_id = $fetch_content['id'];

                $count_likes = $conn->prepare('SELECT * FROM `likes` WHERE content = ?');
                $count_likes->execute([$content_id]);
                $total_likes = $count_likes->rowCount();

                $verify_likes = $conn->prepare('SELECT * FROM `likes` WHERE content = ? AND user_id = ?');
                $verify_likes->execute([$content_id, $user_id]);


                $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
                $select_tutor->execute([$fetch_content['tutor_id']]);
                $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);



                ?>

        <div class="video_detail">
            <video src="uploaded_files/<?= $fetch_content['video']; ?>" class="video"
                poster="uploaded_files/<?= $fetch_content['thumb']; ?>" controls autoplay></video>
            <h3 class="title">
                <?= $fetch_content['title']; ?>
            </h3>
            <div class="info">
                <p><i class="bx bxs-calendar-alt">
                        <?= $fetch_content['date']; ?>
                    </i></p>
                <p><i class="bx bxs-heart">
                        <span>
                            <?= $total_likes; ?>
                        </span>
                    </i></p>
            </div>
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
            <div class="flex">

                <a href="playlist.php?get_id=<?= $fetch_content['playlist_id']; ?>" class="btn">
                    Посмотреть плейлист
                </a>

                <button type="button" class="like-btn" data-content-id="<?= $content_id ?>">
                    <?php if ($verify_likes->rowCount() > 0) { ?>
                    <i class="bx bxs-heart"></i><span>Лайк</span>
                    <?php } else { ?>
                    <i class="bx bx-heart"></i><span>Лайк</span>
                    <?php } ?>
                </button>

            </div>


            <div class="description">
                <p>
                    <?= $fetch_content['description']; ?>
                </p>
            </div>
        </div>

        <?php
            }
        } else {
            echo '<p class="empty">Контент не найден!</p>';
        }
        ?>


    </section>

    <!-----------сomment section----------->

    <Section class="comments">
        <div class="heading">
            <h1>Добавить комментарий</h1>
        </div>


        <form class="add-comment" data-id="<?= $get_id ?>">

            <input type="hidden" name="content_id" value="<?= $get_id ?>">

            <textarea name="comment" placeholder="Добавить комментарий" maxlength="1000" cols="30" rows="10"
                required></textarea>

            <button type="submit" class="btn">
                Добавить комментарий
            </button>

        </form>
        <div class="heading">
            <h1>Комментарии пользователей</h1>
        </div>

        <div class="show-comments">

            <?php
            $select_comments = $conn->prepare('SELECT * FROM `comments` WHERE content_id = ? ORDER BY id DESC');
            $select_comments->execute([$get_id]);

            if ($select_comments->rowCount() > 0) {

                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {

                    $select_commentor = $conn->prepare('SELECT * FROM `users` WHERE id = ? LIMIT 1');
                    $select_commentor->execute([$fetch_comment['user_id']]);
                    $fetch_commentor = $select_commentor->fetch(PDO::FETCH_ASSOC);
                    ?>

            <div class="comment-box" data-id="<?= $fetch_comment['id'] ?>">

                <div class="user">
                    <img src="uploaded_files/<?= htmlspecialchars($fetch_commentor['image']) ?>" alt="">
                    <div>
                        <h3>
                            <?= htmlspecialchars($fetch_commentor['name']) ?>
                        </h3>
                        <span>
                            <?= htmlspecialchars($fetch_comment['date']) ?>
                        </span>
                    </div>
                </div>

                <!-- ТЕКСТ -->
                        <p class="comment-text">
                            <?= nl2br(htmlspecialchars($fetch_comment['comment'])) ?>
                        </p>

                        <!-- РЕДАКТОР -->
                        <textarea class="edit-area" style="display:none;"></textarea>

                        <?php if ($fetch_comment['user_id'] == $user_id) { ?>
                            <div class="flex-btn">

                                <button type="button" class="btn edit-comment-btn" data-id="<?= $fetch_comment['id'] ?>">
                                    Редактировать
                                </button>

                                <button type="button" class="btn save-comment-btn" data-id="<?= $fetch_comment['id'] ?>"
                                    style="display:none;">
                                    Сохранить
                                </button>

                                <button type="button" class="btn cancel-comment-btn" style="display:none;">
                                    Отмена
                                </button>

                                <button type="button" class="btn delete-comment-btn" data-id="<?= $fetch_comment['id'] ?>">
                                    Удалить
                                </button>

                            </div>
                        <?php } ?>
                    </div>

                    <?php
                }
            } else {
                echo '<p class="empty">Комментариев пока нет!</p>';
            }
            ?>

        </div>

    </Section>


    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
    <script src="js/app.js"></script>
    <script src="js/modules/user/comment-update.js"></script>
    <script src="js/modules/user/comment-delete.js"></script>
    <script src="js/modules/user/comment-add.js"></script>
    <script src="js/modules/user/like.js"></script>

</body>

</html>