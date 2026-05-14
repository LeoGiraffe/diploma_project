<?php
include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location: login.php');
}


if (isset($_POST['delete_comment'])) {
    $delete_id = $_POST[' сomment_id'];
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
    <Sectio class="comments">
        <h1 class="heading">Комментарии</h1>
        <div class="show-comments">
            <?php
            $select_comments = $conn->prepare("SELECT * FROM `comments` WHERE tutor_id = ? ORDER BY id DESC");
            $select_comments->execute([$tutor_id]);

            if ($select_comments->rowCount() > 0) {
                while ($fetch_comment = $select_comments->fetch(PDO::FETCH_ASSOC)) {
                    $select_contents = $conn->prepare("SELECT * FROM `content` WHERE id = ?");
                    $select_contents->execute([$fetch_comment['content_id']]);
                    $fetch_content = $select_contents->fetch(PDO::FETCH_ASSOC);


                    ?>
                    <div class="box" style="<?php if($fetch_comment['tutor_id'] == $tutor_is){echo 'order: -1';}  ?>">
                        <div class="content"><span><?= $fetch_comment['date']; ?></span><p>- <?= $fetch_content['title']; ?> -</p><a href="view_content.php?get_id=<?= $fetch_content['id']; ?>">Посмотреть"></a></div>
                        <p class="text"><?= $fetch_comment['comment']; ?></p>
                        <form action="" method="post">
                            <input type="hidden" name="comment_id" value="<?= $fetch_comment['id']; ?>">
                            <button type="submit" name="delete_content" value="Удалить комментарий" class="btn" onclick="return confirm('Удалить этот комментарий?')">Удалить</button>
                        </form>

                    </div>

                    <?php
                }
            } else {
                echo '<p class="empty">Комментарии не найдены!</p>';
            }
            ?>
        </div>

        </Section>
        <?php include '../components/footer.php'; ?>
        <script type="text/javascript" src="../js/admin_script.js"></script>
</body>

</html>