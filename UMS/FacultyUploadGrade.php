<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['faculty_name'])) {
    echo $_SESSION['faculty_name'];
    echo $_SESSION['faculty_id'];
    header('location:login_form.php');
}
$course_id = "";
$student_id = "";
$errorMessage = "";
$successMessage = "";
$exam_grade = "";
$exam = "";
$course_id = $_GET["course_id"];
$student_id = $_GET["student_id"];
if (isset($_POST['submit'])) {

    $exam_grade = $_POST["exam_grade"];
    $exam = $_POST["exam"];
    do {
        if (empty($exam_grade) || empty($exam)) {
            $errorMessage = "Please fill all required fields";
            break;
        }
        $select = "SELECT * FROM grades WHERE student_id= '$student_id' && course_id='$course_id' && exam='$exam'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "student with id " . $student_id . " already has a " . $exam . " grade";
            break;
        }
        $sql = "INSERT INTO `grades`(`id`, `grade`, `exam`, `course_id`, `student_id`) 
        VALUES (NULL,'$exam_grade','$exam','$course_id','$student_id')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        } else {
            $successMessage = $exam . " grade is Added Successfully!";
        }
    } while (false);
    // header("location:/UMS/admin.php");
    // exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Grades</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <?php include('InstructorSidebar.php');
    $course_id = $_GET["course_id"];
    $student_id = $_GET["student_id"];
    $courses = "SELECT * FROM `courses` WHERE id='$course_id'";
    $allcourses = mysqli_query($conn, $courses);

    if (mysqli_num_rows($allcourses) > 0) {
        $Allcourses = mysqli_fetch_array($allcourses);
    }
    $students = "SELECT * FROM `users` WHERE id='$student_id'";
    $allstudents = mysqli_query($conn, $students);

    if (mysqli_num_rows($allstudents) > 0) {
        $Allstudents = mysqli_fetch_array($allstudents);
    }
    ?>
    <style>
        body {
            overflow: scroll;
        }
    </style>
    <br>
    <div class="home_content">
        <style>
            body {
                overflow: scroll;
            }
        </style>
        <div class="container my-5">
            <h2>Upload Grade for <?php echo $Allstudents['name']; ?> in <?php echo $Allcourses['name']; ?> course</h2>
            <br>
            <?php
            if (!empty($errorMessage)) {
                echo " <div class='alert alert-warning' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
            ?>
            <form method="POST">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Exam Grade
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="exam_grade" value="<?php echo $exam_grade; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Exam
                    </label>

                    <div class="col-sm-6">
                        <select name="exam" class="form-control">
                            <option>Assignment</option>
                            <option>Miderm</option>
                            <option>Final</option>
                        </select>
                    </div>
                </div>
                <br>


                <?php
                if (!empty($successMessage)) {
                    echo "<div class='row mb-3'>
                    <div class='offset-sm-3 col-sm-6'></div>
                    <div class='alert alert-success' role='alert'>
                        <strong>$successMessage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
                </div>
            </div>";
                }
                ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" name="submit" class="btn  btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" onclick="history.back()" role="button">Cancel</a>
                    </div>
                </div>
            </form>
            <div class="col-xs-8 col-xs-offset-2">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>student ID</th>
                            <th>File Name</th>
                            <th>Document Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $course_id = $_GET["course_id"];
                        $student_id = $_GET["student_id"];
                        $sql = "SELECT * FROM grades WHERE course_id='$course_id' && student_id='$student_id'";
                        $result = mysqli_query($conn, $sql);
                        $i = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['student_id'] ?></td>
                                    <td><?php echo $row['grade']; ?></td>
                                    <td><?php echo $row['exam']; ?></td>
                                </tr>
                        <?php }
                        } else {
                            echo "<tr><td colspan=4>No Grades To show!</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>