<?php 
include '../components/connect.php'; 

if(isset($_COOKIE['tutor_id'])){
    $tutor_id = $_COOKIE['tutor_id'];
}else{
    $tutor_id = '';
    header('location: login.php');
}

if (isset($_POST['submit'])){
    $select_tutor = $conn->prepare('SELECT * FROM `tutors` WHERE id = ? LIMIT 1');
    $select_tutor->execute([$tutor_id]);
    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

    $prev_pass = $fetch_tutor['password'];
    $prev_image = $fetch_tutor['image'];

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $profession = $_POST['profession'];
    $profession = filter_var($profession, FILTER_SANITIZE_STRING);

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (!empty(($name))){
        $update_name = $conn->prepare("UPDATE `tutors` SET name = ? WHERE id = ?");
        $update_name->execute([$name, $tutor_id]);
        $message[] = 'Имя успешно обновлено';
    }
    if (!empty(($profession))){
        $update_name = $conn->prepare("UPDATE `tutors` SET profession = ? WHERE id = ?");
        $update_name->execute([$profession, $tutor_id]);
        $message[] = 'Профессия успешно обновлена';
    }
    if (!empty(($email))){
        $select_email = $conn->prepare("SELECT * FROM `tutors`  WHERE id = ? AND email = ?  ");
        $update_name->execute([$email, $tutor_id]);
        if($select_email->rowCount() > 0){
            $message[] = "Этот mail уже занят";
    } else {
        $update_email = $conn->prepare("UPDATE `tutors` SET email = ? WHERE id = ?");
        $update_email->execute([$email, $tutor_id]);
        $message[] = 'Email успешно обновлен';
    }
} 
$image = $_FILES['image']['name'];
$image = filter_var($image, FILTER_SANITIZE_STRING);
$ext = pathinfo($image, PATHINFO_EXTENSION);
$rename = unique_id() .'.'. $ext;
$image_size = $_FILES['image']['size'];
$imahe_tmp_name = $_FILES['image']['tmp_name'];
$image_folder = '../uploaded_files/'.$rename;

if(!empty($image)){
    if( $image_size > 2000000) {
        $message[] = 'Размер изображения слишком большой';
    } else {
$update_image = $conn->query("UPDATE `tutors` SET image = ? WHERE id = ?");
$update_image->execute([$rename, $tutor_id]);
move_uploaded_file($image_tmp_name, $image_folder);
if($prev_image != '' AND $prev_image != $rename) {
    unlink('../uploaded_files/'.$prev_image);
}
$message [] = 'Фото успешно обновлено';
    }
}

$empty_pass = 'ada6afc8d40f8f0230014fbc2f20eb5c2b60a252';
$old_pass = sha1($_POST['old_pass']);
$old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
$new_pass = sha1($_POST['new_pass']);
$new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);

$cpass = sha1($_POST['cpass']);
$cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

if($old_pass != $empty_pass) {
    if($old_pass != $prev_pass) {
        $message[] = 'Старый пароль не совпадает';
} elseif ($new_pass != $cpass) {
    $message[] = 'Новый пароль не совпадает';
} else {
    if($new_pass != $empty_pass) {
        $update_pass=$conn->prepare( "UPDATE `tutors` SET password = ? WHERE id = ?");
        $update_pass->execute([$cpass, $tutor_id]);
        $message[] = 'Пароль успешно обновлен';
    } else {
        $message[] = 'Пожалуйста введите новый пароль';
    }
}
} }

?>
<style>
    <?php include '../css/admin_style.css';?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать профиль</title>
    <!-- Basic Icons -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
     <?php include'../components/admin_header.php';?>
    <div class="form-container" style="min-height: calc(100vh - 19rem); padding: 5rem;">
        <form action="" method="post" enctype="multipart/form-data" class="register">
            <h3>Редактировать профиль</h3>
                <div class="flex">
                    <div class="col">
                        <p>имя<span>*</span></p>
                        <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" maxlength="50"  class="box">
                        <p>Должность<span>*</span></p>
                        <select name="profession" required class="box">
                            <option value="" disabled selected><?= $fetch_profile['profession']; ?></option>
                            <option value="Разработчик игр">Разработчик игр</option>
                            <option value="Разработчик мобильных приложений">Разработчик мобильных приложений</option>
                        </select>
                        <p>email<span>*</span></p>
                        <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" maxlength="50"  class="box">
                    </div>
                    <div class="col">
                        <p>старый пароль<span>*</span></p>
                        <input type="password" name="old_pass" placeholder="Введите старый пароль" maxlength="20"  class="box">
                        <p>Новый пароль<span>*</span></p>
                        <input type="password" name="new_pass" placeholder="Придумайте новый пароль" maxlength="20"  class="box">
                        <p>Подтвердите пароль<span>*</span></p>
                        <input type="password" name="cpass" placeholder="Введите новый пароль" maxlength="20"  class="box">
                        
                    </div>
                </div>
                <p>Сменить фотографию<span>*</span></p>
                    <input type="file" name="image" accept="image/*" class="box">
                    <input type="submit" name="submit" class="btn" value="Сохранить">
        </form>
    </div>
    <?php include'../components/footer.php';?>
    <script src = "../js/admin_script.js"></script>
</body>
</html>