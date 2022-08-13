<?php
@include 'config.php';
session_start();
if (!isset($_SESSION['admin_name'])) {
    echo $_SESSION['admin_name'];
    header('location:login_form.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Courses</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Admins Data</title>
</head>

<body>
    <?php include('AdminSidebar.php'); ?>

    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>List of Courses</h2>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <a class="btn btn-primary" href="/UMS/createCourse.php" role="button">
                New Course
            </a>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="search" onkeyup="myFunction()" placeholder="Search for names..">
            </div>
            <script>
                function myFunction() {
                    // Declare variables
                    var input, filter, table, tr, td, i, txtValue;
                    input = document.getElementById("search");
                    filter = input.value.toUpperCase();
                    table = document.getElementById("table");
                    tr = table.getElementsByTagName("tr");

                    // Loop through all table rows, and hide those who don't match the search query
                    for (i = 0; i < tr.length; i++) {
                        td = tr[i].getElementsByTagName("td")[1];
                        if (td) {
                            txtValue = td.textContent || td.innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                }
            </script>
            <br>
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Semester</th>
                        <th>Instructor</th>
                        <th>Credits</th>
                        <th>Capacity</th>
                        <th>Classroom</th>
                        <th>Campus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM `courses`";
                    $result = $conn->query($sql);
                    if (!$result) {
                        die("Invalid query: " . $conn->error);
                    }
                    while ($row = $result->fetch_assoc()) {



                        echo "<tr>
                        <td>$row[id]</td>
                        <td>$row[name]</td>
                        <td>$row[startDate]</td>
                        <td>$row[endDate]</td>
                        <td>$row[semester]</td>
                        <td>$row[instructor]</td>
                        <td>$row[credits]</td>
                        <td>$row[capacity]</td>
                        <td>$row[classroom]</td>
                        <td>$row[campus]</td>
                        <td>
                        
                        <td>
                            <a class='btn btn-primary btn-sm' href='/UMS/EditCourse.php?id=$row[id]&name=$row[name]&code=$row[code]&semester=$row[semester]&instructor=$row[instructor]&credits=$row[credits]&capacity=$row[capacity]&classroom=$row[classroom]&campus=$row[campus]'>Edit</a>
                            <a class='btn btn-danger btn-sm' href='/UMS/DeleteCourse.php?id=$row[id]'>Delete</a>
                        </td>
                        </tr>";

                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>