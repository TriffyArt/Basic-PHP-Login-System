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
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');
    </style>
</head>

<body style="display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; background-color: rgb(204, 232, 208); font-family: Poppins, sans-serif; font-weight: 400;">

    <div style="width: 750px; background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(148, 241, 204, 0.3); text-align: center;">

        <h1 style="margin-bottom: 10px;">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <h2 style="margin-bottom: 20px;">List of Users</h2>

        <table border="1" style="width: 100%; border-collapse: collapse; text-align: center;">
            <tr style="background-color: #68ace0; color: white;">
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">FIRST NAME</th>
                <th style="padding: 10px;">LAST NAME</th>
                <th style="padding: 10px;">CONTACT NUM</th>
                <th style="padding: 10px;">USERNAME</th>
                <th style="padding: 10px;">ACTION</th>
            </tr>

            <?php
            $sql = "SELECT * FROM user";  
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr style='border-bottom: 1px solid #ddd;'>
                            <td style='padding: 10px;'>{$row['id']}</td>
                            <td style='padding: 10px;'>{$row['first_name']}</td>
                            <td style='padding: 10px;'>{$row['last_name']}</td>
                            <td style='padding: 10px;'>{$row['contact_number']}</td>
                            <td style='padding: 10px;'>{$row['username']}</td>
                            <td style='padding: 10px;'>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='{$row['id']}'>
                                    <button type='submit' name='delete' style='color: white; background-color: red; border: none; padding: 5px 10px; cursor: pointer; border-radius: 5px;'>Delete</button>
                                </form> 

                                <a href='edit_user.php?id={$row['id']}' style='color: white; background-color: #4267B2; padding: 5px 10px; text-decoration: none; display: inline-block; border-radius: 5px;'>Edit</a>
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

