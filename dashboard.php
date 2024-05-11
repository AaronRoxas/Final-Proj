<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="manage-style.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="profile">
                <div class="avatar"><img src="asset/img/avatar.jpg" alt=""  height="75px" width="75px"></div>
                <div class="name"><?php session_start();
                            if(isset($_SESSION['user_email'])){
                                echo $_SESSION['username'];}
                                ?></div>
            </div>
        <ul>
            <li class="active"><a href="">Select Class</a></li>
            <li><a href="">Dashboard</a></li>
            <li><a href="">Student List</a></li>
            <li class="bottom logout-btn"><a href="logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="grid-container">
        <div class="card">
            <p>CS201</p> 
        </div>
        <div class="card">
            <p>CS202</p>
        </div>
        <div class="card add-new">
            <p>Add Class</p>
        </div>
    </div>
    </div>
  
</body>
</html>
