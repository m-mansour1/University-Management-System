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
if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    $name = $_POST["FacultyName"];
    $username = $_POST["FacultyUsername"];
    $semester = $_POST["semester"];
    $campus = $_POST["campus"];
    $DOB = $_POST["DOB"];
    $Address = $_POST["Address"];
    $Phone = $_POST["PhoneNumber"];
    $Email = $_POST["FacultyEmail"];
    $Password = md5($_POST["FacultyPassword"]);
    do {
        if (empty($name) || empty($username) || empty($semester)|| empty($campus)|| empty($Address)
         || empty($Email) || empty($DOB) || empty($Password)|| empty($Phone)) {
            $errorMessage = "Please fill all required fields";
            break;
        }
        $select = "SELECT * FROM users WHERE username = '$username'";
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
        $sql = "INSERT INTO `users`(`id`, `name`, `username`, `activity_semester`, `campus`
        ,`DateOfBirth`, `Address`, `PhoneNumber`, `email`, `password`, `user_type`)
         VALUES (NULL,'$name','$username','$semester','$campus','$DOB','$Address','$Phone','$Email','$Password','faculty')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        } else {
            $successMessage = "New Faculty Added Successfully!";
        }
    } while (false);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faculty</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Faculty Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>Create Faculty</h2>
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
                        <input type="text" class="form-control" name="FacultyName" value="<?php echo $name; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Username
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="FacultyUsername" value="<?php echo $username; ?>">
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
                        <input type="date" class="form-control" name="DOB" value="<?php echo $DOB; ?>">
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
                        <input type="text" class="form-control" name="FacultyEmail" value="<?php echo $Email; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Password
                    </label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="FacultyPassword" value="<?php echo $Password; ?>">
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
                        <a class="btn btn-outline-primary" href="/UMS/Faculty.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>




</body>

</html>