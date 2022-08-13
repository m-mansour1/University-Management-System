<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    $st_id = $_SESSION['admin_id'];
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}
$intsructor_name = "";
$intsructor_username = "";
$intsructor_campus = "";
$intsructor_semester = "";
$intsructor_DateOfBirth = "";
$intsructor_Address = "";
$intsructor_PhoneNumber = "";
$intsructor_email = "";
$intsructor_type = "";
$st_id = $_SESSION['admin_id'];
$sql = "SELECT * FROM `users` WHERE id='$st_id'";
$result = mysqli_query($conn, $sql);

while ($row = $result->fetch_assoc()) {
    $intsructor_name = $row['name'];
    $intsructor_username = $row['username'];
    $intsructor_campus = $row['campus'];
    $intsructor_DateOfBirth = $row['DateOfBirth'];
    $intsructor_Address = $row['Address'];
    $intsructor_PhoneNumber = $row['PhoneNumber'];
    $intsructor_email = $row['email'];
    $intsructor_type = $row['user_type'];
    $intsructor_semester = $row["activity_semester"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>My Profile</title>
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
    <style>
        .profile-image {
            padding-top: 30px;
            padding-left: 50px;
            padding-bottom: 40px;
        }

        .profile {
            padding-left: 200px;
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


        body {
            overflow: scroll;
            background: #1d1b31;
        }

        h3 {
            color: #fff;
        }

        h2 {
            color: #fff;
            font-weight: bold;
        }
    </style>
    <?php include('AdminSidebar.php'); ?>
    <div class="home_content">
        <h2>Profile Information</h2>
        <div class="parent">
            <div class="child">
                <img src="images/user.png" height="315px" width="315px" alt="...">
            </div>

            <div class="child">
                <div class="profile">
                    <?php
                    $st_id = $_SESSION['admin_id'];

                    $select = mysqli_query($conn, "SELECT * FROM users WHERE id='$st_id'")
                        or die('query failed');
                    if (mysqli_num_rows($select) > 0) {
                        $fetch = mysqli_fetch_assoc($select);
                    }
                    ?>
                    <h3>Name: <?php echo $fetch['name'] ?></h3>
                    <h3>Username: <?php echo $fetch['username'] ?></h3>
                    <h3>Date of Birth: <?php echo $fetch['DateOfBirth'] ?></h3>
                    <h3>Address: <?php echo $fetch['Address'] ?></h3>
                    <h3>Phone Number: <?php echo $fetch['PhoneNumber'] ?></h3>
                    <h3>Email: <?php echo $fetch['email'] ?></h3>
                    <h3>Campus: <?php echo $fetch['campus'] ?></h3>
                    <h3>Position: <?php echo $fetch['user_type'] ?></h3>
                    <h3>Semester: <?php echo $fetch['activity_semester'] ?></h3>
                    <a href="EditAdminProfile.php" id="button-t" class="btn btn-primary">update profile</a>
                    <a href="logout.php" id="button-t" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
</body>

</html>