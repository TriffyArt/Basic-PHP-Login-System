<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = $_POST['password']; 

    $result = $conn->query("SELECT * FROM user WHERE username='$username'");

    if ($result->num_rows > 0) {
        echo "Username already exists.";
    } else {
        $conn->query("INSERT INTO user (first_name, last_name, contact_number, username, password) 
                      VALUES ('$first_name', '$last_name', '$contact_number', '$username', '$password')");
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
    </style>
</head>

<body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color:rgb(204, 232, 208); font-family: Poppins, sans-serif; font-weight: 400;">

    <div style="background: white; padding: 50px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(148, 241, 204, 0.3); text-align: center;">

        <div style="display: flex; justify-content: center; gap: 10px; margin-top: -40px; margin-bottom: -10px;">
            <h1 style="margin: 10px 70px; padding: 10px;">Register Here</h1>
        </div>

        <form method="post">
            <input type="text" name="first_name" placeholder="First Name" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: left;">
            <input type="text" name="last_name" placeholder="Last Name" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: left;">
            <input type="text" name="contact_number" placeholder="Contact Number" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: left;">
            <input type="text" name="username" placeholder="Username" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: left;">
            <input type="password" name="password" placeholder="Password" required 
                style="display: block; width: 90%; margin: 10px 0; padding: 10px; text-align: left;">

            <div style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                <button type="submit" style="width: 45%; padding: 10px; cursor: pointer; background-color: rgb(104, 172, 224); border: none;">Register</button>
                <a href="login.php" style="width: 45%;">
                    <button type="button" style="width: 100%; padding: 10px; cursor: pointer; border: none;">Login</button>
                </a>
            </div>

        </form>

    </div>

</body>
</html>

