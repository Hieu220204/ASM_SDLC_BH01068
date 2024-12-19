<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentPhone = $_POST['studentPhone'];

    // Thêm dữ liệu vào cơ sở dữ liệu
    $query = "INSERT INTO Student (StudentName, Email, Phone) VALUES ('$studentName', '$studentEmail', '$studentPhone')";
    if (mysqli_query($conn, $query)) {
        echo "Student added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
</head>
<body>
    <h1>Add New Student</h1>
    <form action="add_student.php" method="POST">
        <label for="studentName">Name:</label><br>
        <input type="text" id="studentName" name="studentName" required><br><br>

        <label for="studentEmail">Email:</label><br>
        <input type="email" id="studentEmail" name="studentEmail" required><br><br>

        <label for="studentPhone">Phone:</label><br>
        <input type="text" id="studentPhone" name="studentPhone" required><br><br>

        <button type="submit">Add Student</button>
    </form>

    <br><br>
    <a href="student.php">Back to Student Management</a>
</body>
</html>
