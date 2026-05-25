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
    header('location:dashboard.php');
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
    <title>Обновить материал</title>
    <!-- boxicons -->
    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- css -->

</head>

<body>
    <?php include '../components/admin_header.php'; ?>
    <section class="video-form">
        <h1 class="heading">Добавить материалы</h1>
        <?php
        $select_videos = $conn->prepare('SELECT * FROM `content` WHERE id = ? AND tutor_id = ?');
        $select_videos->execute([$get_id, $tutor_id]);
        if ($select_videos->rowCount() > 0) {
            while ($fetch_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) {
                $video_id = $fetch_videos['id'];


                ?>

                <form id="updateContentForm" enctype="multipart/form-data">
                    <input type="hidden" name="video_id" value="<?= $fetch_videos['id']; ?>">
                    <input type="hidden" name="old_thumb" value="<?= $fetch_videos['thumb']; ?>">
                    <input type="hidden" name="old_video" value="<?= $fetch_videos['video']; ?>">

                    <p>Статус материала<span>*</span></p>
                    <select name="status" class="box">
                        <option value="active" <?= ($fetch_videos['status'] == 'active') ? 'selected' : ''; ?>>Активный</option>
                        <option value="deactive" <?= ($fetch_videos['status'] == 'deactive') ? 'selected' : ''; ?>>Неактивный
                        </option>
                    </select>
                    <p>Название материала <span>*</span></p>
                    <input type="text" name="title" maxlength="150" placeholder="Введите название материала"
                        value="<?= $fetch_videos['title']; ?>" class="box">
                    <p>Описание<span>*</span></p>
                    <textarea name="description" class="box" placeholder="Описание" maxlength="1000" cols="30"
                        rows="10"><?= $fetch_videos['description']; ?></textarea>
                    <p>Плейлист<span>*</span></p>
                    <select name="playlist" class="box" required>
                        <option value="<?= $fetch_videos['playlist_id']; ?>" selected><?= $fetch_videos['playlist_id']; ?>
                        </option>
                        <?php
                        $select_playlist = $conn->prepare('SELECT * FROM `playlist` WHERE tutor_id = ?');
                        $select_playlist->execute([$tutor_id]);
                        if ($select_playlist->rowCount() > 0) {
                            while ($fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <option value="<?= $fetch_playlist['id']; ?>"><?= $fetch_playlist['title']; ?>"></option>
                                <?php
                            }

                            ?>
                            <?php
                        } else {
                            echo '<p class="empty">Плейлисты еще не добавлены</p>';
                        }

                        ?>
                    </select>
                    <img src="../uploaded_files/<?= $fetch_videos['thumb']; ?>">
                    <p>Изменить превью<span>*</span></p>
                    <input type="file" name="image" accept="image/*" class="box">
                    <video src="../uploaded_files/<?= $fetch_videos['video']; ?>" controls></video>
                    <p>Изменить материал<span>*</span></p>
                    <input type="file" name="video" accept="video/*" class="box">
                    <div class="flex-btn">
                        <input type="submit" name="update" value="Обновить" class="btn">
                        <a href="view_content.php?get_id=<?= $video_id ?>" class="btn">Посмотреть</a>
                         <button type="button" class="btn deleteContentBtn" data-id="<?= $video_id; ?>">Удалить</button>
                    </div>

                </form>

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

<script src="../js/modules/content-update.js"></script>

<script src="../js/modules/content-delete.js"></script>
</body>

</html>