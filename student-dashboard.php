<?php
include "scripts/db_conn.php";
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: index.html");
}
// Fetch student details
$student_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT s.user_name, GROUP_CONCAT(c.course_id SEPARATOR ', ') AS course_ids, GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses, GROUP_CONCAT(t.user_name SEPARATOR ', ') AS teachers
                        FROM students s
                        LEFT JOIN student_courses sc ON s.student_id = sc.student_id
                        LEFT JOIN courses c ON sc.course_id = c.course_id
                        LEFT JOIN teachers t ON c.teacher_id = t.teacher_id
                        WHERE s.student_id = ?
                        GROUP BY s.student_id");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="styles/manage-style.css">
    <link rel="icon" type="image/x-icon" href="asset/img/icon.png">
    <style>
        /* Hide the course list section initially */
        #course-list-wrapper {
            display: none;
        }
    </style>
</head>
<body id="stud-dash">
    <header>
        <div class="logo"><img src="asset/img/enode-logo.png" alt="" width="123px" height="50px" id="logo"></div>
        <nav>
            <ul>
                <li><a href="scripts/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <aside>
            <h2>Profile</h2>
            <p>Name: <?php echo isset($student['user_name']) ? htmlspecialchars($student['user_name']) : 'N/A'; ?></p>
            <p>Student ID: S-<?php echo $student_id; ?></p>
            <p>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>

            <h2>Quick Access</h2>
            <button id="gradeList" class="sideBtn">Grade List</button><br>
            <button id="viewCourseListBtn" class="sideBtn">Course List</button><br>

            <h2>Settings</h2>
            <button class="sideBtn" onclick="document.location='change-settings-stud.php'">Change Password</button>
        </aside>

        <div class="dashboard-content" id="dashboard">
    <div class="welcome-message">
        <h2>Welcome,  <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['username']; }?>!</h2>
        <p>Here's what's happening today:</p>
    </div>
    <div class="quick-stats">
        <div class="stat-item">
            <h3>Students Count</h3>
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
            <h3>Courses Enrolled</h3>
            <p>
                <?php
                    $query = "SELECT COUNT(*) AS total FROM student_courses WHERE student_id = $student_id";
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
            <h3>Teachers Count</h3>
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
            <li>Presentation- June 15</li>
        </ul>
    </div>
    <div class="announcements">
        <h3>Announcements</h3>
        <p>Summer break starts on June 17</p>
    </div>
</div>

        <!-- Help Icon -->
        <div id="help-icon">&#x3F;</div>

        <!-- Help Modal -->
        <div id="help-modal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>How to Navigate the Site</h2>
                <hr>
                <p><strong>Dashboard:</strong> View announcements and other events.</p>
                <p><strong>Grade List:</strong> Click the "Grade List" button to view your grades.</p>
                <p><strong>Course List:</strong> Click the "Course List" button to see the courses you are enrolled in.</p>
                <p><strong>Change Password:</strong> Click the "Change Password" button to update your password.</p>
                <p><strong>Logout:</strong> Click "Logout" in the navigation bar to sign out.</p>
            </div>
        </div>

        <section id="table-wrapper" class="dashboard-content" style="margin-left: 50px;">
            <h2>Grade List</h2>
            <table class="fl-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Professor</th>
                        <th>Prelim</th>
                        <th>Midterm</th>
                        <th>Finals</th>
                        <th>Overall Grade</th>
                        <th>GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch student courses and their professors
                    $stmt = $conn->prepare("SELECT c.course_id, c.course_name, t.user_name AS professor
                                            FROM student_courses sc
                                            JOIN courses c ON sc.course_id = c.course_id
                                            JOIN teachers t ON c.teacher_id = t.teacher_id
                                            WHERE sc.student_id = ?");
                    $stmt->bind_param("i", $student_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['course_id']}</td>";
                        echo "<td>{$row['course_name']}</td>";
                        echo "<td>{$row['professor']}</td>";

                        // Fetch grades for the current course
                        $course_id = $row['course_id'];
                        $stmt_grades = $conn->prepare("SELECT prelim_grade, midterm_grade, final_grade, overall_grade 
                                                        FROM grades 
                                                        WHERE student_id = ? AND course_id = ?");
                        $stmt_grades->bind_param("is", $student_id, $course_id);
                        $stmt_grades->execute();
                        $result_grades = $stmt_grades->get_result();
                        if ($row = $result_grades->fetch_assoc()) {
                            // Grades exist for this course
                            echo "<td>{$row['prelim_grade']}</td>";
                            echo "<td>{$row['midterm_grade']}</td>";
                            echo "<td>{$row['final_grade']}</td>";
                            echo "<td>{$row['overall_grade']}</td>";
                            $gpa = '';
                            if ($row['overall_grade'] >= 99) {
                                $gpa = '1.00';
                            } elseif ($row['overall_grade'] >= 96) {
                                $gpa = '1.25';
                            } elseif ($row['overall_grade'] >= 93) {
                                $gpa = '1.50';
                            } elseif ($row['overall_grade'] >= 90) {
                                $gpa = '1.75';
                            } elseif ($row['overall_grade'] >= 87) {
                                $gpa = '2.00';
                            } elseif ($row['overall_grade'] >= 84) {
                                $gpa = '2.25';
                            } elseif ($row['overall_grade'] >= 81) {
                                $gpa = '2.50';
                            } elseif ($row['overall_grade'] >= 78) {
                                $gpa = '2.75';
                            } elseif ($row['overall_grade'] >= 75) {
                                $gpa = '3.00';
                            } else {
                                $gpa = '5.00';
                            }
                            echo "<td>$gpa</td>";
                            echo "</tr>";
                        } else {
                            // No grades yet for this course
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                            echo "<td>-</td>";
                        }
                        echo "</tr>";
                        $stmt_grades->close();
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </section>

        <section id="course-list-wrapper" class="dashboard-content" style="margin-left: 50px;">
            <h2>Course List</h2>
            <table class="fl-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Professor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($student['courses']) && $student['courses']) {
                        $courses = explode(', ', $student['courses']);
                        $course_ids = explode(', ', $student['course_ids']);
                        $teachers = explode(', ', $student['teachers']);
                        foreach ($courses as $index => $course) {
                            echo "<tr>";
                            echo "<td>{$course_ids[$index]}</td>";
                            echo "<td>{$course}</td>";
                            echo "<td>{$teachers[$index]}</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No courses assigned.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        document.getElementById('viewCourseListBtn').addEventListener('click', function() {
            document.getElementById('table-wrapper').style.display = 'none';
            document.getElementById('course-list-wrapper').style.display = 'block';
        });

        document.getElementById('gradeList').addEventListener('click', function() {
            document.getElementById('table-wrapper').style.display = 'block';
            document.getElementById('course-list-wrapper').style.display = 'none';
        });
        // Get the modal
        var modal = document.getElementById("help-modal");
        var btn = document.getElementById("help-icon");
        var span = document.getElementsByClassName("close")[0];
        btn.onclick = function() {
            modal.style.display = "block";
        }
        span.onclick = function() {
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

    </script>
</body>
</html>