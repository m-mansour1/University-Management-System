<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['faculty_name'])) {
    echo $_SESSION['faculty_name'];
    echo $_SESSION['faculty_id'];
    header('location:login_form.php');
}
$course_name = "";
$file = "";
$exam = '';
$file_loc = "";
$file_size = "";
$file_type = "";
$folder = "";
$new_size = "";
$new_file_name = "";
$sql = '';
$final_file = "";
if (isset($_POST['submit'])) {
    $st_id = $_SESSION['faculty_id'];
    $course_name = $_POST['course_name'];
    $exam = $_POST['exam'];

    $file = rand(1000, 100000) . "-" . $_FILES['file']['name'];
    $file_loc = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $folder = "upload/";
    $new_size = $file_size / 1024;

    $new_file_name = strtolower($file);
    $final_file = str_replace(' ', '-', $new_file_name);

    do {
        if (
            empty($course_name) || empty($file) || empty($exam)
        ) {
            $errorMessage = "all fields are required ";
            break;
        }

        $select = "SELECT * FROM `examination`  WHERE course_name = '$course_name' && type='$exam'";
        $result = mysqli_query($conn, $select);
        if (mysqli_num_rows($result) > 0) {
            $errorMessage = "A/An " . $exam . " has already been uploaded for this course";
            break;
        }

        if (move_uploaded_file($file_loc, $folder . $final_file)) {
            $sql = "INSERT INTO `examination`(`id`,`course_name`, `file`, `type`)
             VALUES (NULL,'$course_name','$final_file','$exam')";
            mysqli_query($conn, $sql);
            $successMessage = 'Document has been sent successfully!';
            break;
        }
        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } while (false);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Upload Assignment</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>

<body>
    <?php include('InstructorSidebar.php');
    ?>
    <style>
        body {
            overflow: scroll;
        }
    </style>
    <br>
    <div class="home_content">
        <style>
            body {
                overflow: scroll;
            }
        </style>
        <div class="container my-5">
            <h2>Upload Assignment</h2>
            <br>
            <?php
            if (!empty($errorMessage)) {
                echo " <div class='alert alert-warning' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
            ?>
            <form method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Course
                    </label>
                    <div class="col-sm-6">
                        <?php
                        $st_id = $_SESSION['faculty_id'];
                        $sql = "SELECT * FROM users WHERE id=$st_id";

                        $UserName = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($UserName) > 0) {
                            $username = mysqli_fetch_array($UserName);
                        }
                        $Courses = "SELECT * FROM courses WHERE instructor='$username[username]'";
                        $allcourses = mysqli_query($conn, $Courses);
                        ?>
                        <select name='course_name' class='form-control'>
                            <?php

                            while ($row = $allcourses->fetch_assoc()) {

                                echo " 
                                    <option>$row[name]</option>
                                    ";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Examination File
                    </label>
                    <div class="col-sm-6">
                        <input type="file" class="form-control" name="file" value="<?php echo $exam_type; ?>">
                    </div>
                </div>
                <br>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Type
                    </label>

                    <div class="col-sm-6">
                        <select name="exam" class="form-control">
                            <option>Assignment</option>
                            <option>Miderm</option>
                            <option>Final</option>
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
                        <button type="submit" name="submit" class="btn  btn-primary">Upload</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <?php
                $sql = "SELECT * FROM examination WHERE course_name='$course_name'";
                $result = mysqli_query($conn, $sql);

                ?>
                <div class="col-xs-8 col-xs-offset-2">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>File Name</th>
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
                                        <td><?php echo $row['course_name']; ?></td>
                                        <td><a href="upload/<?php echo $row['file']; ?>" target="_blank">View</a></td>
                                        <td><a href="upload/<?php echo $row['file']; ?>" download>Download</td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>