<?php
@include 'config.php';
if (!isset($_SESSION['admin_name'])) {
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}
if(isset($_GET["id"])){
    $id=$_GET["id"];

    $sql ="DELETE FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
}
header("location:/UMS/Faculty.php");
exit;
?>