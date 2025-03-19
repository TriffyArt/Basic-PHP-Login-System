<?php
include 'connection.php';

$error_message = ""; 

// Check if the ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch user data
    $select_sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($select_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "User not found!";
        exit();
    }

    $stmt->close();
} else {
    echo "No user ID provided!";
    exit();
}

// Update user details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact_number = $_POST['contact_number'];
    $username = $_POST['username'];
    $password = $_POST['password'];  

   
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ? AND id != ?");
    $stmt->bind_param("si", $username, $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error_message = "Username already exists.";
    } else {
        
    $update_sql = "UPDATE user SET first_name = ?, last_name = ?, contact_number = ?, username = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sssssi", $first_name, $last_name, $contact_number, $username, $password, $id);

        if ($stmt->execute()) {
            echo "<script>alert('User updated successfully!'); window.location.href='welcome.php';</script>";
        } else {
            echo "<script>alert('Error updating user!');</script>";
        }

        $stmt->close();
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');
    </style>
</head>

<body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: rgb(204, 232, 208); font-family: Poppins, sans-serif; font-weight: 400;">

    <div style="background: white; padding: 50px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(148, 241, 204, 0.3); text-align: center; width: 400px;">

        <h1 style="margin-bottom: 10px;">Edit User Details</h1>
        
        <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="POST">
            <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" placeholder="First Name" required 
                style="display: block; width: 90%; margin: 10px auto; padding: 10px; text-align: center;">
                
            <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" placeholder="Last Name" required 
                style="display: block; width: 90%; margin: 10px auto; padding: 10px; text-align: center;">
                
            <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>" placeholder="Contact Number" required 
                style="display: block; width: 90%; margin: 10px auto; padding: 10px; text-align: center;">
                
            <input type="text" name="username" value="<?php echo $user['username']; ?>" placeholder="Username" required 
                style="display: block; width: 90%; margin: 10px auto; padding: 10px; text-align: center;">
                
            <input type="password" name="password" placeholder="New Password" required 
                style="display: block; width: 90%; margin: 10px auto; padding: 10px; text-align: center;">

            <?php if (!empty($error_message)): ?>
                <p style="color: red; font-weight: 500;"><?php echo $error_message; ?></p>
            <?php endif; ?>
                
            <button type="submit" style="width: 95%; padding: 10px; background-color: #68ace0; color: white; border: none; cursor: pointer; margin-top: 10px; border-radius: 5px;">Update User</button>
        </form>

        <a href="welcome.php" style="display: inline-block; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;">Back to Users List</a>
    </div>

</body>
</html>

