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
    <title>Courses</title>
</head>

<body>
    <?php include('StudentSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>Courses Grades</h2>
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
                        <th>From</th>
                        <th>To</th>
                        <th>Semester</th>
                        <th>Instructor</th>
                        <th>Credits</th>
                        <th>Classroom</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $st_id = $_SESSION['student_id'];
                    $namesql= "SELECT * FROM users WHERE id='$st_id'";
                    $resultName = mysqli_query($conn, $namesql);
                    if (mysqli_num_rows($resultName) > 0) {
                        $studentName = mysqli_fetch_array($resultName);
                    }
                    $sql="SELECT * FROM `course_registrations` WHERE student='$studentName[username]'";
                    
                    $result = mysqli_query($conn, $sql);

                    while ($row = $result->fetch_assoc()) {
                        $Courses="SELECT * FROM courses WHERE name='$row[course]'";
                        $allcourses = mysqli_query($conn, $Courses);
                        if (mysqli_num_rows($allcourses) > 0) {
                            $AllCourses = mysqli_fetch_array($allcourses);
                        }
                        
                        echo "<tr>
                        <td>$AllCourses[id]</td>
                        <td>$AllCourses[name]</td>
                        <td>$AllCourses[startDate]</td>
                        <td>$AllCourses[endDate]</td>
                        <td>$AllCourses[semester]</td>
                        <td>$AllCourses[instructor]</td>
                        <td>$AllCourses[credits]</td>
                        <td>$AllCourses[classroom]</td>
                        <td>
                            <a class='btn btn-success btn-sm' href='/UMS/StudentGrades.php?id=$AllCourses[id]'>Check Grade</a>
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