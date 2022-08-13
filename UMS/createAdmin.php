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
if (isset($_POST['submit'])) {

    $name = $_POST["NameAdmin"];
    $username = $_POST["UsernameAdmin"];
    $semester = $_POST["semester"];
    $campus = $_POST["campus"];
    $DOB = $_POST["DateOfBirth"];
    $Address = $_POST["AdminAddress"];
    $Phone = $_POST["AdminPhone"];
    $Email =  $_POST["EmailAdmin"];
    $Password =  md5($_POST["PasswordAdmin"]);
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
        $sql = "INSERT INTO `users`(`id`, `name`, `username`,`activity_semester`, `campus`
        , `DateOfBirth`, `Address`, `PhoneNumber`,`email`, `password`, `user_type`)
         VALUES (NULL,'$name','$username','$semester','$campus','$DOB','$Address','$Phone','$Email','$Password','admin')";
        $result = mysqli_query($conn, $sql);
        if (!$result) {
            $errorMessage = "Invalid query: " . $conn->error;
            break;
        } else {
            $successMessage = "New Admin is Added Successfully!";
        }
    } while (false);
    // header("location:/UMS/admin.php");
    // exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Semester Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <style>
            body{
                overflow: scroll;
            }
        </style>
        <div class="container my-5">
            <h2>New Admin</h2>
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
                        Name
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="NameAdmin" value="<?php echo $name; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Username
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="UsernameAdmin" value="<?php echo $username; ?>">
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
                        Date of Birth
                    </label>
                    <div class="col-sm-6">
                        <input type="date" class="form-control" name="DateOfBirth" value="<?php echo $DOB; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Address
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="AdminAddress" value="<?php echo $Address; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Phone Number
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="AdminPhone" value="<?php echo $Phone; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Email
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="EmailAdmin" value="<?php echo $Email; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Password
                    </label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control" name="PasswordAdmin" value="<?php echo $Password; ?>">
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
                        <a class="btn btn-outline-primary" href="/UMS/admin.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>