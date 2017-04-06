<?php
    //this is just a basic example but we need to update it for our specific situation
    include("connect.php");
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // username and password sent from form

        $username = mysqli_real_escape_string($conn,$_POST['username']);
        $password = mysqli_real_escape_string($conn,$_POST['password']);
        //query needs to be updated based on our tables
        $sql = "SELECT id FROM admin WHERE username = '$username' and passcode = '$password'";
        $result = mysqli_query($conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $active = $row['active'];

        $count = mysqli_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row

        if($count == 1) {
            $_SESSION['user'] = $username;
            header("location: welcome.php");
        }else {
            $error = "Your Login Name or Password is invalid";
        }
    }

?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"/>
        <title>Fill in title of site</title>
    </head>
    <body>

    </body>
</html>
