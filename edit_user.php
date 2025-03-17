<?php
include 'connection.php';

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
    $password = $_POST['password'];  // Password should be hashed in a real system

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

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; margin: 0;">
    <div style="width: 700px; background-color: white; border: solid black 2px; padding: 20px; text-align: center;">
        <h1>Edit User Details</h1>
        <form action="edit_user.php?id=<?php echo $user['id']; ?>" method="POST">
            <label>First Name:</label><br>
            <input type="text" name="first_name" value="<?php echo $user['first_name']; ?>" required style="width: 90%; padding: 10px; margin: 5px;"><br>
            
            <label>Last Name:</label><br>
            <input type="text" name="last_name" value="<?php echo $user['last_name']; ?>" required style="width: 90%; padding: 10px; margin: 5px;"><br>
            
            <label>Contact Number:</label><br>
            <input type="text" name="contact_number" value="<?php echo $user['contact_number']; ?>" required style="width: 90%; padding: 10px; margin: 5px;"><br>
            
            <label>Username:</label><br>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required style="width: 90%; padding: 10px; margin: 5px;"><br>
            
            <label>Password:</label><br>
            <input type="password" name="password" placeholder="New Password" required style="width: 90%; padding: 10px; margin: 5px;"><br>
            
            <button type="submit" style="width: 90%; padding: 10px; background-color:#4267B2; color: white; border: none; cursor: pointer; margin: 10px 0;">Update User</button>
        </form>
        <a href="welcome.php" style="text-decoration: none; color: black; display: block; margin-top: 10px;">Back to Users List</a>
    </div>
</body>
</html>
