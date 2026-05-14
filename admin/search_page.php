<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}





if (isset($_POST['delete_playlist'])) {
    $delete_id = $_POST['playlist_id'];
    $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');

    $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
    $delete_playlist_thumb->execute([$delete_id]);
    $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
    unlink('../uploaded_files/' . $fetch_thumb['thumb']);


    $delete_bookmark = $conn->prepare('DELETE FROM `bookmark` WHERE playlist_id = ?');
    $delete_bookmark->execute([$delete_id]);
    $delete_playlist = $conn->prepare('DELETE FROM `playlist` WHERE id = ?');
    $delete_playlist->execute([$delete_id]);

    $message[] = 'Плейлист успешно удален';
}
//delete from playlist
if (isset($_POST['delete_video'])) {
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

        $delete_likes = $conn->prepare('DELETE FROM `likes` WHERE content = ?');
        $delete_likes->execute([$delete_id]);

        $delete_comments = $conn->prepare('DELETE FROM `comments` WHERE content_id = ?');
        $delete_comments->execute([$delete_id]);

        $delete_content = $conn->prepare('DELETE FROM `content` WHERE id = ?');
        $delete_content->execute([$delete_id]);

        $message[] = 'Видео успешно удалено';
    } else {
        $message[] = 'Видео не найдено';
    }
}
if (isset($_POST['delete_comment'])) {
    $delete_id = $_POST['delete_id'];
    $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');

    $verify_comment = $conn->prepare("SELECT * FROM `comments` WHERE id = ? ");
    $verify_comment->execute([$delete_id]);

    if ($verify_comment->rowCount() > 0) {
        $delete_comment = $conn->prepare('DELETE FROM `comments` WHERE id = ?');
        $delete_comment->execute([$delete_id]);
        $message[] = 'Комментарий успешно удален';
    } else {
        $message[] = 'Комментарий уже удален';
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
            <?php
            if (isset($_POST['search']) or isset($_POST['search_btn'])) {
                $search = $_POST['search'];
                $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
                $select_contents = $conn->prepare("SELECT * FROM `content` WHERE title LIKE '%{$search}%' AND tutor_id = ? ORDER BY date DESC");
                $select_contents->execute([$tutor_id]);
                if ($select_contents->rowCount() > 0) {
                    while ($fetch_contents = $select_contents->fetch(PDO::FETCH_ASSOC)) {
                        $video_id = $fetch_contents['id'];



                        ?>
                        <div class="box">
                            <div class="flex">
                                <div><i class="bx bx-dots-vertical-rounded" style="<?php if ($fetch_contents['status'] == 'active') {
                                    echo 'color:limegreen';
                                } else {
                                    echo 'color: red';
                                } ?>"></i>
                                    <span style="<?php if ($fetch_contents['status'] == 'active') {
                                        echo 'color:limegreen';
                                    } else {
                                        echo 'color: red';
                                    } ?>"><?= $fetch_contents['status']; ?></span>
                                </div>
                                <div><i class="bx bxs-calendar-alt"></i> <span><?= $fetch_contents['date']; ?></span></div>
                            </div>
                            <img src="../uploaded_files/<?= $fetch_contents['thumb']; ?>" class="thumb">
                            <h3 class="title"><?= $fetch_contents['title']; ?></h3>
                            <form action="" method="post">
                                <input type="hidden" name="video_id" value="<?= $video_id ?>">
                                <a href="update_content.php?get_id=<?= $video_id; ?>" class="btn">Обновить</a>
                                <input type="submit" name="delete_video" class="btn" value="Удалить"
                                    onclick="return confirm('Удалить?')">
                                <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">Посмотреть</a>
                            </form>

                        </div>
                        <?php
                    }
                } else {
                    echo '<p class="empty">Ничего не найдено</p>';
                }
            } else {
                echo '<p class="empty">Поищите что-нибдуь</p>';
            }
            ?>
        </div>
    </section>
    <section class="playlist">
        <h1 class="heading">Плейлисты</h1>
        <div class="box-container">
            <?php
            if (isset($_POST['search']) or isset($_POST['search_btn'])) {
                $search = $_POST['search'];
                $search = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
                $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE title LIKE '%{$search}%' AND tutor_id = ? ORDER BY date DESC");
                $select_playlist->execute([$tutor_id]);
                if ($select_playlist->rowCount() > 0) {
                    while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                        $playlist_id = $fetch_playlist['id'];
                        $count_videos = $conn->prepare('SELECT * FROM `content` WHERE playlist_id = ?');
                        $count_videos->execute([$playlist_id]);
                        $total_videos = $count_videos->rowCount();

                        ?>
                        <div class="box">
                            <div class="flex">
                                <div><i class="bx bx-dots-vertical-rounded" style="<?php if ($fetch_playlist['status'] == 'active') {
                                    echo 'color:limegreen';
                                } else {
                                    echo 'color: red';
                                } ?>"></i>
                                    <span style="<?php if ($fetch_playlist['status'] == 'active') {
                                        echo 'color:limegreen';
                                    } else {
                                        echo 'color: red';
                                    } ?>"><?= $fetch_playlist['status']; ?></span>
                                </div>
                                <div><i class="bx bxs-calendar-alt"></i> <span><?= $fetch_playlist['date']; ?></span></div>
                            </div>
                            <div class="thumb">
                                <span><?= $total_videos; ?></span>
                                <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="thumb">

                            </div>
                            <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
                            <p class="description"><?= $fetch_playlist['description']; ?></p>
                            <form action="" method="post">
                                <input type="hidden" name="playlist_id" value="<?= $playlist_id ?>">
                                <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Обновить</a>
                                <input type="submit" name="delete_playlist" class="btn" value="Удалить"
                                    onclick="return confirm('Удалить?')">
                                <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Посмотреть</a>
                            </form>

                        </div>


                        <?php
                    }
                } else {
                    echo '<p class="empty">Ничего не найдено</p>';
                }
            } else {
                echo '<p class="empty">Поищите что-нибдуь</p>';
            }
            ?>
        </div>

    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>