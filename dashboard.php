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
                <h2>Settings</h2>
                <p><a href="#">Change Password</a></p>
                <p><a href="#">Update Email</a></p>
            </ul>
        </aside>
        <section id="profile" class="content">
            <h2>Profile</h2>
            <p>Name: <?php include 'scripts/functions.php'; if(isset($_SESSION['user_email'])){ echo $_SESSION['username']; } ?></p>
            <p>Teacher ID: T-<?php echo $_SESSION['user_id']; ?></p>
            <p>Email: <?php echo $_SESSION['user_email']; ?></p>
        </section>
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
                 
                    include "scripts/db_conn.php";
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

                                <div class =\"delete\"><button type='submit' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</button><div>
                            </form>
                        </td>
                              </tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </section>
        <section id="students" class="content">
            <h2>Students</h2>
            <button onclick="showStudentForm()">Add Student</button>
            <!-- <form id="studentForm" action="add_student.php" method="POST" style="display: none;">
                <input type="text" name="student_name" placeholder="Student Name" required>
                <input type="text" name="student_id" placeholder="Student ID" required>
                <select name="course_id" required>
                    <option value="">Select Course</option>

                </select>
                <button type="submit">Add Student</button>
            </form> -->
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>ID</th>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="studentList">
                    <?php
                    // Fetch students from the database
                    $stmt = $conn->prepare("SELECT students.student_id, students.user_name, courses.course_name 
                                            FROM students 
                                            JOIN courses ON students.course_id = courses.course_id 
                                            WHERE courses.teacher_id = ?");
                    $stmt->bind_param("i", $teacher_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['user_name']}</td>
                                <td>{$row['course_name']}</td>
                                <td>
                                    <button onclick=\"deleteStudent({$row['student_id']})\">Delete</button>
                                </td>
                              </tr>";
                    }
                    $stmt->close();
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </section>

    </main>
    <footer>
        <p>&copy; 2024 School Name. All rights reserved.</p>
    </footer>

    <script>
        function showCourseForm() {
            document.getElementById('courseForm').style.display = 'block';
        }

        function showStudentForm() {
            document.getElementById('studentForm').style.display = 'block';
        }

        // Add more functions as needed for edit and delete actions
    </script>
</body>
</html>
