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
$username = "";
$semester = "";
$campus = "";
$DOB = "";
$Address = "";
$Phone = "";
$Email = "";
$Password = "";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET["id"])) {
        header("location:/UMS/AdminStudents.php");
        exit;
    }
    $id = $_GET["id"];
    $name = $_GET["studentName"];
    $username = $_GET["studentUsername"];
    $semester = $_GET["semester"];
    $campus = $_GET["campus"];
    $DOB = $_GET["DOB"];
    $Address = $_GET["Address"];
    $Phone = $_GET["PhoneNumber"];
    $Email = $_GET["studentEmail"];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $row = $result->fetch_assoc();
    if (!$row) {
        header("location:/UMS/AdminStudents.php");
        exit;
    }
} else {
    $id = $_POST["id"];
    $name = $_POST["studentName"];
    $username = $_POST["studentUsername"];
    $semester = $_POST["semester"];
    $campus = $_POST["campus"];
    $DOB = $_POST["DOB"];
    $Address = $_POST["Address"];
    $Phone = $_POST["PhoneNumber"];
    $Email = $_POST["studentEmail"];
    $Password = md5($_POST["studentPassword"]);
    do {
        if (
            empty($name) || empty($username) || empty($semester) || empty($campus) || empty($Address)
            || empty($Email) || empty($DOB) || empty($Password) || empty($Phone)
        ) {
            $errorMessage = "Please fill all required fields";
            break;
        }

        $select = "SELECT * FROM users WHERE username = '$username' && id!=$id";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "username is not available";
            break;
        }

        if (!filter_var($Email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Invalid email format";
            break;
        }
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
            $errorMessage = "Only letters and white space allowed";
            break;
          }
        $sql = "UPDATE users SET name='$name',username='$username',activity_semester='$semester',campus='$campus',
        DateOfBirth='$DOB',Address='$Address',PhoneNumber='$Phone',
        email='$Email',password='$Password' WHERE id= $id;";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
        $successMessage = "Student was Modified successfully";
    } while (false);
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
    <title>Admin Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>Update Student</h2>
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
                        <input type="text" class="form-control" name="studentName" value="<?php echo $name; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Username
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="studentUsername" value="<?php echo $username; ?>">
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
                            <option selected><?php echo $semester; ?> </option>
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
                            <option selected><?php echo $campus; ?> </option>
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
                        Date Of Birth
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="DOB" value="<?php echo $DOB; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Address
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Phone Number
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="PhoneNumber" value="<?php echo $Phone; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Email
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="studentEmail" value="<?php echo $Email; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Password
                    </label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="studentPassword" value="<?php echo $Password; ?>">
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
                        <a class="btn btn-outline-primary" href="/UMS/AdminStudents.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>




</body>

</html>