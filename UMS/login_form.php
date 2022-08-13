<?php
@include 'config.php';
session_start();
if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $pass = md5($_POST['password']);
    $select = "SELECT * FROM users WHERE username = '$username' && password='$pass' ";
    $result = mysqli_query($conn, $select);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        if($row['user_type'] == 'admin'){
            $_SESSION['admin_name']=$row['name'];
            $_SESSION['admin_job']=$row['user_type'];
            $_SESSION['admin_id']=$row['id'];
            header('location:AdminPage.php');
        }elseif($row['user_type'] == 'student'){
            $_SESSION['student_name']=$row['name'];
            $_SESSION['student_job']=$row['user_type'];
            $_SESSION['student_id']=$row['id'];
            header('location:StudentPage.php');
        }elseif($row['user_type'] == 'faculty'){
            $_SESSION['faculty_name']=$row['name'];
            $_SESSION['faculty_job']=$row['user_type'];
            $_SESSION['faculty_id']=$row['id'];
            $_SESSION['Current_Semester']='SUMMER 2022';
            header('location:FacultyDashboard.php');
        }
    }else{
        $error[]='incorrect username or password';
    }
};
?>
<!Doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/register.css">
    <title>Login</title>
</head>

<body>
    <div class="form-container">
        <form action="" method="post">
            <h3>Log In</h3>
            <?php
            if(isset($error)){
                foreach($error as $error){
                    echo '<span class="error-msg">'.$error.'</span>';
                };
            };
             ?>
            <input type="text" name="username" required placeholder="Username">
            <input type="password" name="password" required placeholder="Password">
            <input type="submit" name="submit" value="Sign In" class="form-btn">
        </form>
    </div>
</body>

</html>