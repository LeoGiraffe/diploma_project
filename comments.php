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
    <title>Комментарии</title>

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
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>Комментарии</span>
            </div>
            <h1>Твои комментарии</h1>
            <p>Здесь собраны все ваши комментарии к урокам и курсам. Редактируйте, удаляйте или просто просматривайте
                свою активность в любое время.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>

            </div>

        </div>
        <img src="image/banner.png" alt="">
    </div>





    <!-----------comments----------->

    <Section class="comments">
        <div class="heading">
            <h1>Твои комментарии</h1>
        </div>


        <div class="show-comments">
            <?php
            $select_comments = $conn->prepare('SELECT * FROM `comments` WHERE user_id = ? ');
            $select_comments->execute([$user_id]);

            if ($select_comments->rowCount() > 0) {
                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $select_content = $conn->prepare('SELECT * FROM `content` WHERE id=? LIMIT 1');
                    $select_content->execute([$fetch_comment['content_id']]);
                    $fetch_content = $select_content->fetch(PDO::FETCH_ASSOC);

                    ?>
            <div class="box comment-box" data-id="<?= $fetch_comment['id'] ?>"
                style="<?= ($fetch_comment['user_id'] == $user_id) ? 'order: -1' : '' ?>">


                        <div class="content">
                            <span><?= $fetch_comment['date']; ?></span>
                            <p><?= $fetch_content['title']; ?></p>

                            <a href="watch_video.php?get_id=<?= $fetch_content['id'] ?>">
                                Смотреть
                            </a>
                        </div>

                       
                        <p class="text comment-text">
                            <?= nl2br(htmlspecialchars($fetch_comment['comment'])) ?>
                        </p>

                        <!-- РЕДАКТОР (скрыт по умолчанию) -->
                        <textarea class="edit-area" style="display:none;"></textarea>

                        <!-- КНОПКИ -->
                        <?php if ($fetch_comment['user_id'] == $user_id) { ?>

                            <div class="actions">

                                <!-- EDIT -->
                                <button type="button" class="btn edit-comment-btn" data-id="<?= $fetch_comment['id'] ?>">
                                    Редактировать
                                </button>

                                <!-- SAVE -->
                                <button type="button" class="btn save-comment-btn" style="display:none;">
                                    Сохранить
                                </button>

                                <!-- CANCEL -->
                                <button type="button" class="btn cancel-comment-btn" style="display:none;">
                                    Отмена
                                </button>

                                <!-- DELETE -->
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

</body>

</html>