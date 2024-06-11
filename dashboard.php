<?php
include "scripts/db_conn.php";
session_start();
if (isset($_SESSION['grades'])) {
    unset($_SESSION['grades']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="styles/manage-style.css">
    <link rel="icon" type="image/x-icon" href="asset/img/icon.png">
</head>
<body>

    <header>
        <div class="logo"><img src="asset/img/enode-logo.png" alt="" width="123px" height="50px" id="logo"></div>
        <nav>
            <ul>
                <li><a href="scripts/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <!-- POPUP ALERTS -->
    <?php
    if (isset($_GET['message'])) {
        switch ($_GET['message']) {
            case 'student_assigned':
            case 'course_added':
            case 'all_students_assigned':
            case 'grade_added':
                echo "
                <script>
                    window.onload = function() {
                        showSuccessAlert();
                    };
                </script>";
                break;
            
            case 'pass_changed':
                echo "
                <script>
                    window.onload = function() {
                        passSuccessAlert();
                    };
                </script>";
                break;
    
            case 'course_removed':
                echo "
                <script>
                    window.onload = function() {
                        showRemoveAlert();
                    };
                </script>";
                break;
    
            case 'no_grades_found':
                echo "
                <script>
                    window.onload = function() {
                        showNothingFoundAlert();
                    };
                </script>";
                break;
            case "not_assigned":
                echo " <script>
                        window.onload = function() {
                            showNoPermAlert();
                        };
                    </script>";
                    break;
        }
    }
    
    if (isset($_GET['error']) && $_GET['error'] == 'no_students_found') {
        echo "
        <script>
            window.onload = function() {
                showRemoveAlert();
            };
        </script>";
    }

    
    ?>    
    <div class="alert success" id="successAlert">
        Added successfully!
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>

    <div class="alert passSuccess" id="passSuccessAlert">
        Changes Saved!
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>

    <div class="alert remove" id="removeAlert">
        Removed successfully!
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>

    <div class="alert nothing" id="nothingAlert">
        No grades found for the selected course.
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>

    <div class="alert noPerm" id="noPermAlert">
        You do not have permission for this!
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
    </div>
<!-- End of Alert contents -->


    <main>
        <!-- SIDEBAR CONTENTS -->
        <aside>
            <h2>Profile</h2>
            <p>Name: <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['username']; } ?></p>
            <p>Teacher ID: T-<?php echo $_SESSION['user_id']; ?></p>
            <p>Email: <?php echo $_SESSION['user_email']; ?></p>
            <ul>
                <h2>Settings</h2>
                <p><a href="change-settings.php">Change Password</a></p>
            </ul>

            <ul>
            <h2>Quick Access</h2>
                <button id="dashboardBtn" class="sideBtn">Dashboard</button><br>
                <button id="viewCourseListBtn" class="sideBtn">Course List</button><br>
                <button id="viewStudentListBtn"class="sideBtn">Student List</button><br>
            </ul>

        </aside>

    <div class="dashboard-content" id="dashboard">
    <div class="welcome-message">
        <h2>Welcome,  <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['username']; }?>!</h2>
        <p>Here's what's happening today:</p>
    </div>
    <div class="quick-stats">
        <div class="stat-item">
            <h3>Students</h3>
            <p>
                <?php
                    $query = "SELECT COUNT(*) AS total FROM students";
                    $rs = mysqli_query($conn, $query);

                    if ($rs) {
                        $row = mysqli_fetch_assoc($rs);
                        $count = $row['total'];
                        echo $count;
                    }
                ?>
            </p>
        </div>
        <div class="stat-item">
            <h3>Courses</h3>
            <p>
                <?php
                    $query = "SELECT COUNT(*) AS total FROM courses";
                    $rs = mysqli_query($conn, $query);

                    if ($rs) {
                        $row = mysqli_fetch_assoc($rs);
                        $count = $row['total'];
                        echo $count;
                    }
                ?>
            </p>
        </div>
        <div class="stat-item">
            <h3>Teachers</h3>
            <p>
                <?php
                    $query = "SELECT COUNT(*) AS total FROM teachers";
                    $rs = mysqli_query($conn, $query);

                    if ($rs) {
                        $row = mysqli_fetch_assoc($rs);
                        $count = $row['total'];
                        echo $count;
                    }
                ?>
                </p>
        </div>
    </div>

    <div class="upcoming-events">
        <h3>Upcoming Events</h3>
        <ul>
            <li>Final Exams - June 10 to June 14</li>
            <li>Presentation- June 13</li>
        </ul>
    </div>
    <div class="announcements">
        <h3>Announcements</h3>
        <p>Summer break starts on June 15</p>
    </div>
</div>

