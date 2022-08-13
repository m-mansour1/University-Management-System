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
$id="";
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	if(!isset($_GET["id"])){
		header("location:/UMS/semester.php");
		exit;
	}
	$id=$_GET["id"];
    $name=$_GET["name"];
    $sql="SELECT * FROM semester WHERE id='$id'";
	$result= mysqli_query($conn,$sql);
	$row=$result->fetch_assoc();
	if(!$row){
		header("location:/UMS/semester.php");
		exit;
	}
}else{
    $id=$_POST["id"];
	$name=$_POST["SemesterName"];
    do{
        if(empty($name)){
            $errorMessage="A name is required";
            break;
        }
        $sql="UPDATE semester SET name='$name' WHERE id= $id;";
        $result = mysqli_query($conn, $sql);
        if(!$result){
            $errorMessage="Invalid query: " .$conn->error;
            break;
        }
        $successMessage="Semester Modified successfully";
    }while(false);
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
        <div class="container my-5">
            <h2>Update semester</h2>
            <?php
            if (!empty($errorMessage)) {
                echo " <div class='alert alert-warning' role='alert'>
                <strong>$errorMessage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            }
            ?>
            <form method="POST">
				<input type="hidden" name="id" value="<?php echo $id;?>">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Name
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="SemesterName" value="<?php echo $name; ?>">
                    </div>
                </div>

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
                        <a class="btn btn-outline-primary" href="/UMS/semester.php" role="button">Cancel</a>
                    </div>
                </div>
            </form>
        </div>




</body>

</html>