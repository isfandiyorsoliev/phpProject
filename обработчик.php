<?php
require_once 'config/connect.php';

$academicYear = $_POST['academic_year'];
$specialty = $_POST['specialty'];
$course = $_POST['course'];
$semester = $_POST['semester'];

$academicYearInt = intval($academicYear);
$specialtyInt = intval($specialty);
$courseInt = intval($course);
$semesterInt = intval($semester);

$sql = "SELECT kod, nam FROM `specialization` WHERE id_spec = $specialtyInt";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
$spec = $row['nam'] . " (" . $row['kod'] . ")";

$sql1 = "SELECT year FROM `year` WHERE  id_year = $academicYearInt";
$result1 = mysqli_query($connect, $sql1);
$row = mysqli_fetch_assoc($result1);
$year =  $row['year'];

echo "<div style='width: 57%' class='info-container'>";
echo "<b>Факультет:</b> Информационных и Коммуникационных Технологии<br>";
echo "<b>Учебный год: </b>" . $year . "<br>";
echo "<b>Специальность: </b>" . $spec . "<br>";
echo "<b>Курс: </b>" . $course . "<br>";
echo "<b>Семестр: </b>" . $semester . "<br>";
echo "</div>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($academicYear) && !empty($course) && !empty($semester) && !empty($specialty)) {

        $query = "SELECT students.id, students.fio, students.typeofedu, students.special, 
            GROUP_CONCAT(subjects.subjects ORDER BY subjects.id_sub SEPARATOR ', ') AS subject_names,
            GROUP_CONCAT(assessments.assess ORDER BY subjects.id_sub SEPARATOR ', ') AS assessments,
            GROUP_CONCAT(teachers.teachers ORDER BY subjects.id_sub SEPARATOR ', ') AS teacher_names
            FROM students
            LEFT JOIN assessments ON students.id = assessments.id_stud
            LEFT JOIN subjects ON assessments.id_sub = subjects.id_sub
            LEFT JOIN teachers ON subjects.id_teach = teachers.id_teach
            WHERE  assessments.id_cours = '$courseInt'
            AND assessments.id_sem = '$semesterInt'
            AND assessments.id_year = '$academicYearInt'
            AND students.special = '$specialtyInt'
            GROUP BY students.id";

        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            echo '<style>
                table {
                    margin: auto;
                    border-collapse: collapse;
                    width: auto;
                }
                th, td {
                    border: 1px solid black;
                    text-align: center;
                    padding: 8px;
                }
                .vertical-text {
                    writing-mode: vertical-rl;
                    transform: rotate(180deg);
                    height: 200px;
                }
                .container {
                    margin-left: 10%;
                    margin-right: 10%;
                }
                .info-container {
                    width: 80%;
                    margin: 30px auto;
                    font-size: 18px;
                }
            </style>';
            echo "<div class='container'>";
            echo "<table>";
            echo "<tr><th>ID</th><th>ФИО</th><th>Тип <br> образования</th>";

            $row = mysqli_fetch_assoc($result);
            $subjects = explode(', ', $row['subject_names']);
            $teachers = explode(', ', $row['teacher_names']);

           
            foreach ($subjects as $subject) {
                echo "<th class='vertical-text'>$subject</th>";
            }
            echo "<th> Средняя <br> оценка </th>";

            echo "</tr>";

            mysqli_data_seek($result, 0);
            $total_average_score = 0;
            $total_students = mysqli_num_rows($result);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fio'] . "</td>";
                echo "<td>" . $row['typeofedu'] . "</td>";
                $assessments = explode(', ', $row['assessments']);
                $total_assessment = array_sum($assessments);
                $average_assessment = count($assessments) > 0 ? $total_assessment / count($assessments) : 0;
                foreach ($assessments as $assessment) {
                    $color = ($assessment < 3) ? 'red' : (($assessment > 4) ? 'green' : 'black');
                    echo "<td style='color: $color'>" . $assessment . "</td>";
                }
                $average_color = ($average_assessment > 3.5) ? 'green' : (($average_assessment < 3 ) ? 'red' : 'black');
                echo "<td style='color: $average_color'>" . round($average_assessment, 2) . "</td>";
                echo "</tr>";

                $total_average_score += $average_assessment;
            }

            $total_average_score = $total_students > 0 ? $total_average_score / $total_students : 0;

            echo "<td colspan='3'> </td>";
            foreach ($teachers as $teacher) {
                echo "<th class='vertical-text'>$teacher</th>";
            }
            echo "<td>Общий <br> GPA:" . round($total_average_score, 2) . "</td>"; // Выводим ячейку с заголовком

            echo "</tr>";
            echo "</table>";
            echo "</div>";

        } else {
            echo "Нет данных для отображения.";
        }
    } else {
        echo "Пожалуйста, заполните все поля формы.";
    }
}
?>
