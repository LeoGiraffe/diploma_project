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

if (isset($_POST['update'])) {
    $video_id = $_POST['video_id'];
    $video_id = htmlspecialchars($video_id, ENT_QUOTES, 'UTF-8');
    $status = $_POST['status'];
    $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

    $title = $_POST['title'];
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

    $description = $_POST['description'];
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $playlist = $_POST['playlist'];
    $playlist = htmlspecialchars($playlist, ENT_QUOTES, 'UTF-8');

    $update_content = $conn->prepare('UPDATE `content` SET title = ?, description = ?, playlist_id = ?, status = ? WHERE id = ?');
    $update_content->execute([$title, $description, $playlist, $status, $video_id]);


    if (!empty($playlist)) {
        $update_playlist = $conn->prepare('UPDATE `content` SET playlist_id = ? WHERE id = ?');
        $update_playlist->execute([$playlist, $video_id]);
    }



    $old_thumb = $_POST['old_thumb'];
    $old_thumb = htmlspecialchars($old_thumb, ENT_QUOTES, 'UTF-8');


    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename_image = unique_id() . '.' . $image_ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename_image;


    if (!empty($image)) {
        if ($image_size > 2000000) {
            $message[] = 'Размер изображения слишком большой';
        } else {
            $update_thumb = $conn->prepare('UPDATE `content` SET thumb = ? WHERE id = ?');
            $update_thumb->execute([$rename_image, $video_id]);
            move_uploaded_file($image_tmp_name, $image_folder);
            if ($old_thumb != '' AND $old_thumb != $rename_image) {
                unlink('../uploaded_files/' . $old_thumb);
            }
        }
    }

    $old_video = $_POST['old_video'];
    $old_video = htmlspecialchars($old_video, ENT_QUOTES, 'UTF-8');


    $video = $_FILES['video']['name'];
    $video = htmlspecialchars($video, ENT_QUOTES, 'UTF-8');

    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $rename_video = unique_id() . '.' . $video_ext;
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/' . $rename_video;


    if (!empty($video)) {
        $update_video = $conn->prepare('UPDATE `content` SET video = ? WHERE id = ?');
        $update_video->execute([$rename_video, $video_id]);
        move_uploaded_file($video_tmp_name, $video_folder);

        if ($old_video != '' AND $old_video != $rename_video) {
            unlink('../uploaded_files/' . $old_video);
        }
    }
    $message[] = 'Контент обновлен';
}

if(isset($_POST['delete'])){
    $delete_id = $_POST['video_id'];
    $delete_id = htmlspecialchars($delete_id, ENT_QUOTES, 'UTF-8');

    $delete_video_thumb = $conn->prepare('SELECT thumb, video FROM `content` WHERE id = ? LIMIT 1');
    $delete_video_thumb->execute([$delete_id]);
    $fetch_files = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
    
    if(!empty($fetch_files['thumb'])) {
        unlink('../uploaded_files/' . $fetch_files['thumb']);
    }
    
    if(!empty($fetch_files['video'])) {
        unlink('../uploaded_files/' . $fetch_files['video']);
    }

    $delete_likes = $conn->prepare('DELETE FROM `likes` WHERE content = ?');
    $delete_likes->execute([$delete_id]);
    
    $delete_comments = $conn->prepare('DELETE FROM `comments` WHERE content_id = ?');
    $delete_comments->execute([$delete_id]);

    $delete_content = $conn->prepare('DELETE FROM `content` WHERE id = ?');
    $delete_content->execute([$delete_id]);
    
    header('location:content.php');
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
    <section class="video-form">
        <h1 class="heading">Добавить материалы</h1>
        <?php
        $select_videos = $conn->prepare('SELECT * FROM `content` WHERE id = ? AND tutor_id = ?');
        $select_videos->execute([$get_id, $tutor_id]);
        if ($select_videos->rowCount() > 0) {
            while ($fetch_videos = $select_videos->fetch(PDO::FETCH_ASSOC)) {
                $video_id = $fetch_videos['id'];


                ?>

                <form action="" method="post" enctype="multipart/form-data">
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
                    <p>Изменить ревью<span>*</span></p>
                    <input type="file" name="image" accept="image/*" class="box">
                    <video src="../uploaded_files/<?= $fetch_videos['video']; ?>" controls></video>
                    <p>Изменить материал<span>*</span></p>
                    <input type="file" name="video" accept="video/*" class="box">
                    <div class="flex-btn">
                        <input type="submit" name="update" value="Обновить" class="btn">
                        <a href="view_content.php?get_id=<?= $video_id ?>" class="btn">Посмотреть</a>
                        <input type="submit" name="delete" value="Удалить" class="btn">
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
</body>

</html>