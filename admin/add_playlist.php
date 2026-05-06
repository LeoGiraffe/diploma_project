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

    $image = $_FILES['image']['name'];
    $image = htmlspecialchars($image, ENT_QUOTES, 'UTF-8');
    $ext = pathinfo($image, PATHINFO_EXTENSION);
    $rename = unique_id() . '.' . $ext;
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_files/' . $rename;

    $add_playlist = $conn->prepare("INSERT INTO `playlist`(id, tutor_id, title, description, thumb, status) VALUES(?,?,?,?,?,?)");
    $add_playlist->execute([$id, $tutor_id, $title, $description, $rename, $status]);
    move_uploaded_file($image_tmp_name, $image_folder);

    $message[] = 'Плейлист успешно создан';
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
        <h1 class="heading">Создать плейлист</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <p>Статус плейлиста <span>*</span></p>
            <select name="status" class="box">
                <option value="" selected disabled>---выбрать статус---</option>
                <option value="active">Активный</option>
                <option value="deactive">Неактивный</option>
            </select>
            <p>Название плейлиста <span>*</span></p>
            <input type="text" name="title" maxlength="150" placeholder="Введите название плейлиста" class="box">
            <p>Описание<span>*</span></p>
            <textarea name="description" class="box" placeholder="Описание" maxlength="1000" cols="30"
                rows="10"></textarea>
            <p>Превью<span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
            <input type="submit" name="submit" value="Создать плейлист" class="btn">

        </form>
    </section>
    <?php include '../components/footer.php'; ?>
    <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>