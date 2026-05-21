<?php

include 'components/connect.php';



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';

}

$select_likes = $conn->prepare('SELECT * FROM `likes` WHERE user_id=?');
$select_likes->execute([$user_id]);
$total_likes = $select_likes->rowCount();



$select_comments = $conn->prepare('SELECT * FROM `comments` WHERE user_id=?');
$select_comments->execute([$user_id]);
$total_comments = $select_comments->rowCount();

$select_bookmarks = $conn->prepare('SELECT * FROM `bookmark` WHERE user_id=?');
$select_bookmarks->execute([$user_id]);
$total_bookmarks = $select_bookmarks->rowCount();









?>




<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дистанциум - домашняя страница</title>

    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>
    <!-------------------------home---------------->
    <div class="hero">
        <div class="box-container">
            <div class="box">
                <img src="image/banner-01.png">
            </div>
            <div class="box">
                <h1>Строй фундамент навыков — возводи карьеру</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Impedit explicabo neque iste dolorem aut
                    quos itaque non laudantium nemo sapiente!

                </p>
                <a href="courses.php" class="btn">Начать обучение</a>
            </div>
        </div>
    </div>

    <!-------------------------category---------------->
    <div class="categories">
        <div class="heading">
            <span>Категории</span>
            <h1>Выберите категорию <br> для обучения</h1>
        </div>
        <div class="box-container">
            <div class="box">
                <img src="image/web-design.png">
                <h3>Вэб-Дизайн</h3>
                <a href="courses.php">25 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/design.png">
                <h3>Графический дизайн</h3>
                <a href="courses.php">30 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/personal.png">
                <h3>Личностный рост</h3>
                <a href="courses.php">25 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/server.png">
                <h3>Информационные технологии</h3>
                <a href="courses.php">25 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/pantone.png">
                <h3>Продажи и маркетинг</h3>
                <a href="courses.php">20 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/paint-palette.png">
                <h3>Искусство</h3>
                <a href="courses.php">15 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/smartphone.png">
                <h3>Разработка мобильных приложений</h3>
                <a href="courses.php">35 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
            <div class="box">
                <img src="image/infographic.png">
                <h3>Финансы и бизнес</h3>
                <a href="courses.php">25 курсов <i class="bx bx-right-arrow-alt"></i></a>
            </div>
        </div>
    </div>

    <!-------------------------icons---------------->
    <div class="icon-section">
        <div class="box">
            <img src="image/icons-01.png">
            <h3>Бесплатные курсы</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
        </div>
        <div class="box">
            <img src="image/icons-02.png">
            <h3>Бесплатные курсы</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
        </div>
        <div class="box">
            <img src="image/icons-03.png">
            <h3>Бесплатные курсы</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
        </div>
        <div class="box">
            <img src="image/icons-04.png">
            <h3>Бесплатные курсы</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, quae.</p>
        </div>
    </div>
    <!-------------------------courses---------------->


    <div class="courses">
        <div class="heading">
            <span>Топ популярных курсов</span>
            <h1>Присоединяйтесь к нам</h1>
        </div>
        <div class="box-container">
            <?php
            $select_courses = $conn->prepare("SELECT * FROM `playlist` WHERE status = ? ORDER BY date DESC LIMIT 6");
            $select_courses->execute(['active']);
            if ($select_courses->rowCount() > 0) {
                while ($fetch_courses = $select_courses->fetch(PDO::FETCH_ASSOC)) {
                    $course_id = $fetch_courses['id'];


                    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
                    $select_tutor->execute([$fetch_courses['tutor_id']]);
                    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <div class="box">
                        <div class="tutor">
                            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>">
                            <div>
                                <h3><?= $fetch_tutor['name']; ?></h3>
                                <span><?= $fetch_courses['date']; ?></span>
                            </div>
                        </div>

                        <img src="uploaded_files/<?= $fetch_courses['thumb']; ?>" class="thumb">
                        <h3 class="title"><?= $fetch_courses['title']; ?></h3>
                        <a href="playlist.php?get_id=<?= $course_id; ?>">Подробнее</a>
                    </div>

                    <?php
                }
            } else {
                echo '<p class="empty">Курсов пока нет!</p>';
            }
            ?>
        </div>
        <div class="more-btn">
            <a href="courses.php" class="btn">Подробнее</a>
        </div>
    </div>


    <!-------------------------benifits---------------->
    <div class="benefits">
        <img src="image/map.png" class="map">
        <div class="detail">
            <h1>Учись где угодно <br> Доступ к занятиям с любого устройства</h1>
            <p>Гибкий график - Совмещай с работой и личными делами</p>
            <a href="courses.php" class="btn">Подробнее</a>
            <p>КАКАЯ ПОЛЬЗА ОТ ДИСТАНЦИУМА?</p>
            <div class="box-container">
                <div class="box">
                    <img src="image/benefit-01.png">
                    <p>Курс растёт вместе с тобой <br>постоянные обновления</p>
                </div>
                <div class="box">
                    <img src="image/benefit-02.png">
                    <p>Премиум поддержка<br> 6 месяцев бесплатно</p>
                </div>
                <div class="box">
                    <img src="image/benefit-03.png">
                    <p>Молниеносная скорость<br>никаких задержек</p>
                </div>
                <div class="box">
                    <img src="image/benefit-04.png">
                    <p>Премиум-качество<br>только лучшие курсы</p>
                </div>
                <div class="box">
                    <img src="image/benefit-05.png">
                    <p>Код и дизайн<br>курсы для профессионального роста</p>
                </div>
            </div>
        </div>
    </div>
    <!-------------------------learner---------------->
    <div class="learners">
        <div class="heading">
            <span>Почему выбирают нас</span>
            <h1>Мы создаём сообщество <br>для тех, кто учится постоянно</h1>
        </div>

        <div class="box-container">

            <!-- Блок 1 -->
            <div class="box">
                <div class="shape"></div>
                <div class="round">
                    <img src="image/counter-01.png">
                </div>
                <div class="box-counter">
                    <p class="counter" data-speed="500">500</p>
                    <i class="bx bx-plus"></i>
                </div>
                <p>учеников и растем</p>
            </div>

            <!-- Блок 2 -->
            <div class="box">
                <div class="shape"></div>
                <div class="round">
                    <img src="image/counter-02.png">
                </div>
                <div class="box-counter">
                    <p class="counter" data-speed="500">800</p>
                    <i class="bx bx-plus"></i>
                </div>
                <p>курсов и материалов</p>
            </div>

            <!-- Блок 3 -->
            <div class="box">
                <div class="shape"></div>
                <div class="round">
                    <img src="image/counter-03.png">
                </div>
                <div class="box-counter">
                    <p class="counter" data-speed="500">500</p>
                    <i class="bx bx-plus"></i>
                </div>
                <p>новых учеников в неделю</p>
            </div>

            <!-- Блок 4 -->
            <div class="box">
                <div class="shape"></div>
                <div class="round">
                    <img src="image/counter-04.png">
                </div>
                <div class="box-counter">
                    <p class="counter" data-speed="500">200</p>
                    <i class="bx bx-plus"></i>
                </div>
                <p>экспертов делятся знаниями</p>
            </div>

        </div>
    </div>

    <!-------------------------about us---------------->

    <div class="about-us">
        <siv class="box-container">
            <div class="box">
                <img src="image/about (2).png">
            </div>
            <div class="box">
                <div class="heading">
                    <span>Лучшие возможности</span>
                    <h1>Все что вам нужно для успеха</h1>
                    <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nesciunt aut qui quaerat tempore
                        delectus, numquam expedita ipsam quam debitis saepe.</p>
                    <a href="about.php" class="btn"> Узнай о нас больше</a>
                </div>
            </div>
        </siv>

    </div>

    <!-------------------------teacher section---------------->
