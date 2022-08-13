
<div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <img name="image" height="50px" width="50px" src="images/anchor.png">
                <div class="logo_name">Lorem University</div>
            </div>
            <img name="menu" id="btn" src="images/menu.png">
        </div>
        <ul class="nav_list">
            <li class="input_container">
                <img class="bx-search" id="input_img" height="20px" width="20px" src="images/search.png">
                <input type="text" placeholder="Search">

                <span class="tooltip">Search</span>

            </li>
            <li>
                <a href="FacultyDashboard.php">
                    <img name="grid" height="20px" width="20px" src="images/grid.png">
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>

            </li>
            <li>
                <a href="Attendance.php">
                    <img name="grid" height="20px" width="20px" src="images/stats.png">
                    <span class="links_name">Attendance</span>
                </a>
                <span class="tooltip">Attendance</span>

            </li>
            <li>
                <a href="MyProfile.php">
                    <img name="grid" height="20px" width="20px" src="images/admin.png">
                    <span class="links_name">My Profile</span>
                </a>
                <span class="tooltip">My Profile</span>

            </li>
            <li>
                <a href="MyStudents.php">
                    <img name="grid" height="20px" width="20px" src="images/user.png">
                    <span class="links_name">My Students</span>
                </a>
                <span class="tooltip">My Students</span>

            </li>
            <li>
                <a href="UploadGrades.php">
                    <img name="grid" height="20px" width="20px" src="images/folder.png">
                    <span class="links_name">Upload Grades</span>
                </a>
                <span class="tooltip">Upload Grades</span>
            </li>
            <li>
                <a href="MyCourses.php">
                    <img name="grid" height="20px" width="20px" src="images/courses.png">
                    <span class="links_name">My Courses</span>
                </a>
                <span class="tooltip">My Courses</span>
            </li>
            <li>
                <a href="SendAssignments.php">
                    <img name="grid" height="20px" width="20px" src="images/semester.png">
                    <span class="links_name">Assignments</span>
                </a>
                <span class="tooltip">Assignments</span>

            </li>
            <li>
                <a href="ReceiveAssignments.php">
                    <img name="grid" height="20px" width="20px" src="images/cog.png">
                    <span class="links_name">Submitted Assignments</span>
                </a>
                <span class="tooltip">Submitted Assignments</span>

            </li>
            <li>
                <a href="lau/www.WhatIBroke.com_/index1.php">
                    <img name="grid" height="20px" width="20px" src="images/calendar.png">
                    <span class="links_name">Calendar</span>
                </a>
                <span class="tooltip">Calendar</span>

            </li>
            
        </ul>

        <script>
            let btn = document.querySelector("#btn");
            let sidebar = document.querySelector(".sidebar");
            let searchBtn = document.querySelector(".bx-search");
            btn.onclick = function() {
                sidebar.classList.toggle("active");
            }
            searchBtn.onclick = function() {
                sidebar.classList.toggle("active");
            }
        </script>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="images/user.png" height="20px" width="20px" alt="" class="">
                    <div class="name_job">
                        <div class="name"><?php echo $_SESSION['faculty_name'] ?></div>
                        <div class="job"><?php echo $_SESSION['faculty_job'] ?></div>
                    </div>
                </div>
                <a href="logout.php">
                    <img src="images/logout.png" id="log_out" height="20px">
                </a>
            </div>
        </div>
    </div>