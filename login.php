<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM User WHERE Username='$username' AND Password=MD5('$password')";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['Role'] = $user['Role'];
        $_SESSION['Username'] = $user['Username'];  // Thiết lập session cho Username
        header("Location: home.php");  // Chuyển hướng về trang home sau khi đăng nhập thành công
        exit;
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
/* General Body Styling */
body {
    font-family: Arial, sans-serif;
    background-image: url('backgroud.png'); /* Đảm bảo đường dẫn đúng */
    background-size: cover; /* Đảm bảo hình ảnh phủ kín màn hình */
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
}

/* Centered Form Container */
form {
    background: #ffffff;
    color: #333;
    border-radius: 10px;
    padding: 30px 40px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

/* Form Title */
h2 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #6a11cb;
}

/* Input Fields */
input[type="text"], input[type="password"] {
    width: 100%;
    padding: 10px 15px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 16px;
    box-sizing: border-box;
}

/* Input Focus Styling */
input[type="text"]:focus, input[type="password"]:focus {
    border: 1px solid #6a11cb;
    outline: none;
    box-shadow: 0 0 8px rgba(106, 17, 203, 0.2);
}

/* Submit Button */
button {
    background: #6a11cb;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s ease;
    margin-top: 10px;
    width: 100%;
}

button:hover {
    background: #2575fc;
}

/* Error Message Styling */
p {
    font-size: 14px;
    margin-top: 10px;
    color: red;
}

/* Styling for the Register link */
.register-link {
    text-align: center;
    margin-top: 10px;
}

.register-link a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
}

.register-link a:hover {
    color: #2980b9;
}
    </style>
</head>
<body>
    <form method="POST">
        <h2>Login</h2>
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </form>
</body>
</html>
