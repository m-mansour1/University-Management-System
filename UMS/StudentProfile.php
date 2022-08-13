<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['student_name'])) {
    $st_id = $_SESSION['student_id'];
    echo $_SESSION['student_name'];
    echo $_SESSION['student_id'];
    header('location:login_form.php');
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
    <title>Student Data</title>
</head>

<body>
    <style>
        .profile-image {
            padding-top: 30px;
            padding-left: 50px;
            padding-bottom: 40px;
        }

        .profile {
            padding-left: 50px;
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

        h3 {
            color: #fff;
        }

        h2 {
            color: #fff;
            font-weight: bold;
        }

        body {
            overflow: scroll;
            background: #1d1b31;
        }
    </style>
    <?php include('StudentSidebar.php'); ?>
    <div class="home_content">
        <h2>Profile Information</h2>
        <div class="parent">
            <div class="child">
                <img src="images/user.png" height="315px" width="315px" alt="...">
            </div>

            <div class="child">
                <div class="profile">
                    <?php
                    $st_id = $_SESSION['student_id'];

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
                    <a href="update_student_profile.php" id="button-t" class="btn btn-primary">update profile</a>
                    <a href="logout.php" id="button-t" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>