<div class="teacher-section">
    <div class="heading">
        <span>Наши лучшие преподаватели</span>
        <h1>Которые вдохновляют</h1>
    </div>
    
    <div class="teacher-tabs">
        <img src="image/team-01.jpg" class="tab-item active" data-target="team-01">
        <img src="image/team-02.jpg" class="tab-item" data-target="team-02">
        <img src="image/team-03.jpg" class="tab-item" data-target="team-03">
        <img src="image/team-04.jpg" class="tab-item" data-target="team-04">
        <img src="image/team-05.jpg" class="tab-item" data-target="team-05">
        <img src="image/team-06.jpg" class="tab-item" data-target="team-06">
    </div>

    <div class="tab-content active" id="team-01">
        <img src="image/team-01.jpg">
        <div class="detail">
            <h2>Мария Ивановна</h2>
            <span>Ведущий преподаватель курсов</span>
            <p><i class="bx bx-briefcase"></i> Техлид в Яндекс.Практикум</p>
            <p>Опыт разработки 10 лет. Обучила 5000+ студентов</p>
        </div>
    </div>

    <div class="tab-content" id="team-02">
        <img src="image/team-02.jpg">
        <div class="detail">
            <h2>Анна Сергеевна</h2>
            <span>Ведущий преподаватель дизайна</span>
            <p><i class="bx bx-palette"></i> Арт-директор в крупном digital-агентстве</p>
            <p>Опыт 8 лет. Обучила 1500+ студентов основам UI/UX и графического дизайна</p>
        </div>
    </div>

    <div class="tab-content" id="team-03">
        <img src="image/team-03.jpg">
        <div class="detail">
            <h2>Екатерина Дмитриевна</h2>
            <span>Эксперт по экономике и финансам</span>
            <p><i class="bx bx-line-chart"></i> Финансовый аналитик с 12-летним стажем</p>
            <p>Помогает разобраться в макроэкономике, инвестициях и управлении капиталом</p>
        </div>
    </div>

    <div class="tab-content" id="team-04">
        <img src="image/team-04.jpg">
        <div class="detail">
            <h2>Ольга Владимировна</h2>
            <span>Старший преподаватель маркетинга</span>
            <p><i class="bx bx-megaphone"></i> Head of Marketing в международной компании</p>
            <p>10 лет в digital-маркетинге. Обучает SMM, SEO, контекстной рекламе и стратегиям продвижения</p>
        </div>
    </div>

    <div class="tab-content" id="team-05">
        <img src="image/team-05.jpg">
        <div class="detail">
            <h2>Дмитрий Сергеевич</h2>
            <span>Коуч и психолог</span>
            <p><i class="bx bx-brain"></i> Сертифицированный специалист по личностному росту</p>
            <p>Помогает раскрыть потенциал, развить эмоциональный интеллект и достичь целей</p>
        </div>
    </div>

    <div class="tab-content" id="team-06">
        <img src="image/team-06.jpg">
        <div class="detail">
            <h2>Максим Андреевич</h2>
            <span>Специалист по данным</span>
            <p><i class="bx bx-data"></i> Data Scientist в Ozon</p>
            <p>Обучает работе с большими данными, SQL, Python для анализа</p>
        </div>
    </div>
</div>


    <section class="home">
        <?php include 'components/user_footer.php'; ?>
        <script type="text/javascript" src="js/user_script.js"></script>
</body>

</html>