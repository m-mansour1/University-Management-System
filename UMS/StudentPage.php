<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['student_name'])) {
    echo $_SESSION['student_name'];
    header('location:login_form.php');
}

$result = "";
$sql = "";
$sql = "SELECT count(*) id from users WHERE user_type='faculty';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    $res = mysqli_fetch_array($result);
}
$sql = "SELECT count(*) id from users WHERE user_type='student';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    $stds = mysqli_fetch_array($result);
}
$sql = "SELECT count(*) id from users WHERE user_type='admin';";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    $adm = mysqli_fetch_array($result);
}
$sql = "SELECT count(*) id from courses;";
$result = $conn->query($sql);
if (mysqli_num_rows($result) > 0) {
    $courses = mysqli_fetch_array($result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Faculty</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style2.css">
</head>

<body>
    <?php include('StudentSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <style>
        body {
            overflow: scroll;
            background: #1d1b31;
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
        h1,h3{
            color: #fff;
        }
    </style>
    <div class="home_content">
        <div class="text">
            <div class="content" id="dashboard">
                <h1><span>Dashboard</span></h1>
                <h3>welcome <span><?php echo $_SESSION['student_name'] ?></h3>
            </div>
            <center>
                <div class="parent">
                    <div class="child">
                        <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                            <div class="card-">
                                <h2>Instructors</h2>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <p class="card-text"><b><?php echo $res["id"]; ?> </b> faculty members are required to fully participate in the teaching program and to supervise undergraduate student research.</p>

                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <h2>Admins</h2>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <p class="card-text"><b><?php echo $adm["id"] ?> </b> active admins who perform data entry and ensur that the required materials are delivered to the worksite.</p>

                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="card text-white bg-warning mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <h2>Courses</h2>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <p class="card-text"><b><?php echo $courses["id"] ?></b> Courses given that helps brushing up skills and expanding horizons by gaining knowledge with great potential.</p>

                            </div>
                        </div>
                    </div>
                    <div class="child">
                        <div class="card text-white bg-info mb-3" style="max-width: 18rem;">
                            <div class="card-header">
                                <h2>Students</h2>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"></h5>
                                <p class="card-text">There are <b><?php echo $stds["id"]; ?></b> highly motivated, creative, and dedicated students that are currently enrolled in computer science classes.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </center>
            <div class="card-group">
                <div class="card">
                    <img >
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="card-text">Campuses Internationally available inside and outside Lebanon to provide the best learning experience to its students, and to enable their access to great opportunities</p>
                        <p class="card-text"><small class="text-muted"></small></p>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>