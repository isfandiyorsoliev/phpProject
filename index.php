<?php
require_once 'config/connect.php';


$assessment_query = "SELECT students.id, students.fio, students.typeofedu, GROUP_CONCAT(assessments.assess ORDER BY subjects.id_sub SEPARATOR ',') AS assessments
                     FROM students
                     LEFT JOIN assessments ON students.id = assessments.id_stud
                     LEFT JOIN subjects ON assessments.id_sub = subjects.id_sub
                  
                     GROUP BY students.id";
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

<div class="form-container">
    <div class="form-group">
        <label for="academic_year"><b class="b1">Учебный год:</b></label>
        <select id="academic_year">
            <option value="1">2020-2021</option>
            <option value="2">2021-2022</option>
            <option value="3">2022-2023</option>
            <option value="4">2023-2024</option>
        </select>
    </div>

    <div class="form-group">
        <label for="specialty"><b class="b1">Специальность:</b></label>
        <select id="specialty">
            <option value="1">530102-А1</option>
            <option value="2">530102-А2</option>
            <option value="3">530102-Б</option>
        </select>
    </div>

    <div class="form-group">
        <label for="course"><b class="b1">Курс:</b></label>
        <select id="course">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
        </select>
    </div>

    <div class="form-group">
        <label for="semester"><b class="b1">Семестер:</b></label>
        <select id="semester">
            <option>1</option>
            <option>2</option>
        </select>
    </div>
</div>

<div class="button-container">
    <button onclick="submitForm()">Сформировать</button>
    <script>
        function submitForm() {
            var academicYear = document.getElementById("academic_year").value;
            var specialty = document.getElementById("specialty").value;
            var course = document.getElementById("course").value;
            var semester = document.getElementById("semester").value;

            document.getElementById("students_table").style.display = "block";

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "обработчик.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("output").innerHTML = xhr.responseText;
                }
            };
            xhr.send("academic_year=" + encodeURIComponent(academicYear) + "&specialty=" + encodeURIComponent(specialty) + "&course=" + encodeURIComponent(course) + "&semester=" + encodeURIComponent(semester));
        }
    </script>


    <button onclick="clearSelects()">Очистить</button>
    <script>
        function clearSelects() {
            var selects = document.getElementsByTagName("select");
            for (var i = 0; i < selects.length; i++) {
                selects[i].selectedIndex = 0;
            }
        }
    </script>
</div>
<div id="output"></div>
<br>

<table id="students_table" style="display: none;">
<!--  Стеденти и Оценки-->
</table>



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