<!-- Grade List Section -->
<section class="dashboard-content" id="grade">
    <h2>Grades 
        <button onclick="addGradeBtn()" id="addGradeBtn" style="float:right;">Add Grades</button> 
        <button onclick="viewGradeCoursesBtn()" id="viewGradeCoursesBtn" style="float:right; margin-right:4px;">View Grades</button>
    </h2>
    <?php
    if (isset($_GET['error']) && $_GET['error'] == 'course_not_assigned') {
        echo "<p style='color: red;'>Course is not assigned to student!</p>";
    }
    ?>

    <!-- Grades Table -->
    <table>
        <thead>
            <tr>
                <th>Faculty Name</th>
                <th>Student Name</th>
                <th>Course</th>
                <th>Prelim</th>
                <th>Midterm</th>
                <th>Final</th>
                <th>Final Grade</th>
            </tr>
        </thead>
        <tbody id="gradeList">
            <?php
            if (isset($_POST['course_id'])) {
                $course_id = $_POST['course_id'];
                // Fetch grades and professor's name from the database for the selected course
                $stmt = $conn->prepare("SELECT s.user_name, c.course_name, g.prelim_grade, g.midterm_grade, g.final_grade, g.overall_grade, 
                                            (SELECT t.user_name FROM courses c2 JOIN teachers t ON c2.teacher_id = t.teacher_id WHERE c2.course_id = g.course_id) AS professor
                                        FROM grades g 
                                        JOIN students s ON g.student_id = s.student_id 
                                        JOIN courses c ON g.course_id = c.course_id
                                        WHERE g.course_id = ?");
                $stmt->bind_param("s", $course_id);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['professor']}</td>
                            <td>{$row['user_name']}</td>
                            <td>{$row['course_name']}</td>
                            <td>{$row['prelim_grade']}</td>
                            <td>{$row['midterm_grade']}</td>
                            <td>{$row['final_grade']}</td>
                            <td>{$row['overall_grade']}</td>
                            
                        </tr>";
                }
                $stmt->close();
            } else {
                // Display a message if no course is selected
                echo "<tr><td colspan='7'>Please select a course to view grades.</td></tr>";
            }
            ?>
</tbody>

    </table>
</section>



