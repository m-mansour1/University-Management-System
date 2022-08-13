<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['faculty_name'])) {
    echo $_SESSION['faculty_name'];
    echo $_SESSION['faculty_id'];
    header('location:login_form.php');
}
$course_id = $_GET["course_id"];
$student_id = $_GET["student_id"];
$attendance = $_GET['attendance'];
$grade = 0;
if ($attendance == 'present') {
    $grade += 2;
} else if ($attendance == 'late') {
    $grade += 1;
}


$select = "SELECT * FROM `attendance` WHERE course_id = '$course_id' && student_id='$student_id' && attendance_day=curdate()";

$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
    header("location:/UMS/Select.php?id=$course_id&student_id=$student_id]'");
    exit;
}

$select = "SELECT * FROM `attendance` WHERE course_id = '$course_id' && student_id='$student_id'";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $grade = $row['grades'];
        if ($attendance == 'present') {
            $grade += 2;
        } else if ($attendance == 'late') {
            $grade += 1;
        }
    }
}

$sql = "INSERT INTO `attendance`(`id`, `course_id`, `student_id`, `attended`, `attendance_day`, `grades`) 
VALUES (NULL,'$course_id','$student_id','$attendance', curdate(), '$grade') ";
$result = mysqli_query($conn, $sql);
echo $sql;
header("location:/UMS/Select.php?id=$course_id&student_id=$student_id&attendance='$attendance''");
exit;
