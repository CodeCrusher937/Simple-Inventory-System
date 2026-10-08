<?php

include('connection.php');
session_start();

if(isset($_POST['register'])){
    $name =trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{8,}$/";
    $phoneRegex = "/^255[0-9]{9}$/";
    
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    if(!$name && !$email && !$phone && !$password){
        // echo "<script>alert('Please fill all fields.')</script>";
        echo "Please fill all fields.";
    }else{

    if($name==""){
        echo "Please enter your name.";

    }elseif($phone==""){
        echo "please enter your phone number.";
    }elseif(!preg_match($phoneRegex,$phone)){
        echo "Invalid phone number.";

    }elseif($email==""){
       echo"Please enter your email.";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
       echo"Please enter a valid email.";

    }elseif($password==""){
        echo"Please enter your password";
    }elseif(!$password=="" && !preg_match($passwordRegex,$password)){
       echo"Invalid password.";


    }elseif(!$password=="" && strlen ($password)<8){
       echo"Password must be at least 8 characters.";

    }else{

        $hashed_password = sha1($password);

        $sql = "INSERT INTO users (name, email, phone, password)
         VALUES('$name', '$email', '$phone', '$hashed_password')";

        $query = mysqli_query($connection, $sql);

        if ($query){
        // echo "Registration successful.";
         header("location: login.php");
                    exit();
        }else{
        echo "Registration failed.";
        }
    }
    }
}



if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{8,}$/";

    if (!$email && !$password) {
    echo "Please fill all fields.";

    } elseif ($email == "") {
    echo "Please enter your email.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Please enter a valid email.";

    } elseif ($password == "") {
    echo "Please enter your password.";

    } else {

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) == 1) {
            $user = mysqli_fetch_assoc($query);
            $hashed_password = sha1($password);

            if ($hashed_password == $user['password']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                if ($user['role'] == 'admin') {
                    header("location: admin_dashboard.php");
                    exit();

                } elseif ($user['role'] == 'customer') {
                    header("location: customer_dashboard.php");
                    exit();

                } else {
                echo "Invalid user role.";
                }

            } else {
            echo "Login failed. Incorrect password.";
            }
        } else {
        echo "Login failed. Email not found.";
        }
    }
}

?>