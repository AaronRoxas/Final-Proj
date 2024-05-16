<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header .logo {
            margin-left: 20px;
            font-size: 1.5em;
        }

        header nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        header nav ul li {
            margin-right: 20px;
        }

        header nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 5px 10px;
        }

        header nav ul li a:hover {
            background-color: #575757;
            border-radius: 5px;
        }

        main {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            width: 300px;
        }

        .card h2 {
            margin-top: 0;
        }

        .card table {
            width: 100%;
            border-collapse: collapse;
        }

        .card table, th, td {
            border: 1px solid #ddd;
        }

        .card table th, .card table td {
            padding: 8px;
            text-align: left;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #333;
            color: #fff;
            position: absolute;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">Student Dashboard</div>
        <nav>
            <ul>
                <li><a href="#profile">Profile</a></li>
                <li><a href="#courses">Courses</a></li>
                <li><a href="#grades">Grades</a></li>
                <li><a href="#settings">Settings</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section id="profile" class="card">
            <h2>Profile</h2>
            <p>Name: <?php session_start(); echo $_SESSION['username']; ?></p>
            <p>Student ID: 2022-2-<?php echo $_SESSION['user_id']; ?></p>
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
