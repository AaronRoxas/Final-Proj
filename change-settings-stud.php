<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
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
                <p>Student ID: S-<?php echo $_SESSION['user_id']; ?></p>
                <p>Email: <?php echo $_SESSION['user_email']; ?></p>
                <h2>Settings</h2>
                <p><a href="#">Change Password</a></p>
               
            </ul>
            <div class="returnBtn">
                <a href="student-dashboard.php">Return</a>
            </div>
        </aside>
        
    <section id="changePassword" class="content">
    <h2>Change Password</h2>
    <form id="changePasswordForm" action="scripts/change-stud-pass.php" method="POST">
        <input type="password" name="current_password" placeholder="Current Password" required><br>
        <input type="password" name="new_password" placeholder="New Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <div class="align-center">
            <button type="submit">Change Password</button>
        </div>
        <?php
        if(isset($_GET['error']) && $_GET['error'] == 'incorrect_pass'){
            echo "<p style='color: red;'>Current password is incorrect.</p>";
        }?>
    </form>
    </section>

    </section>
</body>
</html>