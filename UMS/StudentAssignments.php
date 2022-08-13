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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Assignments</title>
</head>

<body>
    <style>
        .profile-image {
            padding-top: 30px;
            padding-left: 50px;
            padding-bottom: 40px;
        }

        .profile {
            padding-left: 50px;
        }

        #button-t {
            margin-top: 30px;
        }

        .parent {
            margin: 1rem;
            padding: 2rem 2rem;
        }

        .child {
            display: inline-block;
            padding: 1rem 1rem;
            vertical-align: middle;
        }

        h2 {
            font-weight: bold;
        }

        body {
            overflow: scroll;

        }
    </style>
    <?php include('StudentSidebar.php'); ?>
    <div class="home_content">
        <h2>Assignments</h2>
        <div class="container my-5">
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
                        <th>Campus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $name = '';
                    $st_id = $_SESSION['student_id'];
                    $stu_name = "SELECT * FROM users WHERE id='$st_id'";
                    $res = mysqli_query($conn, $stu_name);
                    if (mysqli_num_rows($res) > 0) {
                        $name = mysqli_fetch_array($res);
                    }
                    $sql = "SELECT * FROM `course_registrations` WHERE student='$name[username]'";

                    $result = mysqli_query($conn, $sql);

                    while ($row = $result->fetch_assoc()) {
                        $Courses = "SELECT * FROM courses WHERE name='$row[course]'";

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
                        <td>$AllCourses[campus]</td>
                        <td>
                            <a class='btn btn-primary btn-sm' href='/UMS/CheckAssignments.php?name=$AllCourses[name]&id=$AllCourses[id]'>check Assignments</a>
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