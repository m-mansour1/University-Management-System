<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['faculty_name'])) {
    echo $_SESSION['faculty_name'];
    echo $_SESSION['faculty_id'];
    header('location:login_form.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <head>
        <link rel="stylesheet" href="css/style2.css">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <title>Attendance</title>
    </head>
</head>

<body>
    <?php include('InstructorSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>Take Attendance</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Semester</th>
                        <th>Credits</th>
                        <th>Capacity</th>
                        <th>Classroom</th>
                        <th>Campus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $st_id = $_SESSION['faculty_id'];
                    $sql = "SELECT * FROM users WHERE id=$st_id";
                    $UserName = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($UserName) > 0) {
                        $username = mysqli_fetch_array($UserName);
                    }
                    $courseql = "SELECT * FROM courses WHERE instructor='$username[username]'";
                    $query = mysqli_query($conn, $courseql);



                    while ($row = $query->fetch_assoc()) {
                        $Courses = "SELECT * FROM courses WHERE instructor='$username[username]'";

                        $allcourses = mysqli_query($conn, $Courses);
                        if (mysqli_num_rows($allcourses) > 0) {
                            $AllCourses = mysqli_fetch_array($allcourses);
                        }
                        $AttendanceTaken = "false";
                        $idd = $AllCourses['id'];
                        $Attres='';
                        $sql = "SELECT * FROM `attendance` WHERE course_id = '$row[id]'";


                        $AttendanceTaken = "";
                        $res = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($res) > 0) {
                            $AttendanceTaken = "true";
                        } else {
                            $AttendanceTaken = "false";
                        }


                        echo "<tr>
                        <td>$row[name]</td>
                        <td>$row[code]</td>
                        <td>$row[startDate]</td>
                        <td>$row[endDate]</td>
                        <td>$row[semester]</td>
                        <td>$row[credits]</td>
                        <td>$row[capacity]</td>
                        <td>$row[classroom]</td>
                        <td>$row[campus]</td>
                        <td>
                        
                        <a class='btn btn-primary btn-sm' href='/UMS/Select.php?id=$row[id]&Attendance_taken=$AttendanceTaken'>Take Attendance</a>
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