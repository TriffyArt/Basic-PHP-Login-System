<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'connection.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete_sql = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting user!');</script>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - User List</title>
</head>
<body style="display: flex; justify-content: center; align-items: center; height: 100vh; background-color: #f4f4f4; margin: 0;">
    <div style="width: 750px; background-color: white; border: solid black 2px; padding: 20px; text-align: center;">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <h2>List of Users</h2>
        
        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
            <tr>
                <th>ID</th>
                <th>FIRST NAME</th>
                <th>LAST NAME</th>
                <th>CONTACT NUM</th>
                <th>USERNAME</th>
                <th>ACTION</th>
            </tr>

            <?php
            $sql = "SELECT * FROM user";  
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>{$row['id']}</td>
                            <td>{$row['first_name']}</td>
                            <td>{$row['last_name']}</td>
                            <td>{$row['contact_number']}</td>
                            <td>{$row['username']}</td>
                            <td>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' name='delete' style='color:white; background-color:red; border: none; padding: 5px 10px; cursor: pointer;'>Delete</button>
                                </form> 

                                <a href='edit_user.php?id={$row['id']}' style='color:white; background-color:#4267B2; padding: 5px 10px; text-decoration: none; display: inline-block; border-radius: 5px;'>Edit</a>
                            </td>
                        </tr>
                    ";
                }
            }
            ?>

        </table>
        
        <br>
        <a href="login.php" style="display: inline-block; padding: 10px 20px; background-color: black; color: white; text-decoration: none; border-radius: 5px;">Logout</a>
    </div>
</body>
</html>