<!-- Courses Manage -->
<section class="dashboard-content" id="course-list">
    <?php
        include ("scripts/db_conn.php");
        // Fetch courses managed by the logged-in teacher
        $teacher_id = $_SESSION['user_id'];
        $stmt = $conn->prepare("SELECT course_id, course_name FROM courses WHERE teacher_id = ?");
        $stmt->bind_param("i", $teacher_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $managed_courses = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    ?>
    <h2>Courses Managed <button id="addCourseBtn" style="float: right;">Add Course</button></h2>
    <table class="content">
        <thead>
            <tr>
                <th>Course</th>
                <th>Course ID</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="courseList">
        <?php
            foreach ($managed_courses as $course) {
                echo "<tr>
                        <td>{$course['course_name']}</td>
                        <td>{$course['course_id']}</td>
                        <td>
                            <form action='scripts/delete_course.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='course_id' value='{$course['course_id']}'>
                                <div class =\"delete\"><button type='submit' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</button></div>
                            </form>
                        </td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
</section>


     <!-- View Student List Section -->
        <section class="dashboard-content" id="student-list">
                <h2>Students<button onclick="addStudentBtn()" id="addStudentBtn" style="float:right;">Assign Student to Subject</button> <button  onclick="assignToAllBtn()" id="assignToAllBtn" style="float:right; margin-right:4px;">Assign All Students to a Subject</button></h2>
                <table>
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Courses</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="studentList">
                        <?php
                        // Fetch students and their courses from the database
                        $stmt = $conn->prepare("SELECT s.student_id, s.user_lName, s.user_name, GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses 
                                                FROM students s 
                                                LEFT JOIN student_courses sc ON s.student_id = sc.student_id 
                                                LEFT JOIN courses c ON sc.course_id = c.course_id 
                                                GROUP BY s.student_id
                                                ORDER BY s.user_lName ASC");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['user_name']}</td>
                                    <td>{$row['courses']}</td>
                                    <td>
                                        <form action='scripts/delete_student_course.php' method='POST' style='display:inline;'>
                                            <input type='hidden' name='student_id' value='{$row['student_id']}'>
                                            <div class='input-box-table'><select name='course_id' required>
                                                <option value=''>Select Course to Remove</option>";
                                                $courseArray = explode(', ', $row['courses']);
                                                foreach ($courseArray as $courseName) {
                                                    echo "<option value='$courseName'>$courseName</option>";
                                                }
                                            echo "</select></div>
                                            <div class='delete'><button type='submit'>Remove Course</button></div>

                                    </form>
                                    </td>
                                </tr>";
                        }
                        if(isset($_GET['error']) && $_GET['error'] == 'course_already_assigned'){
                            echo "<p style='color:Tomato;'>Course Already Assigned!</p>";
                        };
                        $stmt->close();
                        ?>
                    </tbody>
                </table>
                
            </section>

    
    
    <!-- Add Grade Modal -->
    <div id="addGradeModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add Grade</h2>
            <form action="scripts/add_grade.php" method="POST">
                <div class="input-box">
                    <select name="student_id" required>
                        <option value="" disabled selected>Select Student</option>
                        <?php
                        // Fetch students from the database
                        $stmt = $conn->prepare("SELECT student_id, user_name FROM students ORDER BY user_lName ASC");
                        $stmt->execute();
                        $result = $stmt->get_result();
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value=\"{$row['student_id']}\">{$row['user_name']}</option>";
                        }
                        $stmt->close();
                        ?>
                    </select>
                </div>
                <div class="input-box">
                <select name="course_id" required>
                    <!-- List courses managed by the logged-in teacher -->
                    <option value="" disabled selected>Select Course</option>
                    <?php
                    foreach ($managed_courses as $course) {
                        echo "<option value=\"{$course['course_id']}\">{$course['course_name']}</option>";
                    }
                    ?>
                </select>
            </div>
                <div class="input-box">
                    <input type="number" name="prelim_grade" placeholder="Prelim Grade"min="0" max="100" required>
                </div>
                <div class="input-box">
                    <input type="number" name="midterm_grade" placeholder="Midterm Grade"min="0" max="100" required>
                </div>
                <div class="input-box">
                    <input type="number" name="final_grade" placeholder="Final Grade"min="0" max="100" required>
                </div>
                <div class="input-box">
                    <input type="submit" value="Add Grade" id="button">
                </div>
</form>

</div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Student</h2>
        <form action="scripts/assign_student.php" method="POST">
            <div class="input-box">
                <label for="student_id">Student:</label>
                <select name="student_id" required>
                    <!-- Fetch and list students from the database -->
                    <?php
                    $stmt = $conn->prepare("SELECT student_id, user_name FROM students ORDER BY user_lName ASC");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"{$row['student_id']}\">{$row['user_name']}</option>";
                    }
                    $stmt->close();
                    ?>
                </select>
            </div>
            <div class="input-box">
                <label for="course_id">Course:</label>
                <select name="course_id" required>
                    <!-- List courses managed by the logged-in teacher -->
                    <?php
                    foreach ($managed_courses as $course) {
                        echo "<option value=\"{$course['course_id']}\">{$course['course_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="input-box"><input type="submit" value="Assign Course" id="button"></div>
        </form>
    </div>
</div>

<!-- Add Course Modal -->
<div id="addCourseModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2 class="text-center">Add Course</h2>
        <form id="addCourseForm" action="scripts/add_course.php" method="POST">
            <div class="input-box"><input type="text" name="course_id" placeholder="Course ID" required></div>
            <div class="input-box"><input type="text" name="course_name" placeholder="Course Name" required></div>
            <div class="input-box"><input type="submit"value="Add Course"  id="button"></div>
            
        </form>
    </div>
</div>

<!-- Assign All Students to a course Modal -->

<div class="modal" id="assignToAllModal">
    <div class="modal-content">
    <span class="close">&times;</span>
        <h2>Assign Students</h2>
        <form id="studentForm" action="scripts/assign_all_students.php" method="POST">
        <div class="input-box">
                <label for="course_id">Course:</label>
                <select name="course_id" required>
                    <!-- List courses managed by the logged-in teacher -->
                    <?php
                    foreach ($managed_courses as $course) {
                        echo "<option value=\"{$course['course_id']}\">{$course['course_name']}</option>";
                    }
                    ?>
                </select>
            </div>

        <div class="input-box"><input type="submit" value="Assign Students" id="button"></div>
        </form>
    </div>
</div>

<!-- View Specific Grade Course Modal  -->
<div id="viewGradeCoursesModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>View Grades for Specific Course</h2>
            <!-- Form to select course -->
    <form action="dashboard.php" method="POST">
        <div class="input-box">
            <select name="course_id" required>
                <option value="" disabled selected>Select Course</option>
                <?php
                // Fetch courses from the database
                $stmt = $conn->prepare("SELECT course_id, course_name FROM courses");
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    echo "<option value=\"{$row['course_id']}\">{$row['course_name']}</option>";
                }
                $stmt->close();
                ?>
            </select>
        </div>
        <div class="input-box"><input type="submit" value="View Grades" id="button"></div>
    </form>
    </div>
</div>
</main>

<script src="script.js"></script>
</body>
</html>