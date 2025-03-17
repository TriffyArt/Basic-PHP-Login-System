<?php
include 'connection.php';
session_start();

$error = ""; // initiatilize error msg

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM user WHERE username='$username' AND password='$password'");

    if ($result->num_rows > 0) {        // to check if the username and user_id is in the database
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        header("Location: welcome.php");    // redirect to welcome.php if the login is success
        exit();
    } else {
        $error = "Invalid username or password."; // to store error msg
    }
}
?>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color:rgb(2, 42, 8);">

    <div style="background: white; padding: 90px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(184, 244, 220, 0.3); text-align: center;">
        <form method="post">
            <input type="text" name="username" placeholder="Username" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: center;">
            <input type="password" name="password" placeholder="Password" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: center;">
            <button type="submit" style="width: 50%; padding: 10px; margin: 5px 0; cursor: pointer;">Login</button>
        </form>
        <a href="register.php">
            <button style="width: 50%; padding: 10px; cursor: pointer;">Register</button>
        </a>

        <?php if (!empty($error)) : ?>
            <p style="color: red; font-weight: bold; margin-top: 10px;"><?= $error ?></p>   
        <?php endif; ?>
    </div>

</body>
</html>
