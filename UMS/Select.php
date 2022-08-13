<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['faculty_name'])) {
    $st_id = $_SESSION['faculty_id'];
    echo $_SESSION['faculty_name'];
    echo $_SESSION['faculty_id'];
    header('location:login_form.php');
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Attendance</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
    <?php include('InstructorSidebar.php'); ?>
    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <?php
            $course_id = $_GET["id"];
            $courses = "SELECT * FROM `courses` WHERE id='$course_id'";
            $allcourses = mysqli_query($conn, $courses);

            if (mysqli_num_rows($allcourses) > 0) {
                $Allcourses = mysqli_fetch_array($allcourses);
            }
            ?>
            <h2>Students in <?php echo $Allcourses['name']; ?> course</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <br>
            <?php
            do {
                error_reporting(0);
               // unset($_GET['Attendance_taken']);
                $course_id = "";
                $course_id = $_GET["id"];
                $student_id = $_GET["student_id"];

                $Attendance_taken = $_GET['Attendance_taken'];
                //echo $Attendance_taken;
                
                $errorMessage = '';
                if ($Attendance_taken == 'true') {
                    $errorMessage = 'h';
                }else{
                    $errorMessage = '';
                }

                if (!empty($errorMessage)) {
                    echo " <div class='alert alert-warning' role='alert'>
                        <strong>You already have taken the attendance for this course</strong>
                        <button type='btn' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                }
                
                $errorMessage = '';
                echo $errorMessage;
            } while (false);
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Campus</th>
                        <th>Email</th>
                        <th>Attended</th>
                    </tr>
                </thead>

                <tbody>



                    <?php


                    $st_id = $_SESSION['faculty_id'];
                    $userName="SELECT * FROM users WHERE id = $st_id";
                    $query = mysqli_query($conn, $userName);
                    if (mysqli_num_rows($query) > 0) {
                        $resultName = mysqli_fetch_array($query);
                    }

                    $courseName="SELECT * FROM courses WHERE id = $course_id";
                    $querycourse = mysqli_query($conn, $courseName);
                    if (mysqli_num_rows($querycourse) > 0) {
                        $resultCourse = mysqli_fetch_array($querycourse);
                    }


                    $sql = "SELECT DISTINCT student FROM `course_registrations` WHERE course='$resultCourse[name]'";
                    $result = mysqli_query($conn, $sql);




                    while ($row = $result->fetch_assoc()) {

                        $students = "SELECT * FROM `users` WHERE username='$row[student]'";
                     
                        $allstudents = mysqli_query($conn, $students);

                        if (mysqli_num_rows($allstudents) > 0) {
                            $Allstudents = mysqli_fetch_array($allstudents);
                        }

                        echo "<tr>
                            <td>$Allstudents[id]</td>
                            <td>$Allstudents[name]</td>
                            <td>$Allstudents[username]</td>
                            <td>$Allstudents[campus]</td>
                            <td>$Allstudents[email]</td>
                            <td>
                                
                                <a class='btn btn-success btn-sm' href='/UMS/attended.php?course_id=$course_id&student_id=$Allstudents[id]&attendance=present'>Present</a>
                                <a class='btn btn-danger btn-sm' href='/UMS/attended.php?course_id=$course_id&student_id=$row[student_id]&attendance=absent'>Absent</a>
                                <a class='btn btn-warning btn-sm' href='/UMS/attended.php?course_id=$course_id&student_id=$row[student_id]&attendance=late'>Late</a>
                            </td>
                        </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>