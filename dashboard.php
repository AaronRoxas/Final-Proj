<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard</title>
    <link rel="stylesheet" href="manage-style.css">
</head>
<body>
    <header>
        <div class="logo"> <img src="asset/img/enode-logo.png" alt="" width="123px" height="50px" id="logo"></div>
        <nav>
            <ul>
                <li><a href="logout.php">Logout</a></li>
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
            <p>Name: 
            <?php session_start();
                            if(isset($_SESSION['user_email'])){
                                echo $_SESSION['username'];}                
            ?></p>
            <p>Teacher ID: T-<?php echo $_SESSION['user_id']; ?></p>
            <p>Email: <?php echo $_SESSION['user_email']?> </p>
        </section>
        <section id="courses" class="content">
            <h2>Courses</h2>
            <button onclick="addCourse()">Add Course</button>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="courseList">
                    <tr>
                        <td>Algebra I</td>
                        <td>
                            <button onclick="editCourse(this)">Edit</button>
                            <button onclick="deleteCourse(this)">Delete</button>
                        </td>
                    </tr>
                    <!-- Add more courses as needed -->
                </tbody>
            </table>
        </section>
        <section id="students" class="content">
            <h2>Students</h2>
            <button onclick="addStudent()">Add Student</button>
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
                    <tr>
                        <td>John Doe</td>
                        <td>2022-2-1234</td>
                        <td>Algebra I</td>
                        <td>
                            <button onclick="editStudent(this)">Edit</button>
                            <button onclick="deleteStudent(this)">Delete</button>
                        </td>
                    </tr>
                    <!-- Add more students as needed -->
                </tbody>
            </table>
        </section>
        <section id="schedule" class="content">
            <h2>Schedule</h2>
            <ul>
                <li>Monday: Algebra I - 9:00 AM</li>
                <li>Tuesday: Biology - 10:00 AM</li>
                <li>Wednesday: World History - 11:00 AM</li>
                <li>Thursday: Art Appreciation - 1:00 PM</li>
            </ul>
        </section>

    </main>
    <footer>
        <p>&copy; 2024 School Name. All rights reserved.</p>
    </footer>

    <script>
        function addCourse() {
            // Add course logic here
            alert("Add Course button clicked");
        }

        function editCourse(button) {
            // Edit course logic here
            alert("Edit Course button clicked");
        }

        function deleteCourse(button) {
            // Delete course logic here
            alert("Delete Course button clicked");
        }

        function addStudent() {
            // Add student logic here
            alert("Add Student button clicked");
        }

        function editStudent(button) {
            // Edit student logic here
            alert("Edit Student button clicked");
        }

        function deleteStudent(button) {
            // Delete student logic here
            alert("Delete Student button clicked");
        }
    </script>
</body>
</html>
