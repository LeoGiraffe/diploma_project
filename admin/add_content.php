<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}

if (isset($_POST['submit'])) {

    $id = unique_id();
    $title = $_POST['title'];
    $title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

    $description = $_POST['description'];
    $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

    $status = $_POST['status'];
    $status = htmlspecialchars($status, ENT_QUOTES, 'UTF-8');

    $playlist = $_POST['playlist'];
    $playlist = htmlspecialchars($playlist, ENT_QUOTES, 'UTF-8');

    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    $video = $_FILES['video']['name'];
    $video = htmlspecialchars($video, ENT_QUOTES, 'UTF-8');
    $video_ext = pathinfo($video, PATHINFO_EXTENSION);
    $video_rename = unique_id() . '.' . $video_ext;
    //$video_size = $_FILES['video']['size'];
    $video_tmp_name = $_FILES['video']['tmp_name'];
    $video_folder = '../uploaded_files/' . $video_rename;

    if ($image_size > 2000000) {
        $message[] = 'Размер изображения слишком большой';
    } else {
        $add_playlist = $conn->prepare('INSERT INTO `content` (id, tutor_id, playlist_id, title, description, video, thumb, status) VALUES(?,?,?,?,?,?,?,?)');
        $add_playlist->execute([$id, $tutor_id, $playlist, $title, $description, $video_rename, $rename, $status]);
        move_uploaded_file($image_tmp_name, $image_folder);
        move_uploaded_file($video_tmp_name, $video_folder);

        $message[] = 'Материал успешно добавлен';
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
    <section class="video-form">
        <h1 class="heading">Добавить материалы</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <p>Статус плейлиста <span>*</span></p>
            <select name="status" class="box">
                <option value="" selected disabled>---выбрать статус---</option>
                <option value="active">Активный</option>
                <option value="deactive">Неактивный</option>
            </select>
            <p>Название материала <span>*</span></p>
            <input type="text" name="title" maxlength="150" placeholder="Введите название материала" class="box">
            <p>Описание<span>*</span></p>
            <textarea name="description" class="box" placeholder="Описание" maxlength="1000" cols="30"
                rows="10"></textarea>
            <p>Плейлист<span>*</span></p>
            <select name="playlist" class="box" required>
                <option value="" selected disabled>---выбрать плейлист---</option>
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

            <p>Превью<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <p>Выбрать материал<span>*</span></p>
            <input type="file" name="video" accept="video/*" required class="box">
            <input type="submit" name="submit" value="Добавить материал" class="btn">

        </form>
    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>