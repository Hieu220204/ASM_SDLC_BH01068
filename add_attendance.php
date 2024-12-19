<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $studentID = $_POST['studentID'];
    $classID = $_POST['classID'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Insert data into database
    $query = "INSERT INTO Attendance (StudentID, ClassID, Date, Status) VALUES ('$studentID', '$classID', '$date', '$status')";
    if (mysqli_query($conn, $query)) {
        echo "Attendance added successfully!";
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
    <title>Add Attendance</title>
</head>
<body>
    <h1>Add Attendance</h1>
    <form action="add_attendance.php" method="POST">
        <label for="studentID">Student ID:</label><br>
        <input type="number" id="studentID" name="studentID" required><br><br>

        <label for="classID">Class ID:</label><br>
        <input type="number" id="classID" name="classID" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" required><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="Present">Present</option>
            <option value="Absent">Absent</option>
        </select><br><br>

        <button type="submit">Add Attendance</button>
    </form>

    <br><br>
    <a href="attendance.php">Back to Attendance Management</a>
</body>
</html>
