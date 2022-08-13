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
    <title>Courses</title>
    <link rel="stylesheet" href="css/style2.css">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

</head>

<body>
    <?php include('StudentSidebar.php'); ?>
    <!--END OF THE SIDEBAR-->
    <div class="home_content">
        <div class="container my-5">
            <h2>Course Offerings</h2>
            <br>
            <style>
                body {
                    overflow: scroll;
                }
            </style>
            <div class="col-sm-6">
                <?php
                $query = "SELECT * FROM `semester`";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    $options = mysqli_fetch_all($result, MYSQLI_ASSOC);
                }
                ?>

            </div>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="search" onkeyup="myFunction()" placeholder="Search for names..">
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
                            td = tr[i].getElementsByTagName("td")[0];
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
            </div>
            <table class="table" id="table">
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Code</th>
                        <th>Start Time</th>
                        <th>End Time</th>
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
                        <td>$row[name]</td>
                        <td>$row[code]</td>
                        <td>$row[startDate]</td>
                        <td>$row[endDate]</td>
                        <td>$row[semester]</td>
                        <td>$row[instructor]</td>
                        <td>$row[credits]</td>
                        <td>$row[capacity]</td>
                        <td>$row[classroom]</td>
                        <td>$row[campus]</td>
                    </tr>";
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
</body>

</html>