<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}
$errorMessage = "";
$successMessage = "";
$name = "";
$code = "";
$start = "";
$end = "";
$instructor = "";
$credits = "";
$capacity = "";
$classroom = "";
$campus = "";
$semester = "";
$desc="";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = $_POST["courseName"];
    $code = $_POST["code"];
    $start = $_POST["start"];
    $end = $_POST["end"];
    $instructor = $_POST["instructor"];
    $credits = $_POST["courseCredits"];
    $capacity = $_POST["courseCapacity"];
    $classroom = $_POST["classroom"];
    $campus = $_POST["courseCampus"];
    $semester = $_POST["semester"];
    $desc=$_POST["desc"];
    do {
        if (
            empty($name) || empty($semester) || empty($instructor) || empty($credits) || empty($capacity)
            || empty($campus) || empty($code)  || empty($start)  || empty($end) || empty($classroom) ||empty($desc)
        ) {
            $errorMessage = "all fields are required ";
            break;
        }
        $select = "SELECT * FROM courses WHERE code = '$code'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Course with code " . $code . " is already available";
            break;
        }
        $select = "SELECT * FROM courses WHERE name = '$name'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Course with name " . $name . " is already available";
            break;
        }
        $select = "SELECT * FROM courses WHERE classroom = '$classroom' && semester='$semester' && startDate='$start'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "A course is booked in the same classroom and at the same timing";
            break;
        }
        $select = "SELECT * FROM courses WHERE instructor = '$instructor' && semester='$semester' && startDate='$start'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Intructor " . $instructor . " has another course booked at the same timing";
            break;
        }
        $sql="INSERT INTO json (id, title,start,end, instructor,status) VALUES (NULL, '$name', '$start', '$end', '$instructor', 'ACTIVE')";
        $res=mysqli_query($conn,$sql);
        $sql = "INSERT INTO `courses`(`id`, `name`, `code`,`startDate`,`endDate`,`semester`, `instructor`, 
        `credits`, `capacity`,`classroom`, `campus`,`flag`,`description`) 
        VALUES (NULL,'$name','$code','$start','$end','$semester','$instructor','$credits','$capacity','$classroom','$campus', 0, '$desc')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        } else {
            $successMessage = "New Course was Added Successfully!";
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
    <title>Course Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <style>
            body {
                overflow: scroll;
            }
        </style>
        <div class="container my-5">
            <h2>New Course</h2>
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
                        Name
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="courseName" value="<?php echo $name; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Code
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="code" value="<?php echo "$code"; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        start date
                    </label>
                    <div class="col-sm-6">
                        <input type="datetime-local" class="form-control" name="start"><br>
                    </div>

                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        end date
                    </label>
                    <div class="col-sm-6">
                        <input type="datetime-local" class="form-control" name="end"><br>
                    </div>

                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Semester
                    </label>
                    <?php
                    $query = "SELECT * FROM `semester`";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                    ?>
                    <div class="col-sm-6">
                        <select name="semester" class="form-control">
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
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Instructor
                    </label>
                    <?php
                    $query = "SELECT * FROM `users` WHERE `user_type`='faculty'";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                    ?>
                    <div class="col-sm-6">
                        <select name="instructor" class="form-control">
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
                        Credits
                    </label>
                    <div class="col-sm-6">
                        <select class="form-control" name="courseCredits">
                            <option value="1">1</option>
                            <option value="2">3</option>
                            <option value="3">4</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Capacity
                    </label>
                    <div class="col-sm-6">
                        <select class="form-control" name="courseCapacity">
                            <option value="1">20</option>
                            <option value="2">25</option>
                            <option value="3">40</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Classroom
                    </label>
                    <?php
                    $query = "SELECT * FROM `classrooms`";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                    ?>
                    <div class="col-sm-6">
                        <select name="classroom" class="form-control">
                            <option selected><?php echo $classroom; ?> </option>
                            <?php
                            foreach ($options as $option) {
                                ?>

                                <option><?php echo $option['number'], " ", $option['Building']; ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Campus
                    </label>
                    <?php
                    $query = "SELECT name FROM campuses";
                    $result = $conn->query($query);
                    if ($result->num_rows > 0) {
                        $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    }
                    ?>
                    <div class="col-sm-6">
                        <select name="courseCampus" class="form-control">
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
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        description
                    </label>
                    <div class="col-sm-6">
                        <input type="textarea" class="form-control" name="desc"><br>
                    </div>

                </div><br>
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
                        <a class="btn btn-outline-primary" href="/UMS/course.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
</body>

</html>