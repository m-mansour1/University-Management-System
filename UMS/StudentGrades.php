<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['student_name'])) {
    $st_id = $_SESSION['student_id'];
    echo $_SESSION['student_name'];
    echo $_SESSION['student_id'];
    header('location:login_form.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>My Grades</title>
</head>

<body>
    <?php include('StudentSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>List of Grades</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Type</th>
                        <th>Grade</th>
                        <th>Course Attendance Grade (on 10% of the course grade)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        error_reporting(0);
                    if(isset($_GET["id"])){
                        $id=$_GET["id"];
                    
                    }

                    $st_id = $_SESSION['student_id'];
                    $sql = "SELECT * FROM grades WHERE student_id='$st_id' && course_id = '$id'";
                 
                    $result = $conn->query($sql);
                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }

                    $userSql = "SELECT * FROM users WHERE id=$st_id";
                    $res2 = $conn->query($userSql);
                    if (mysqli_num_rows($res2) > 0) {
                        $username = mysqli_fetch_array($res2);
                    }

                    $regs = "SELECT * FROM `course_registrations` WHERE student='$username[username]'";

                    $res = $conn->query($regs);
                    if (mysqli_num_rows($res) > 0) {
                        $courseID = mysqli_fetch_array($res);
                    }
                    $allCourses = "";
                    $courses = "SELECT * FROM `courses` WHERE id=$id";
        

                    $course = $conn->query($courses);
                    if (mysqli_num_rows($course) > 0) {
                        $allCourses = mysqli_fetch_array($course);
                    }
                    $attendance='';
                    $atts = "SELECT * FROM `attendance` WHERE course_id=$id";
                    $att = $conn->query($atts);
                    if (mysqli_num_rows($att) > 0) {
                        $attendance = mysqli_fetch_array($att);
                    }
                    $sum="";
                    $att="";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>$allCourses[name]</td>
                        <td>$row[exam]</td>
                        <td>$row[grade]</td>
                        <td>$attendance[grades]</td>
                    </tr>";
                    $sum+=$row['grade'];
                    $att=$attendance['grades'];
                
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>Grades Sum = <?php echo $sum*0.3 ?></td>
                        <td>+ Attendance total = <?php echo $att?></td>
                    </tr>
                    <tr>
                        <td colspan="4"></td>
                        Each of the Assignment/Midterm/Final is worth 30% of your total grade
                    </tr>
                    
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>