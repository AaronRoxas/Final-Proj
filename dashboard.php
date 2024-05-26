<?php
include "scripts/db_conn.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="styles/manage-style.css">
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
    <main>
        <aside>
            <ul>
                <h2>Profile</h2>
                <p>Name: <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['username']; } ?></p>
                <p>Teacher ID: T-<?php echo $_SESSION['user_id']; ?></p>
                <p>Email: <?php echo $_SESSION['user_email']; ?></p>
                <h2>Settings</h2>
                <p><a href="#">Change Password</a></p>
                <p><a href="#">Update Email</a></p>
            </ul>
        </aside>

        <section id="courses" class="content">
            <h2>Courses</h2>
            <button onclick="showCourseForm()">Add Course</button>
            <form id="courseForm" action="scripts/add_course.php" method="POST" style="display: none;">
                <input type="text" name="course_name" placeholder="Course Name" required>
                <input type="text" name="course_id" placeholder="Course ID" required>
                <button type="submit">Add Course</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Course ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="courseList">
                    <?php
                    // Fetch courses from the database
                    $teacher_id = $_SESSION['user_id'];
                    $stmt = $conn->prepare("SELECT course_id, course_name FROM courses WHERE teacher_id = ?");
                    $stmt->bind_param("i", $teacher_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['course_name']}</td>
                                <td>{$row['course_id']}</td>
                                <td>
                                <form action='scripts/delete_course.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='course_name' value='{$row['course_name']}'>
                                <div class =\"delete\"><button type='submit' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</button></div>


                                </td>
                              </tr>
                              </form>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </section>
        <section id="students" class="content">
            <h2>Students</h2>
            <button onclick="showStudentForm()">Assign Student to Course</button>
            <form id="studentForm" action="scripts/assign_student.php" method="POST" style="display: none;">
                <select name="student_id" required>
                    <option value="">Select Student</option>
                    <?php
                    // Fetch students from the database
                    $stmt = $conn->prepare("SELECT student_id, user_name FROM students");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value=\"{$row['student_id']}\">{$row['user_name']}</option>";
                    }
                    $stmt->close();
                    ?>
                </select>
                <select name="course_id" required>
                    <option value="">Select Course</option>
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
                <button type="submit">Assign Student</button>
            </form>
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
                    $stmt = $conn->prepare("SELECT s.student_id, s.user_name, c.course_name, c.course_id
                                            FROM students s
                                            LEFT JOIN student_courses sc ON s.student_id = sc.student_id
                                            LEFT JOIN courses c ON sc.course_id = c.course_id");
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $currentStudentId = null;
                    $firstRow = true;
                    while ($row = $result->fetch_assoc()) {
                        if ($currentStudentId !== $row['student_id']) {
                            if (!$firstRow) {
                                echo "</td><td>
                                        <form action='scripts/delete_student_course.php' method='POST' style='display:grid; place-items:center;'>
                                            <input type='hidden' name='student_id' value='$currentStudentId'>
                                            <input type='text' name='course_id' placeholder='Enter Course ID to remove'>
                                            <div class='delete' style='margin-top:7px;'><button type='submit' name='submit'>Remove</button></div>
                                        </form>
                                      </td></tr>";
                            }
                            echo "<tr>
                                    <td>{$row['user_name']}</td>
                                    <td>";
                            $currentStudentId = $row['student_id'];
                            $firstRow = false;
                        } else {
                            echo ", ";
                        }
                        echo "{$row['course_name']}";
                    }
                    if ($currentStudentId !== null) {
                        echo "</td><td>
                                <form action='scripts/delete_student_course.php' method='POST' style='display:grid; place-items:center;'>
                                    <input type='hidden' name='student_id' value='$currentStudentId'>
                                    <input type='text' name='course_id' placeholder='Enter Course ID to remove' >
                                    <div class='delete' style='margin-top:7px;'><button type='submit' name='submit'>Remove</button></div>
                                </form>
                              </td></tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>

    <script>
        function showCourseForm() {
            document.getElementById('courseForm').style.display = 'block';
        }

        function showStudentForm() {
            document.getElementById('studentForm').style.display = 'block';
        }
    </script>
</body>
</html>
