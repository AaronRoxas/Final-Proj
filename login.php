<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="sign-up-body">
    <nav>
        <a href="" id="logo"><strong>Logo</strong></a>
        <a href="index.html">Home</a>
        <a href="">About</a>
        <a href="">Contact</a>
        <div class="right-nav">
            <a href="">Login</a>
            <a href="registration.php" id="sign-up-btn">Sign up</a>
        </div>
    </nav>

    <div class="sign-up-container">
            <div class="sign-up-box">
                <h2>Login</h2>
                <form action="login-validate.php" method="post">
                <div class="input-box"><input type="email" name="email" id="" placeholder="Enter your Email" required></div>
                <div class="input-box"><input type="password" name="password" id="" placeholder="Enter Password" required></div>
                <div class="input-box button"><input type="submit" value="Login"></div>
                <?php
                    if(isset($_GET['error']) && $_GET['error'] == 'info_mismatch'){
                        echo "<p style='color: red;'>Invalid email or password.</p>";
                    }
                ?>
            </form>
        </div>
    </div>
</body>

</html>