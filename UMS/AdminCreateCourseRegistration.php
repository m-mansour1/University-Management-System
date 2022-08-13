<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}

$errorMessage = "";
$successMessage = "";
$student = "";
$course = "";
$student_cred = "";
$reg_cours_id = "";
$reg_timing = "";
$registered_timing = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $student = $_POST["student"];
    $course = $_POST["course"];
    do {

        if (empty($student) || empty($course)) {
            $errorMessage = "All fileds are required";
            break;
        }
        $select = "SELECT * FROM `course_registrations`  WHERE student= '$student' && course='$course'";
        $registrations = mysqli_query($conn, $select);
        if (mysqli_num_rows($registrations) > 0) {
            $errorMessage = "student is already registered to this course";
            break;
        }

        $sql = "SELECT * FROM `credits` WHERE `student`='$student'";

        $students = $conn->query($sql);
        if (mysqli_num_rows($students) > 0) {
            $student_cred = mysqli_fetch_array($students);
        }

        if ($student_cred['credits_number'] >= 6) {
            $errorMessage = "Student has reached the limit of 6 credits per semester, New fees could be added";
            break;
        } else {
            $sql = "SELECT * FROM `courses` WHERE `name`='$course'";
            $courses = $conn->query($sql);
            if (mysqli_num_rows($courses) > 0) {
                $course_cred = mysqli_fetch_array($courses);
            }
            $student_cred['credits_number'] += $course_cred['credits'];
        }
        $st_cr = "";
        $st_cr = $student_cred['credits_number'];
        $sql = "SELECT * FROM `courses` WHERE `name`='$course'";
        $select = "SELECT * FROM `course_registrations`  WHERE student = '$student'";

        $registrations = mysqli_query($conn, $select);
        if (mysqli_num_rows($registrations) > 0) {
            $registered_timing = mysqli_fetch_array($registrations);
        }
        $courses = $conn->query($sql);
        if (mysqli_num_rows($courses) > 0) {
            $course_cap = mysqli_fetch_array($courses);
        }

        $reg_cours_id = $registered_timing['course'];
        $sql = "SELECT * FROM `courses` WHERE `name`='$reg_cours_id'";
        $regts = mysqli_query($conn, $select);
        if (mysqli_num_rows($regts) > 0) {
            $reg_timing = mysqli_fetch_array($regts);
        }
        // if ($reg_timing['startDate'] == $course_cap['startDate']) {
        //     $errorMessage = "Time Conflict with " . $course_cap['name'] . " Course";
        //     break;
        // }

        $student_camp= "SELECT * FROM `users` WHERE `username`='$student'";
        $camp = $conn->query($student_camp);
        if (mysqli_num_rows($camp) > 0) {
            $campus = mysqli_fetch_array($camp);
        }
        if ($course_cap['campus'] != $campus['campus']) {

            $errorMessage = "This course is only offered in " .$campus['campus']." " .$course_cap['campus'] . " campus";
            break;
        }

        if ($course_cap['capacity'] == 0) {
            $errorMessage = "This course is full";
            break;
        } else {
            $capa=$course_cap['capacity'];
            $capa-= 1;
            $upd = "UPDATE `courses` SET `capacity`='$capa' WHERE `name`='$course'";
            $regts = mysqli_query($conn, $upd);
        }
        $sql = "UPDATE `credits` SET `credits_number`='$st_cr' WHERE `student`='$student'";

        $result = mysqli_query($conn, $sql);
        $sql = "INSERT INTO `course_registrations`(`id`,`student`,`course`) VALUES (NULL,'$student', '$course')";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        } else {
            $successMessage = "New Registration was Added Successfully!";
        }
    } while (false);
    // header("location:/UMS/semester.php");
    //  exit;
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
    <title>Registration Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>New course Registration</h2>
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
                        Student
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $query = "SELECT * FROM `users` WHERE user_type='student';";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }
                        ?>
                        <select name="student" class="form-control">
                            <?php
                            foreach ($options as $option) {
                                ?>
                                <option><?php echo $option['username']; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Course
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $query = "SELECT * FROM `courses`";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }
                        ?>
                        <select name="course" class="form-control">
                            <?php
                            foreach ($options as $option) {
                                ?>
                                <option><?php echo $option['name']; ?> </option>
                            <?php
                            }
                            ?>
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
                        <a class="btn btn-outline-primary" href="/UMS/AdminCourseRegistrations.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
</body>

</html>