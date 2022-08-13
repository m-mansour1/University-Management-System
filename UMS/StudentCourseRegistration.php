<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['student_name'])) {
    $st_id = $_SESSION['student_id'];
    echo $_SESSION['student_name'];
    echo $_SESSION['student_id'];
    header('location:login_form.php');
}
$code = "";
$errorMessage = "";
$successMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $code = $_POST["code"];
    do {
        if (empty($code)) {
            $errorMessage = "A code is required";
            break;
        }
        $st_id = $_SESSION['student_id'];
        $getUsername = "SELECT * FROM users WHERE id='$st_id'";

        $username = $conn->query($getUsername);
        $names="";
        if (mysqli_num_rows($username) > 0) {
            $names = mysqli_fetch_array($username);
        }
        $sql = "SELECT * FROM `credits` WHERE `student`='$names[username]'";

        $students = $conn->query($sql);
        $course_cred = "";
        if (mysqli_num_rows($students) > 0) {
            $student_cred = mysqli_fetch_array($students);
        }

        if ($student_cred['credits_number'] >= 6) {
            $errorMessage = "you have reached the limit of 6 credits per semester, New fees could be added";
            break;
        } else {
            $sql = "SELECT * FROM `courses` WHERE `Code`='$code'";
            $courses = $conn->query($sql);
            if (mysqli_num_rows($courses) > 0) {
                $course_cred = mysqli_fetch_array($courses);
                $student_cred['credits_number'] += $course_cred['credits'];
            } else {
                $errorMessage = "No course is found.";
                break;
            }
        }
        $sql = "SELECT * FROM `courses` WHERE `Code`='$code'";
        $courses = $conn->query($sql);
        if (mysqli_num_rows($courses) > 0) {
            $course_cap = mysqli_fetch_array($courses);
        }
        $student_camp = "SELECT * FROM `users` WHERE `id`='$st_id'";
        $camp = $conn->query($student_camp);
        if (mysqli_num_rows($camp) > 0) {
            $campus = mysqli_fetch_array($camp);
        }

        if ($course_cap['campus'] != $campus['campus']) {

            $errorMessage = "This course is only offered in " . $campus['campus'] . " " . $course_cap['campus'] . " campus";
            break;
        }

        if ($course_cap['capacity'] == 0) {
            $errorMessage = "This course is full";
            break;
        } else {
            $capa = $course_cap['capacity'];
            $capa -= 1;
            $upd = "UPDATE `courses` SET `capacity`='$capa' WHERE `Code`='$code'";
            $regts = mysqli_query($conn, $upd);
        }
        $st_cr = "";
        $st_cr = $student_cred['credits_number'];
        $sql = "UPDATE `credits` SET `credits_number`='$st_cr' WHERE `student`='$st_id'";


        $courses = "SELECT * FROM `courses`  WHERE code = '$code'";
        $course = $conn->query($courses);
        if (mysqli_num_rows($course) > 0) {
            $allCourses = mysqli_fetch_array($course);
        } else {
            $errorMessage = "There exists no course with the code " . $code;
            break;
        }
        $st_id = $_SESSION['student_name'];
        $select = "SELECT * FROM `course_registrations`  WHERE student = '$st_id' &&
         course='$allCourses[name]'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "You have already registered this course";
            break;
        }

        $select = "SELECT * FROM `course_registrations`  WHERE student = '$st_id' 
        && course='$allCourses[name]'";
        $courseName = "SELECT * FROM `course_registrations` WHERE student = '$st_id'";
        $result = mysqli_query($conn, $select);

        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "You have already registered this course";
            break;
        }

        if (mysqli_num_rows($course) <= 0) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
        $st_id = $_SESSION['student_id'];
        $username = "SELECT * FROM users WHERE id=$st_id";
        $re = mysqli_query($conn, $username);
        if (mysqli_num_rows($re) > 0) {
            $getUsername = mysqli_fetch_array($re);
        }
        $sql = "INSERT INTO `course_registrations`(`id`, `student`, `course`) 
        VALUES (NULL,'$getUsername[username]','$allCourses[name]')";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
        $successMessage = "Course was registered successfully";
    } while (false);
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
    <?php include('StudentSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">

        <div class="container my-5">
            <h2>Course Registration</h2>
            <?php
            if (!empty($errorMessage)) {
                echo " <div class='alert alert-warning' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
            ?>
            <form method="POST">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Code
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $query = "SELECT * FROM `courses`";
                        $result = $conn->query($query);
                        if ($result->num_rows > 0) {
                            $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        }
                        ?>
                        <select name="code" class="form-control">
                            <?php
                            foreach ($options as $option) {
                                ?>
                                <option><?php echo $option['code']; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>




                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" name="submit" class="btn  btn-primary">Register</button>
                    </div>
                </div>
            </form>
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
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <br>
        </div>
</body>

</html>