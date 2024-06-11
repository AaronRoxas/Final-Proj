<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" type="image/x-icon" href="asset/img/icon.png">
</head>
<body class="sign-up-body">
    <nav>
    <img src="asset/img/enode-logo.png" alt="" width="123px" height="50px" id="logo">
        <a href="index.html">Home</a>
        <a href="index.html#about">About</a>
        <a href="contact.html">Contact</a>
        <div class="right-nav">
            <a href="login.php">Login</a>
            <a href="registration.php" id="sign-up-btn">Sign up</a>
        </div>
    </nav>

    <div class="sign-up-container">
            <div class="sign-up-box" style="transition = 0.3s ease in;";>
                <h2>Register</h2>
            <form action="scripts/signup.php" method="post">

                <div class="input-box"><input type="text" name="fname" id="" placeholder="Enter First Name" required></div>
                <div class="input-box"><input type="text" name="lname" id="" placeholder="Enter Last Name" required></div>
                <div class="input-box"><input type="email" name="email" id="" placeholder="Enter Email" required></div>
                <div class="input-box"><select name="role" id="" required>
                    <option value="" disabled selected>Enter your role</option>
                    <option value="s">Student</option>
                    <option value="t">Teacher</option>
                </select></div>
                <div class="input-box"><input type="password" name="password" id="" placeholder="Create Password" required></div>
                <div class="input-box"><input type="password" name="confirmPass" id="" placeholder="Confirm Password" required></div>
                <div class="input-box button"><input type="submit" value="Register Now"></div>
                
                <?php
                    if(isset($_GET['error']) && $_GET['error'] == 'password_mismatch'){
                        echo "<p style='color: red;'>Password did not match.</p>";
                    }
                    if(isset($_GET['error']) && $_GET['error'] == 'user_exists'){
                        echo "<p style='color: red;'>Email already registered!</p>";
                    }
                ?>
            </form>   
        </div>
    </div>
</body>
</html>