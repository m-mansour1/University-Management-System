<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Courses</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Admins Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>List of Course Registration</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <a class="btn btn-primary" href="/UMS/AdminCreateCourseRegistration.php" role="button">
                New Registration
            </a>
            <br>
            <table class="table">
                <thead>
                    <tr>

                        <th>ID</th>
                        <th>student</th>
                        <th>Instructor</th>
                        <th>Course Name</th>


                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT `id`, `student`, `course`  FROM `course_registrations`";
                    $result = $conn->query($sql);
                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }
                    while ($row = $result->fetch_assoc()) {

                        $courses = "SELECT * FROM `courses` WHERE name='$row[course]'";

                        $course = $conn->query($courses);
                        if (mysqli_num_rows($course) > 0) {
                            $allCourses = mysqli_fetch_array($course);
                        }

                            echo "<tr>
                        <td>$row[id]</td>
                        <td>$row[student]</td>
                        <td>$allCourses[instructor]</td>
                        <td>$row[course]</td>
                        <td>
                            <a class='btn btn-danger btn-sm' href='/UMS/AdminDeleteCourseRegistration.php?id=$row[id]'>Delete</a>
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