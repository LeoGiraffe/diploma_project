<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}

//delete from playlist
if (isset($_POST['delete'])) {
    $delete_id = $_POST['video_id'];
    $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');


    $verify_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
    $verify_video->execute([$delete_id]);

    if ($verify_video->rowCount() > 0) {
        $delete_video_thumb = $conn->prepare('SELECT * FROM `content` WHERE id = ? LIMIT 1');
        $delete_video_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_thumb['thumb']);

        $delete_video = $conn->prepare('SELECT * FROM `content` WHERE id = ? LIMIT 1');
        $delete_video->execute([$delete_id]);
        $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_video['video']);

        $delete_likes = $conn->prepare('SELECT * FROM `likes` WHERE content = ?');
        $delete_likes->execute([$delete_id]);

        $delete_comments = $conn->prepare('SELECT * FROM `comments` WHERE content_id = ?');
        $delete_comments->execute([$delete_id]);

        $delete_content = $conn->prepare('DELETE FROM `content` WHERE id = ?');
        $delete_content->execute([$delete_id]);

        $message[] = 'Видео успешно удалено';
    } else {
        $message[] = 'Видео не найдено';
    }
}



?>
<style>
    <?php include '../css/admin_style.css'; ?>
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить плейлист</title>
    <!-- boxicons -->
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- css -->

</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="contents">
        <h1 class="heading">Материалы</h1>
        <div class="box-container">
            <div class="add">
                <a href="add_content.php"><i class="bx bx-plus"></i></a>
            </div>

            <?php
            $select_videos = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ? ORDER BY date DESC");
            $select_videos->execute([$tutor_id]);

            if ($select_videos->rowCount() > 0) {
                while ($fetch_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) {
                    $video_id = $fetch_videos['id'];


                    ?>


                    <div class="box">
                        <div class="flex">
                            <div>
                                <i class="bx bx-dots-vertical-rounded" style="<?php if ($fetch_videos['status'] == 'active') {
                                    echo 'color:limegreen;';
                                } else {
                                    echo 'color:red';
                                } ?>"></i>
                                <span style="<?php if ($fetch_videos['status'] == 'active') {
                                    echo 'color:limegreen;';
                                } else {
                                    echo 'color:red';
                                } ?>"><?= $fetch_videos['status']; ?></span>
                                <div><i class="bx bxs-calendar-alt"></i><span><?= $fetch_videos['date']; ?></span></div>
                            </div>
                            <img src="../uploaded_files/<?= $fetch_videos['thumb'] ?>" class="thumb">
                            <h3 class="title"> <?= $fetch_videos['title'] ?></h3>
                            <form action="" method="post" class="flex-btn">
                                <input type="hidden" name="video_id" value="<?= $video_id ?>">
                                <a href="update_content.php?get_id=<?= $video_id; ?>" class="btn">Обновить</a>
                                <input type="submit" name="delete" value="Удалить" class="btn"
                                    onclick="return confirm('Удалить этот материал?')">
                                <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">Посмотреть</a>

                            </form>
                        </div>
                    </div>


                    <?php
                }
            } else {
                echo '<p class="empty">Пока что ничего нет</p>';
            }
            ?>

    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>