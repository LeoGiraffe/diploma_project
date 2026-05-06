<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . $msg . '</span>
            <i class="bx bx-x" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>
<header class="header">
    <section class="flex">
        <a href="dashboard.php"> <img src="../image/logo.png" width="130px"> </a>
        <form action="search_pahe.php" method="post" class="search_form">
            <input type="text" name="search" placeholder="search here.." required maxlength="100">
            <button type="submit" class="bx bx-search" name="search_btn"></button>
        </form>
        <div class="icons">
            <div id="menu-btn" class="bx bx-list-plus"></div>
            <div id="search-btn" class="bx bx-search"></div>
            <div id="user-btn" class="bx bxs-user"></div>
        </div>
        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
            $select_profile->execute([$tutor_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

                ?>
                <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
                <h3><?= $fetch_profile['name']; ?></h3>
                <span><?= $fetch_profile['profession']; ?></span><br>

                <div id="flex-btn"></div>
                <a href="profile.php" class="btn">Посмтотреть профиль</a>
                <a href="../components/admin_logout.php" onclick="return confirm('Выйти из этого аккаунта?');"
                    class="btn">Выйти</a>
                <?php
            } else {

                ?>
                <h3>Пожалуйста войдите в аккаунт или зарегистрируйтесь</h3>
                <div id="flex-btn">
                    <a href="login.php" class="btn">Войти</a>
                    <a href="register.php" class="btn">Регистрация</a>
                </div>
                <?php
            }
            ?>
    </section>
</header>
<div class="side-bar">
    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
        $select_profile->execute([$tutor_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

            ?>
            <img src="../uploaded_files/<?= $fetch_profile['image']; ?>">
            <h3><?= $fetch_profile['name']; ?></h3>
            <p><?= $fetch_profile['profession']; ?></p>
            <a href="prifile.php" class="btn">Посмтотреть профиль</a>
        <?php
        } else {

            ?>
            <h3>Пожалуйста войдите в аккаунт или зарегистрируйтесь</h3>
            <div id="flex-btn"></div>
            <a href="login.php" class="btn">Войти</a>
            <a href="register.php" class="btn">Регистрация</a>

            <?php
        }
        ?>
    </div>
    <nav class="navbar">
        <a href="dashboard.php"><i class="bx bxs-home-heart"></i><span>Домой</span></a>
        <a href="playlist.php"><i class="bx bxs-receipt"></i><span>Плейлист</span></a>
        <a href="contents.php"><i class="bx bxs-graduation"></i><span>Контент</span></a>
        <a href="comments.php"><i class="bx bxs-home-heart"></i><span>Домой</span></a>
        <a href="../components/admin_logout.php" onclick="return confirm ('Выйти из профиля?');"><i
                class="bx bxs-log-in-circle"></i><span>Выйти</span></a>


    </nav>
</div>