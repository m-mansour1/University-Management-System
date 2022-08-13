<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['student_name'])) {
    $st_id = $_SESSION['student_id'];
    echo $_SESSION['student_name'];
    echo $_SESSION['student_id'];
    header('location:login_form.php');
}
$name = "";
$username = "";
$dob = "";
$address = "";
$phone = "";
$email = "";
$password = "";
$st_id = $_SESSION['student_id'];
$sql = "SELECT * FROM users WHERE id='$st_id'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
if (!$row) {
    header("location:/UMS/StudentProfile.php");
    exit;
}
$name = $row["name"];
$username = $row["username"];
$dob = $row["DateOfBirth"];
$address = $row["Address"];
$phone = $row["PhoneNumber"];
$email = $row["email"];
$password = $row["password"];
if (isset($_POST['submit'])) {
    $st_id = $_SESSION['student_id'];
    $name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $username = mysqli_real_escape_string($conn, $_POST['update_username']);
    $dob = mysqli_real_escape_string($conn, $_POST['update_dob']);
    $address = mysqli_real_escape_string($conn, $_POST['update_address']);
    $phone = mysqli_real_escape_string($conn, $_POST['update_phone']);
    $email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $password = md5(mysqli_real_escape_string($conn, $_POST['update_pass']));


    do {
        if (
            empty($name) || empty($username) || empty($dob)
            || empty($address) || empty($phone) || empty($email) || empty($password)
        ) {
            $errorMessage = "all fields are required ";
            break;
        }
        $select = "SELECT * FROM users WHERE username = '$username' && id!=$st_id";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "username is not available";
            break;
        }
        $sql = "UPDATE `users` SET `name`='$name',`username`='$username',
        `DateOfBirth`='$dob',`Address`='$address',`PhoneNumber`='$phone',
        `email`='$email',`password`='$password',`user_type`='student' WHERE id='$st_id'";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        }
        $successMessage = "Your Profile was Modified successfully";
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
    <title>Update Profile Data</title>
</head>

<body>
    <?php include('StudentSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>Edit Profile Information</h2><br>
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
                        <input type="text" class="form-control" name="update_name" value="<?php echo $name; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Username
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="update_username" value="<?php echo $username; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Date Of Birth
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="update_dob" value="<?php echo $dob; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Address
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="update_address" value="<?php echo $address; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Phone Number
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="update_phone" value="<?php echo $phone; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Email
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="update_email" value="<?php echo $email; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Password
                    </label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="update_pass" value="<?php echo $password; ?>">
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
                        <a class="btn btn-outline-primary" href="/UMS/StudentProfile.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
</body>

</html>