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
    <title>Обновить плейлист</title>
    <!-- boxicons -->
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- css -->

</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="playlist-form">
        <h1 class="heading">Обновить плейлист</h1>
        <?php
        $select_playlist = $conn->prepare('SELECT * FROM `playlist` WHERE id = ?');
        $select_playlist->execute([$get_id]);

        if ($select_playlist->rowCount() > 0) {
            while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                $playlist_id = $fetch_playlist['id'];
                $count_videos = $conn->prepare('SELECT * FROM `content` WHERE playlist_id = ?');
                $count_videos->execute([$playlist_id]);
                $total_videos = $count_videos->rowCount();


                ?>
                <form id="updatePlaylistForm" enctype="multipart/form-data">
                    <input type="hidden" name="old_image" value="<?= $fetch_playlist['thumb'] ?>">
                    <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                    <p>Статус плейлиста <span>*</span></p>
                    <select name="status" class="box">
                        <option value="active" <?= ($fetch_playlist['status'] == 'active') ? 'selected' : ''; ?>>Активный</option>
                        <option value="deactive" <?= ($fetch_playlist['status'] == 'deactive') ? 'selected' : ''; ?>>Неактивный
                        </option>
                    </select>
                    <p>Название плейлиста <span>*</span></p>
                    <input type="text" name="title" maxlength="150" placeholder="Введите название плейлиста" class="box"
                        value="<?= $fetch_playlist['title'] ?>">
                    <p>Описание<span>*</span></p>
                    <textarea name="description" class="box" placeholder="Описание" maxlength="1000" cols="30" rows="10"
                        value="<?= $fetch_playlist['description']; ?>"><?= $fetch_playlist['description']; ?></textarea>
                    <p>Превью<span>*</span></p>
                    <div class="thumb">
                        <span><?= $total_videos; ?></span>
                        <img src="../uploaded_files/<?= $fetch_playlist['thumb'] ?>">
                    </div>
                    <input type="file" name="image" accept="image/*" class="box">
                    <div class="flex-btn">
                        <button type="submit" class="btn">
                            Обновить
                        </button>
                        <button type="button" class="btn" id="deletePlaylistBtn">
                            Удалить
                        </button>
                        <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Открыть</a>

                    </div>

                </form>
                <?php
            }
        } else {
            echo '<p class="empty">плейлист не найден!</p>';
        }
        ?>
    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
    <script src="../js/app.js"></script>
    <script src="../js/modules/playlist-update.js"></script>
    <script src="../js/modules/playlist-delete.js"></script>

</body>

</html>