<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}
if (isset($_GET['get_id'])) {
    $get_id = $_GET['get_id'];
} else {
    $get_id = '';
    header('location:playlist.php');
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
    <section class="view-playlist">
        <h1 class="heading">Плейлист</h1>


        <?php
        $select_playlist = $conn->prepare('SELECT * FROM `playlist` WHERE id = ? AND tutor_id = ?');
        $select_playlist->execute([$get_id, $tutor_id]);
        if ($select_playlist->rowCount() > 0) {
            while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                $playlist_id = $fetch_playlist['id'];
                $count_videos = $conn->prepare('SELECT *  FROM `content` WHERE playlist_id=?');
                $count_videos->execute([$playlist_id]);
                $total_videos = $count_videos->rowCount();

                ?>
                <div class="row">
                    <div class="thumb">
                        <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>" alt="">
                    </div>

                    <div class="details">
                        <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
                        <div class="date"><i class="bx bxs-calendar-alt"></i><span><?= $fetch_playlist['date']; ?></span></div>
                        <div class="description">
                            <?= $fetch_playlist['description']; ?>
                        </div>
                        <div class="flex-btn">

                            <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">
                                Обновить
                            </a>

                            <button type="button" class="btn deletePlaylistBtn" data-id="<?= $playlist_id; ?>">
                                Удалить
                            </button>

                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo '<p class="empty">Плейлист еще не создан</p>';
        }

        ?>

    </section>
    <section class="contents">
        <h1 class="heading">Материалы плейлиста</h1>
        <div class="box-container">

            <?php
            $select_videos = $conn->prepare("SELECT * FROM `content` WHERE tutor_id = ? AND playlist_id = ? ORDER BY date DESC");
            $select_videos->execute([$tutor_id, $playlist_id]);

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
                            <form class="delete-video-form">

                                <input type="hidden" name="video_id" value="<?= $video_id; ?>">

                                <a href="update_content.php?get_id=<?= $video_id; ?>" class="btn">
                                    Обновить
                                </a>

                                <button type="button" class="btn deleteContentBtn" data-id="<?= $video_id; ?>">Удалить</button>


                                <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">
                                    Посмотреть
                                </a>

                            </form>
                        </div>
                    </div>


                    <?php
                }
            } else {
                echo '
                    <div class="empty">
                    <p style="margin-bottom: 1.5rem;">Пока что ничего нет</p>
                    <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">Добавить материал</a>
                    </div>
                ';
            }
            ?>


    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
    <script src="../js/app.js"></script>
    <script src="../js/modules/playlist-delete.js"></script>
    <script src="../js/modules/content-delete.js"></script>
</body>

</html>