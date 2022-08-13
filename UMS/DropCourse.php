<?php
@include 'config.php';
if (!isset($_SESSION['student_name'])) {
    $st_id = $_SESSION['student_id'];
    echo $_SESSION['student_name'];
    echo $_SESSION['student_id'];
    header('location:login_form.php');
}
if(isset($_GET["id"])){
    $id=$_GET["id"];

    $sql ="DELETE FROM `course_registrations` WHERE id=$id";
    $result = mysqli_query($conn, $sql);
}
header("location:/UMS/registeredCourses.php");
exit;
?>