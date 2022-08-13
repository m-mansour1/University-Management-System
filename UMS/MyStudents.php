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
    <title>My Students</title>
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
            <h2>Students in your courses</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Course</th>
                        <th>Date of Birth</th>
                        <th>Phone Number</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $students = '';
                    $st_id = $_SESSION['faculty_id'];
                    $q1 = "SELECT * FROM users WHERE id=$st_id";
                    $userName = mysqli_query($conn, $q1);
                    if (mysqli_num_rows($userName) > 0) {
                        $result = mysqli_fetch_array($userName);
                    }
                    $course = "SELECT * FROM courses WHERE instructor='$result[username]'";
                    $q4 = mysqli_query($conn, $course);

                    while ($row = $q4->fetch_assoc()) {
                        $sql = "SELECT * FROM course_registrations WHERE course='$row[name]'";

                        $regs = mysqli_query($conn, $sql);
                        while ($regis = $regs->fetch_assoc()) {
                            $ql2 = "SELECT * FROM users WHERE username='$regis[student]'";

                            $students = mysqli_query($conn, $ql2);
                            if (mysqli_num_rows($students) > 0) {
                                $res = mysqli_fetch_array($students);
                            }
                            echo "<tr>
                        <td>$res[id]</td>
                        <td>$res[name]</td>
                        <td>$res[username]</td>
                        <td>$row[name]</td>
                        <td>$res[DateOfBirth]</td>
                        <td>$res[PhoneNumber]</td>
                        <td>$res[email]</td>

                        
                    </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>