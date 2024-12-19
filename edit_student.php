<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $studentID = $_GET['id'];
    $query = "SELECT * FROM Student WHERE StudentID = '$studentID'";
    $result = mysqli_query($conn, $query);
    $student = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $studentName = $_POST['studentName'];
    $studentEmail = $_POST['studentEmail'];
    $studentPhone = $_POST['studentPhone'];

    // Cập nhật thông tin học sinh trong cơ sở dữ liệu
    $updateQuery = "UPDATE Student SET StudentName = '$studentName', Email = '$studentEmail', Phone = '$studentPhone' WHERE StudentID = '$studentID'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Student updated successfully!";
        header("Location: student.php");
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
</head>
<body>
    <h1>Edit Student</h1>
    <form action="edit_student.php?id=<?php echo $student['StudentID']; ?>" method="POST">
        <label for="studentName">Name:</label><br>
        <input type="text" id="studentName" name="studentName" value="<?php echo $student['StudentName']; ?>" required><br><br>

        <label for="studentEmail">Email:</label><br>
        <input type="email" id="studentEmail" name="studentEmail" value="<?php echo $student['Email']; ?>" required><br><br>

        <label for="studentPhone">Phone:</label><br>
        <input type="text" id="studentPhone" name="studentPhone" value="<?php echo $student['Phone']; ?>" required><br><br>

        <button type="submit">Update Student</button>
    </form>

    <br><br>
    <a
