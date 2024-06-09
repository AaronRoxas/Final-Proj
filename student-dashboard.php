<?php
include "scripts/db_conn.php";
session_start();

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
            <p>Name: <?php echo $student['user_name']; ?></p>
            <p>Student Number: S-<?php echo $student_id ?></p>
            <p>Email: <?php echo $_SESSION['user_email']?></p>
        </aside>

        <section id="table-wrapper" class="content">
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
                        if ($row_grades = $result_grades->fetch_assoc()) {
                            // Grades exist for this course
                            echo "<td>{$row_grades['prelim_grade']}</td>";
                            echo "<td>{$row_grades['midterm_grade']}</td>";
                            echo "<td>{$row_grades['final_grade']}</td>";
                            echo "<td>{$row_grades['overall_grade']}</td>";
                        } else {
                            // No grades yet for this course
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
    </main>
</body>
</html>
