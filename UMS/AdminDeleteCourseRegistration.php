<?php
@include 'config.php';
if(isset($_GET["id"])){
    $id=$_GET["id"];

    $sql ="DELETE FROM `course_registrations` WHERE id=$id";
    $result = mysqli_query($conn, $sql);
}
header("location:/UMS/AdminCourseRegistrations.php");
exit;
?>