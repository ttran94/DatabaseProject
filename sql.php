<?php
    // Login for all users
    //Check username
    $sql = "SELECT Username FROM user WHERE Username = '$username'";
    $result = mysqli_query($query);
    $count = mysqli_num_rows($result);
    if($count!=1) {
        $error = true;
        $loginError = "Provided username/password does not exist in the database. Please try again.";
    } else {
        $sql = "SELECT Password FROM user WHERE Username = '$username'";
        $result = mysqli_query($query);
        if ($result != $password) {
            $error = true;
            $loginError = "Provided username/password does not exist in the database. Please try again.";
        }
    }
    if (!$error) {
        $sql = "SELECT User_type FROM user WHERE Username = '$username'";
    }


    // User registration
    // Registration valid username check
    $sql = "SELECT Username FROM user WHERE Username = '$username'";
    $result = mysqli_query($query);
    $count = mysqli_num_rows($result);
    if($count!=0) {
        $error = true;
        $usernameError = "Provided username is already in use.";
    }
    // Registration valid email check
    $sql = "SELECT Email FROM user WHERE Email = '$email'";
    $result = mysqli_query($query);
    $count = mysqli_num_rows($result);
    if($count!=0) {
        $error = true;
        $emailError = "Provided email is already in use.";
    }
    // Registration password match
    if($password != $confPass) {
        $error = true;
        $emailError = "Entries in the password and confirm password fields do not match.";
    }

