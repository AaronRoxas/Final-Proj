<?php
include "scripts/db_conn.php";
session_start();

// Fetch student details
$student_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT s.user_name, GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses, GROUP_CONCAT(t.user_name SEPARATOR ', ') AS teachers
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
            <h2>Profile</h2>
            <p>Name: <?php echo $student['user_name']; ?></p>
            <p>Student Number: S-<?php echo $student_id ?></p>
            <p>Email: <?php echo $_SESSION['user_email']?></p>
            <ul>
                <h2>Settings</h2>
                <p><a href="#">Change Password</a></p>
                <p><a href="#">Update Email</a></p>
            </ul>
        </aside>

        <section id="courses" class="content">
            <h2>Courses</h2>
            <table>
                <thead>
                    <tr>
                        <th>Course Name</th>
                        <th>Professor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch student courses and their professors
                    $stmt = $conn->prepare("SELECT c.course_name, t.user_name AS professor
                                            FROM student_courses sc
                                            JOIN courses c ON sc.course_id = c.course_id
                                            JOIN teachers t ON c.teacher_id = t.teacher_id
                                            WHERE sc.student_id = ?");
                    $stmt->bind_param("i", $student_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['course_name']}</td>
                                <td>{$row['professor']}</td>
                              </tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </section>
        <section class="content">
            <h2>Grades</h2>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Prelim</th>
                        <th>Midterm</th>
                        <th>Finals</th>
                        <th>Final Grade</th>
                    </tr>
                </thead>
                <tbody id="gradeList">
                    <?php
                    // Fetch grades from the database
                    $stmt = $conn->prepare("SELECT s.user_name, c.course_name, g.prelim_grade, g.midterm_grade, g.final_grade, g.overall_grade 
                                            FROM grades g
                                            JOIN students s ON g.student_id = s.student_id
                                            JOIN courses c ON g.course_id = c.course_id
                                            WHERE s.user_name = ?");
                    $stmt->bind_param("s", $student['user_name']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['course_name']}</td>
                                <td>{$row['prelim_grade']}</td>
                                <td>{$row['midterm_grade']}</td>
                                <td>{$row['final_grade']}</td>
                                <td>{$row['overall_grade']}</td>
                            </tr>";
                    }
                    $stmt->close();
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>
</html>
