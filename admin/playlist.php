<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}

if (isset($_POST['delete'])) {
    $delete_id = $_POST['playlist_id'];
    $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');

    $verify_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? AND tutor_id = ? LIMIT 1");
    $verify_playlist->execute([$delete_id, $tutor_id]);

    if ($verify_playlist->rowCount() > 0) {
        $delete_playlist_thumb = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? LIMIT 1");
        $delete_playlist_thumb->execute([$delete_id]);
        $fetch_thumb = $delete_playlist_thumb->fetch(PDO::FETCH_ASSOC);
        unlink('../uploaded_files/' . $fetch_thumb['thumb']);

        $delete_bookmark = $conn->prepare('DELETE FROM `bookmark` WHERE playlist_id = ?');
        $delete_bookmark->execute([$delete_id]);
        $delete_playlist = $conn->prepare('DELETE FROM `playlist` WHERE id = ?');
        $delete_playlist->execute([$delete_id]);

        $message[] = 'Плейлист успешно удален';
    } else {
        $message[] = 'Плейлист уже удален';
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
    <section class="playlist">
        <h1 class="heading">Плейлисты</h1>
        <div class="box-container">


            <div class="add">
                <a href="add_playlist.php"><i class="bx bx-plus"></i></a>
            </div>

            <?php
            $select_playlists = $conn->prepare('SELECT * FROM `playlist` WHERE tutor_id = ? ORDER BY date DESC');
            $select_playlists->execute([$tutor_id]);

            if ($select_playlists->rowCount() > 0) {
                while ($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)) {
                    $playlist_id = $fetch_playlist['id'];


                    $count_videos = $conn->prepare('SELECT COUNT(*) as total FROM `content` WHERE playlist_id = ?');
                    $count_videos->execute([$playlist_id]);
                    $total_videos = $count_videos->fetch(PDO::FETCH_ASSOC)['total'];
                    ?>

                    <div class="box">
                        <div class="flex">
                            <div>
                                <i class="bx bx-dots-vertical-rounded"
                                    style="color: <?= ($fetch_playlist['status'] == 'active') ? 'limegreen' : 'red' ?>;"></i>
                                <span style="color: <?= ($fetch_playlist['status'] == 'active') ? 'limegreen' : 'red' ?>;">
                                    <?= $fetch_playlist['status']; ?>
                                </span>
                            </div>
                            <div>
                                <i class="bx bx-calendar"></i>
                                <span><?= $fetch_playlist['date']; ?></span>
                            </div>
                        </div>

                        <div class="thumb">
                            <span><?= $total_videos; ?></span>
                            <img src="../uploaded_files/<?= $fetch_playlist['thumb']; ?>"
                                alt="<?= $fetch_playlist['title']; ?>">
                        </div>

                        <h3 class="title"><?= htmlspecialchars($fetch_playlist['title']); ?></h3>
                        <p class="description"><?= htmlspecialchars($fetch_playlist['description']); ?></p>

                        <form action="" method="post" class="flex-btn">
                            <input type="hidden" name="playlist_id" value="<?= $playlist_id; ?>">
                            <a href="update_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Редактировать</a>
                            <input type="submit" name="delete" value="Удалить" class="btn"
                                onclick="return confirm('Удалить этот плейлист?')">
                            <a href="view_playlist.php?get_id=<?= $playlist_id; ?>" class="btn">Посмотреть</a>
                        </form>
                    </div>

                <?php
                }
            } else {
                ?>
                <p class="empty">Плейлисты еще не добавлены</p>
            <?php } ?>

        </div>
    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>