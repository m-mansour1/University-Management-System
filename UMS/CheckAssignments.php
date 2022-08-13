<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['student_name'])) {
    $st_id = $_SESSION['student_id'];
    echo $_SESSION['student_name'];
    echo $_SESSION['student_id'];
    header('location:login_form.php');
}

if (isset($_GET["name"])) {
    $name = $_GET["name"];
    $sql =  "SELECT `file` FROM `examination` WHERE course_name='$name'";
    $res = $conn->query($sql);
    if (mysqli_num_rows($res) > 0) {
        $array = mysqli_fetch_array($res);
    }
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
    <title>Submit Assignments</title>
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

        h2 {
            font-weight: bold;
        }

        body {
            overflow: scroll;

        }
    </style>
    <?php include('StudentSidebar.php'); ?>
    <div class="home_content">
        <?php
        $course_id = $_GET["id"];
        $course_name = $_GET["name"];
        $Allcourses='';
        $courses = "SELECT * FROM `courses` WHERE id='$course_id'";

        $allcourses = mysqli_query($conn, $courses);

        if (mysqli_num_rows($allcourses) > 0) {
            $Allcourses = mysqli_fetch_array($allcourses);
        }
        ?>
        <h2>Assignments in <?php echo$Allcourses['name'] ?></h2>
        <div class="row">
            <?php
            $course_id = $_GET["id"];
            $sql = "SELECT * FROM examination WHERE course_name='$course_name'";
            $result = mysqli_query($conn, $sql);

            ?>
            <div class="col-xs-8 col-xs-offset-2">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>File Name</th>
                            <th>Document Type</th>
                            <th>View</th>
                            <th>Download</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_array($result)) { ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row['file']; ?></td>
                                    <td><?php echo $row['type']; ?></td>
                                    <td><a href="upload/<?php echo $row['file']; ?>" target="_blank">View</a></td>
                                    <td><a href="upload/<?php echo $row['file']; ?>" download>Download</td>
                                </tr>
                        <?php }
                        }else{
                            echo "<tr><td colspan=4>Hoorray No assignments for today!</td></tr>";
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>