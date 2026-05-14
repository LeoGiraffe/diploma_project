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

if (isset($_POST['update'])) {
    $title = strip_tags(trim($_POST['title']));
    $description = strip_tags(trim($_POST['description']));
    $status = strip_tags(trim($_POST['status']));

    $update_playlist = $conn->prepare('UPDATE `playlist` SET title = ?, description = ?, status = ? WHERE id = ?');
    $update_playlist->execute([$title, $description, $status, $get_id]);

    $old_image = strip_tags(trim($_POST['old_image']));
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0 && !empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];
        $image = strip_tags($image);

        $ext = pathinfo($image, PATHINFO_EXTENSION);
        $rename = unique_id() . '.' . $ext;
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];

        $image_folder = '../uploaded_files/' . $rename;

        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $file_type = mime_content_type($image_tmp_name);

        if (!in_array($file_type, $allowed_types)) {
            $message[] = 'Можно загружать только изображения (JPG, PNG, GIF, WEBP)';
        } elseif ($image_size > 2000000) {
            $message[] = 'Размер изображения не должен превышать 2MB';
        } else {
            $update_image = $conn->prepare("UPDATE `playlist` SET thumb = ? WHERE id = ?");
            $update_image->execute([$rename, $get_id]);

            if (move_uploaded_file($image_tmp_name, $image_folder)) {
                if (!empty($old_image) && $old_image != $rename && file_exists('../uploaded_files/' . $old_image)) {
                    unlink('../uploaded_files/' . $old_image);
                }
                $message[] = 'Изображение обновлено';
            } else {
                $message[] = 'Ошибка при загрузке изображения';
            }
        }
    }

    $message[] = 'Плейлист успешно обновлен';

}

if (isset($_POST['delete'])) {
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
                <form action="" method="post" enctype="multipart/form-data">
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
                        <input type="submit" name="update" value="Обновить" class="btn">
                        <input type="submit" name="delete" value="Удалить" class="btn"
                            onclick="return confirm('Удалить этот плейлист')">
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
</body>

</html>