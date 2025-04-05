<?php
include('checkSession.php');
include('file.php');

$userId = $_SESSION['userId']; 

try {
    $query = "SELECT FullName, Username FROM users WHERE IdUser = :userId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userId', $userId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

    $fullName = $user['FullName'];
    $username = $user['Username'];

} catch (PDOException $e) {
    die("Error fetching user: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $username = $_POST['username'];
    $newPassword = $_POST['password'];
    $passwordUpdated = false;

    try {
        $query = "UPDATE users SET FullName = :fullName, Username = :username";
        
        if (!empty($newPassword)) {
            $hashedPassword = hash('sha256', $newPassword);
            $query .= ", UserPass = :password";
            $passwordUpdated = true;
        }
        
        $query .= " WHERE IdUser = :userId";
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':userId', $userId);
        
        if ($passwordUpdated) {
            $stmt->bindParam(':password', $hashedPassword);
        }

        $stmt->execute();

        // Set session message
        if ($passwordUpdated) {
            $_SESSION['success_message'] = "Password changed successfully. Please log in again.";
            header("Location: login.php"); // Redirect to login page
        } else {
            $_SESSION['success_message'] = "Profile updated successfully.";
            header("Location: index.php"); // Redirect to index page
        }
        exit();

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Error updating profile: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #F1EFEC;
            padding-top: 50px;
        }
        .form-container {
            max-width: 500px;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
    <div class="form-container">
        <h2 class="text-center">Update Profile</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="fullName">Full Name</label>
                <input type="text" class="form-control" id="fullName" name="fullName" value="<?php echo htmlspecialchars($fullName); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">New Password (optional)</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
            </div>
            <button type="submit" class="btn btn-block" style="background-color: #2C2C2C; color: #fff;">Save</button>

        </form>
    </div>

    <!-- Bootstrap JS and dependencies (Optional for advanced features) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
