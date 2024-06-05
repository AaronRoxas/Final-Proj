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
            <h2>Profile</h2>
            <p>Name: <?php if(isset($_SESSION['user_email'])){ echo $_SESSION['username']; } ?></p>
            <p>Teacher ID: T-<?php echo $_SESSION['user_id']; ?></p>
            <p>Email: <?php echo $_SESSION['user_email']; ?></p>
            <ul>
                <h2>Settings</h2>
                <p><a href="#">Change Password</a></p>
                <p><a href="#">Update Email</a></p>
            </ul>
        </aside>

        <section id="courses" class="content">
            <h2>Courses Managed</h2>
            <button id="addCourseBtn">Add Course</button>
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
                                        <input type='hidden' name='course_id' value='{$row['course_id']}'>
                                        <div class =\"delete\"><button type='submit' onclick='return confirm(\"Are you sure you want to delete this course?\")'>Delete</button></div>
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
    <button onclick="addStudentBtn()" id="addStudentBtn">Assign Student to Course</button>
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
            $stmt = $conn->prepare("SELECT s.student_id, s.user_name, GROUP_CONCAT(c.course_name SEPARATOR ', ') AS courses 
                                    FROM students s 
                                    LEFT JOIN student_courses sc ON s.student_id = sc.student_id 
                                    LEFT JOIN courses c ON sc.course_id = c.course_id 
                                    GROUP BY s.student_id");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['user_name']}</td>
                        <td>{$row['courses']}</td>
                        <td>
                            <form action='scripts/delete_student_course.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='student_id' value='{$row['student_id']}'>
                                <select name='course_id' required>
                                    <option value=''>Select Course to Remove</option>";
                                    $courseArray = explode(', ', $row['courses']);
                                    foreach ($courseArray as $courseName) {
                                        echo "<option value='$courseName'>$courseName</option>";
                                    }
                                echo "</select>
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
       <!-- GRADES SECTION  -->
    <section id="grades" class="content">
    <h2>Grades</h2>
    <?php
    if(isset($_GET['error']) && $_GET['error'] == 'course_not_assigned'){
        echo "<p style='color: red;'>Course is not assigned to student!</p>";
    }
    ?>
    <button onclick="addGradeBtn()" id="addGradeBtn">Add Grades</button>
    
    <table>
        <thead>
            <tr>
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
            // Fetch grades from the database
            $stmt = $conn->prepare("SELECT s.user_name, c.course_name, g.prelim_grade, g.midterm_grade, g.final_grade, g.overall_grade 
                                    FROM grades g 
                                    JOIN students s ON g.student_id = s.student_id 
                                    JOIN courses c ON g.course_id = c.course_id");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['user_name']}</td>
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

    <!-- Add Grade Modal -->
    <div id="addGradeModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Grade</h2>
        <form id="addGradeForm" action="scripts/add_grade.php" method="POST">
        <div class="input-box">
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
        </div>    
        <div class="input-box">
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
        </div>
            <div class="input-box"> <input type="number" name="prelim_grade" placeholder="Prelim Grade" required step="0.01"></div>
            <div class="input-box"><input type="number" name="midterm_grade" placeholder="Midterm Grade" required step="0.01"></div>
            <div class="input-box"><input type="number" name="final_grade" placeholder="Final Grade" required step="0.01"></div>
            <div class="input-box"><input type="submit" value="Add Grade" id="button"></div>
           
            
            
            
        </form>
    </div>
</div>

<!-- Add Student Modal -->
<div id="addStudentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Add Student</h2>
        <form id="studentForm" action="scripts/assign_student.php" method="POST">
        <div class="input-box">
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
        </div>
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

        <div class="input-box"><input type="submit" value="Assign Student" id="button"></div>
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


</main>
    
<script>
    function showCourseForm() {
    document.getElementById('courseForm').style.display = 'grid';
}

function showStudentForm() {
    document.getElementById('studentForm').style.display = 'block';
}
function showGradeForm() {
    document.getElementById('gradeForm').style.display = 'block';
}
function hideGradeForm() {
    document.getElementById('gradeForm').style.display = 'none';
}

// Get the modals
var addGradeModal = document.getElementById('addGradeModal');
var addStudentModal = document.getElementById('addStudentModal');
var addCourseModal = document.getElementById('addCourseModal');

// Get the buttons that open the modals
var addGradeBtn = document.getElementById('addGradeBtn');
var addStudentBtn = document.getElementById('addStudentBtn');
var addCourseBtn = document.getElementById('addCourseBtn');

// Get the <span> elements that close the modals
var gradeSpan = document.getElementsByClassName('close')[0];
var studentSpan = document.getElementsByClassName('close')[1];
var courseSpan = document.getElementsByClassName('close')[2];

// When the user clicks the button, open the modal 
addGradeBtn.onclick = function() {
    addGradeModal.style.display = "block";
}

addStudentBtn.onclick = function() {
    addStudentModal.style.display = "block";
}

addCourseBtn.onclick = function() {
    addCourseModal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
gradeSpan.onclick = function() {
    addGradeModal.style.display = "none";
}

studentSpan.onclick = function() {
    addStudentModal.style.display = "none";
}

courseSpan.onclick = function() {
    addCourseModal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == addGradeModal) {
        addGradeModal.style.display = "none";
    } else if (event.target == addStudentModal) {
        addStudentModal.style.display = "none";
    } else if (event.target == addCourseModal) {
        addCourseModal.style.display = "none";
    }
}

</script>

</body>
</html>