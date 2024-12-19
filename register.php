<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Insert new user into the database
    $query = "INSERT INTO User (Username, Password, Role) VALUES ('$username', MD5('$password'), '$role')";
    if (mysqli_query($conn, $query)) {
        $success = "Registration successful. You can now log in.";
    } else {
        $error = "Registration failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
    <form method="POST">
        <h2>Register</h2>

        <!-- Display success message if registration is successful -->
        <?php if (isset($success)) echo "<p style='color:green;'>$success</p>"; ?>

        <!-- Display error message if registration fails -->
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="Teacher">Teacher</option>
            <option value="Student">Student</option>
        </select>
        <button type="submit">Register</button>
        <button type="button" onclick="window.location.href='login.php'" class="back-button">Back to Login</button>
    </form>
</body>
</html>
