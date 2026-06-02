<?php

?>



<header class="header">
    <section class="flex">
        <a href="index.php"><img src="image/logo.png" alt="130px"></a>
        <nav class="navbar">
            <a href="index.php"><span>Главная</span></a>
            <a href="about.php"><span>О нас</span></a>
            <a href="courses.php"><span>Курсы</span></a>
            <a href="teachers.php"><span>Преподаватели</span></a>
            <a href="contact.php"><span>Контакты</span></a>

        </nav>
        <form action="search_course.php" method="post" class="search-form">
            <input type="text" name="search_course" placeholder="Поиск курсов" required maxlength="100">
            <button type="submit" name="search_course_btn" class="bx bx-search-alt-2"></button>
        </form>
        <div class="icons">
            <div id="menu-btn" class="bx bx-list-plus"></div>
            <div id="search-btn" class="bx bx-search"></div>
            <div id="user-btn" class="bx bxs-user"></div>
        </div>
        <div class="profile">
            <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if ($select_profile->rowCount() > 0) {
                $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

                ?>
                <img src="uploaded_files/<?= $fetch_profile['image']; ?>">
                <h3><?= $fetch_profile['name']; ?></h3>
                <span>Ученик</span><br>

                <div class="flex-btn">
                <a href="profile.php" class="btn">Профиль</a>
                <a href="components/user_logout.php" onclick="return confirm('Выйти из этого аккаунта?');"
                    class="btn">Выйти</a>
                    </div>
                <?php
            } else {

                ?>
                <h3>Пожалуйста войдите в аккаунт или зарегистрируйтесь</h3>
                <div class="flex-btn">
                    <a href="login.php" class="btn">Войти</a>
                    <a href="register.php" class="btn">Регистрация</a>
                </div>
                <?php
            }
            ?>
            </div>
    </section>
</header>
