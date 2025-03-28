<?php
require_once 'config/connect.php';

// данные из бд
$assessment_query = "SELECT student.id, student.fio, student.tahsil, GROUP_CONCAT(assess.assess ORDER BY subjects.id_sub SEPARATOR ',') AS assessments
                     FROM student
                     LEFT JOIN assess ON student.id = assess.id_stud
                     LEFT JOIN subjects ON assess.id_sub = subjects.id_sub
                  
                     GROUP BY student.id";
$assessment_result = mysqli_query($connect, $assessment_query);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Итоговая ведомость студентов</title>
    <link href="img/ttu-logo.png" rel="icon" type="image/png" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="fontawesome-free-6.4.2-web/css/all.css">
</head>

<body>
<!--<header>-->
<!--    <nav class="top-bar">-->
<!--        <section class="top-bar-section">-->
<!--            <ul class="title-area">-->
<!--                <li class="name">-->
<!--                    <h1><a href="">######</a></h1>-->
<!--                </li>-->
<!--            </ul>-->
<!--            <ul class="left">-->
<!--                <li class="item "><a href="">####</a></li>-->
<!--                <li class="item "><a href="">####</a></li>-->
<!--                <li class="item "><a href="">####</a></li>-->
<!--                <li class="item "><a href="">####</a></li>-->
<!--            </ul>-->
<!--        </section>-->
<!--    </nav>-->
<!--</header>-->

<section>
    <div class="blog">
        <hr class="hr">
        <div class="large-12">
            <img src="img/ttu-logo.png"/>
            <h1><span>ТТУ</span> имени академика М.С.Осимӣ</h1>
        </div>
        <hr>
    </div>
</section>

<br>





<br>





<footer class="footer row">
    <div class="columns">
        <div class="footer_lists-container row collapse">
            <div class="footer_social columns large-2">
                <ul class="social">
                    <li class="telegram"><a href="https://t.me/username120323"><i class="fa-brands fa-telegram" id="i_1"></i></a></li>
                    <li class="facebook"><a href="https://www.facebook.com/ttu.m.s.osimi"><i class="fa-brands fa-square-facebook" id="i_2"></i></a></li>
                </ul>

                <p class="footer_copyright">Copyright (c) 2024, Mr. S.I.</p>
            </div>
            <ul class="footer_links">
                <li><a href="">Privacy Policy</a></li>
            </ul>
        </div>
    </div>
</footer>
</body>
</html>
