<?php

include 'components/connect.php';



if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';

}












?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас</title>

    <!-- Basic Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/user_style.css">
</head>

<body>
    <?php include 'components/user_header.php'; ?>

    <!-----------banner----------->


    <div class="banner">
        <div class="detail">
            <div class="title">
                <a href="index.php">Главная</a> <span><i class="bx bx-chevron-right"></i>О нас</span>
            </div>
            <h1>О нас</h1>
            <p>Дистанциум — это образовательная платформа, созданная для тех, кто хочет получать актуальные знания и
                развиваться в комфортном темпе. Мы объединяем экспертов из разных сфер, чтобы сделать качественное
                образование доступным для каждого.</p>
            <div class="flex-btn">
                <a href="login.php" class="btn">Войди чтобы начать</a>
                <a href="contact.php" class="btn">свяжитесь с нами</a>

            </div>

        </div>
        <img src="image/banner.png" alt="">


    </div>
    <!-----------about----------->

    <div class="about">
        <div class="box-container">
            <!-- Главный блок с картинками -->
            <div class="image-box">
                <img src="image/banner.png" class="main-image">
                <div class="thumbnail-1">
                    <img src="image/about.jpg" alt="">
                </div>
                <div class="thumbnail-2">
                    <img src="image/about1.jpg" alt="">
                </div>
                <div class="thumbnail-3">
                    <img src="image/about0.jpg" alt="">
                </div>
            </div>

            <!-- Блок с текстом -->
            <div class="content-box">
                <div class="title">
                    <span>Узнать о нас больше</span>
                    <h1>Узнай о платформе для обучения Дистанциум</h1>
                    <p>На платформе Дистанциум собраны лучшие преподаватели-практики из IT, дизайна, маркетинга и
                        бизнеса. Каждый курс создан так, чтобы вы получали только актуальные знания и могли сразу
                        применять их на деле.</p>
                    <p>Мы делаем образование доступным, интересным и эффективным. Дистанциум — это знания, которые
                        работают на твоё будущее.</p>
                </div>

                <div class="detail">
                    <i class="bx bx-calendar"></i>
                    <div>
                        <h3>Гибкий график</h3>
                        <p>Учитесь в удобное время без привязки к расписанию. Гибкий график позволяет совмещать обучение
                            с работой и личными делами.</p>
                    </div>
                </div>

                <div class="detail">
                    <i class="bx bx-location-plus"></i>
                    <div>
                        <h3>Доступность из любого места</h3>
                        <p>Учитесь из любого места: из дома, кафе, парка или в путешествии. Главное — наличие интернета.
                        </p>
                    </div>
                </div>

                <div class="detail">
                    <i class="bx bx-book-open"></i>
                    <div>
                        <h3>Профессиональные преподаватели</h3>
                        <p>Преподаватели-практики с многолетним опытом делятся только актуальными знаниями из реальных
                            проектов.</p>
                    </div>
                </div>

                <a href="" class="btn">Больше о нас</a>
            </div>
        </div>
    </div>
    <!-----------work----------->
    <div class="work">
        <div class="box-container">
            <div class="content">
                <div class="heading">
                    <span>Как мы работаем</span>
                    <h1>Построй свою карьеру и прокачай свою жизнь</h1>
                    <p>Мы даём вам структурированные знания, практические задания и поддержку опытных наставников. Вы
                        учитесь в своём темпе, без стресса и привязки к расписанию. Шаг за шагом осваиваете новую
                        профессию, собираете портфолио и становитесь востребованным специалистом. Построй свою карьеру и
                        прокачай свою жизнь вместе с Дистанциум.</p>
                    <a href="" class="btn">Подробнее</a>
                </div>
            </div>
            <div class="img-box">
                <img src="image/about2.png">
            </div>
        </div>
    </div>

    <!-----------testimonials----------->

    <div class="testimonial-container">
    <div class="heading">
        <span>Отзывы</span>
        <h1>Что о нас говорят</h1>
        <p>Не мы говорим о себе — о нас говорят наши ученики. Реальные истории, реальные результаты и искренние
            отзывы тех, кто уже построил карьеру и прокачал жизнь с Дистанциум.</p>
    </div>
    
    <div class="container">
        <div class="testimonial-item active">
            <i class="bx bxs-quote-right" id="quote"></i>
            <img src="image/client-01.png" alt="">
            <h1>Дмитрий Соколов</h1>
            <p>Повысили на работе после прохождения курса по управлению проектами. Знания сразу применил в деле, и
                начальство это оценило.</p>
        </div>
        
        <div class="testimonial-item">
            <i class="bx bxs-quote-right" id="quote"></i>
            <img src="image/client-02.png" alt="">
            <h1>Ольга Петрова</h1>
            <p>Училась в свободное время после работы. Сделала крутое портфолио, и меня пригласили в IT-компанию
                мечты. Дистанциум изменил мою жизнь.</p>
        </div>
        
        <div class="testimonial-item">
            <i class="bx bxs-quote-right" id="quote"></i>
            <img src="image/client-03.png" alt="">
            <h1>Максим Иванов</h1>
            <p>Долго боялся начать, но теперь жалею только об одном — что не пришёл сюда раньше. Гибкий график и
                живые уроки — это лучший формат обучения.</p>
        </div>
        
        <div class="testimonial-item">
            <i class="bx bxs-quote-right" id="quote"></i>
            <img src="image/client-04.png" alt="">
            <h1>Елена Морозова</h1>
            <p>За 3 месяца с нуля освоила новую профессию. Уже взяла первый заказ на фрилансе и уволилась с нелюбимой
                работы. Спасибо команде Дистанциум!</p>
        </div>
        
        <div class="left-arrow" onclick="prevSlide()"><i class="bx bx-chevron-left"></i></div>
        <div class="right-arrow" onclick="nextSlide()"><i class="bx bx-chevron-right"></i></div>
    </div>
</div>





    <?php include 'components/user_footer.php'; ?>
    <script type="text/javascript" src="js/user_script.js"></script>
</body>

</html>