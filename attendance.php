<?php
session_start();
include('db.php');

// Role-based access control
if (!isset($_SESSION['UserID'])) {
    header("Location: home.php");
    exit;
}

// Handle Add, Edit, Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher')) {
    $action = $_POST['action'];

    if ($action == 'Add') {
        $studentID = $_POST['StudentID'];
        $classID = $_POST['ClassID'];
        $date = $_POST['Date'];
        $status = $_POST['Status'];

        $query = "INSERT INTO Attendance (StudentID, ClassID, Date, Status) 
                  VALUES ($studentID, $classID, '$date', '$status')";
        mysqli_query($conn, $query);
    } elseif ($action == 'Edit') {
        $attendanceID = $_POST['AttendanceID'];
        $studentID = $_POST['StudentID'];
        $classID = $_POST['ClassID'];
        $date = $_POST['Date'];
        $status = $_POST['Status'];

        $query = "UPDATE Attendance 
                  SET StudentID=$studentID, ClassID=$classID, Date='$date', Status='$status' 
                  WHERE AttendanceID=$attendanceID";
        mysqli_query($conn, $query);
    } elseif ($action == 'Delete') {
        $attendanceID = $_POST['AttendanceID'];
        $query = "DELETE FROM Attendance WHERE AttendanceID=$attendanceID";
        mysqli_query($conn, $query);
    }
}

// Fetch attendance records from the database
$result = mysqli_query($conn, "SELECT * FROM Attendance");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Management</title>
    <link rel="stylesheet" type="text/css" href="attendance.css">


    <a href="home.php">Back to Home</a>
</head>
<body>
    <h2>Manage Attendance</h2>
    <?php if ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher'): ?>
    <form method="POST">
        <input type="text" name="StudentID" placeholder="Student ID" required>
        <input type="text" name="ClassID" placeholder="Class ID" required>
        <input type="date" name="Date" required>
        <input type="text" name="Status" placeholder="Status (Present/Absent)" required>
        <button type="submit" name="action" value="Add">Add</button>
    </form>
    <?php endif; ?>

    <h3>Attendance List</h3>
    <table border="1">
        <tr>
            <th>AttendanceID</th>
            <th>StudentID</th>
            <th>ClassID</th>
            <th>Date</th>
            <th>Status</th>
            <?php if ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher'): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <form method="POST">
                <td><?= $row['AttendanceID'] ?><input type="hidden" name="AttendanceID" value="<?= $row['AttendanceID'] ?>"></td>
                <td><input type="text" name="StudentID" value="<?= $row['StudentID'] ?>"></td>
                <td><input type="text" name="ClassID" value="<?= $row['ClassID'] ?>"></td>
                <td><input type="date" name="Date" value="<?= $row['Date'] ?>"></td>
                <td><input type="text" name="Status" value="<?= $row['Status'] ?>"></td>
                <?php if ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher'): ?>
                <td>
                    <button type="submit" name="action" value="Edit">Edit</button>
                    <button type="submit" name="action" value="Delete" onclick="return confirm('Are you sure?')">Delete</button>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
