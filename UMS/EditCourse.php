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
$startDate = "";
$endDate = "";
$semester = "";
$instructor = "";
$credits = "";
$capacity = "";
$classroom = "";
$campus = "";

$id = $_GET["id"];
$name = $_GET["name"];
$code = $_GET["code"];
$semester = $_GET["semester"];
$instructor = $_GET["instructor"];
$credits = $_GET["credits"];
$capacity = $_GET["capacity"];
$classroom = $_GET["classroom"];
$campus = $_GET["campus"];
$sql = "SELECT * FROM users WHERE id='$id'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
if (isset($_POST['submit'])) {
    $id = $_POST["id"];
    $name = $_POST["courseName"];
    $code = $_POST["code"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $semester = $_POST["semester"];
    $instructor = $_POST["instructor"];
    $credits = $_POST["credits"];
    $capacity = $_POST["capacity"];
    $classroom = $_POST["classroom"];
    $campus = $_POST["campus"];
    do {
        if (
            empty($name) || empty($semester) || empty($instructor) || empty($credits) || empty($capacity)
            || empty($campus) || empty($code)  || empty($startDate) || empty($endDate)  || empty($classroom)
        ) {
            $errorMessage = "all fields are required ";
            break;
        }
        $select = "SELECT * FROM courses WHERE code = '$code' && semester='$semester' && id!='$id'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Course with code ".$code." is already available";
            break;
        }
        
        $select = "SELECT * FROM courses WHERE classroom = '$classroom' && startDate='$startDate' && semester='$semester' && id!='$id'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "A course is booked in the same classroom and at the same timing";
            break;
        }
        $select = "SELECT * FROM courses WHERE instructor_id = '$instructor' && semester='$semester'&& startDate='$startDate' && id!='$id'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "Intructor ".$instructor." has another course booked at the same timing";
            break;
        }
        $sql = "UPDATE courses SET name='$name',code='$code',&& startDate='$startDate', endDate='$endDate',semester='$semester',
        instructor_id='$instructor',credits='$credits',capacity='$capacity',classroom='$classroom',
        campus='$campus' WHERE id= $id;";

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
        $successMessage = "Course was Modified successfully";
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Course</title>
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
        <div class="container my-5">
            <h2>Update Course</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
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
                        Name
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="courseName" value="<?php echo "$name"; ?>">
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
                        <input type="datetime-local" class="form-control" name="startDate"><br>
                    </div>

                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        end date
                    </label>
                    <div class="col-sm-6">
                        <input type="datetime-local" class="form-control" name="endDate"><br>
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
                            <option selected><?php echo $instructor; ?> </option>
                            <?php
                            foreach ($options as $option) {
                                ?>

                                <option><?php echo $option['id']; ?> </option>
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
                        <select class="form-control" name="credits">
                            <option selected><?php echo $credits; ?> </option>
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
                        <select class="form-control" name="capacity">
                            <option selected><?php echo $capacity; ?> </option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                            <option value="40">40</option>
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
                        <select name="campus" class="form-control">
                            <?php
                            foreach ($options as $option) {
                                ?>
                                <option selected><?php echo $campus; ?> </option>
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
                        <button type="submit" name="submit" class="btn  btn-primary">Update</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="/UMS/course.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>




</body>

</html>