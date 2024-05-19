<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
<link rel="stylesheet" href="styles/student-dash-style.css">
</head>
<body>
    <header>
        <div class="logo">Student Dashboard</div>
        <nav>
            <ul>

                <li><a href="scripts/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="profile" class="card">
            <h2>Profile</h2>
            <p>Name: <?php session_start(); echo $_SESSION['username']; ?></p>
            <p>Student ID: S-<?php echo $_SESSION['user_id']; ?></p>
            <p>Email: <?php echo $_SESSION['user_email']; ?></p>
        </section>
        <section id="courses" class="card">
            <h2>Courses</h2>
            <ul>
                <li>Mathematics</li>
                <li>Science</li>
                <li>History</li>
                <li>Art</li>
            </ul>
        </section>
        <section id="grades" class="card">
            <h2>Grades</h2>
            <table>
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Mathematics</td>
                        <td>A</td>
                    </tr>
                    <tr>
                        <td>Science</td>
                        <td>B+</td>
                    </tr>
                    <tr>
                        <td>History</td>
                        <td>A-</td>
                    </tr>
                    <tr>
                        <td>Art</td>
                        <td>B</td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section id="settings" class="card">
            <h2>Settings</h2>
            <p><a href="#">Change Password</a></p>
            <p><a href="#">Update Email</a></p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 School Name. All rights reserved.</p>
    </footer>
</body>
</html>
