<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $attendanceID = $_GET['id'];

    // Delete record from database
    $deleteQuery = "DELETE FROM Attendance WHERE AttendanceID = '$attendanceID'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Attendance deleted successfully!";
        header("Location: attendance.php");
    } else {
        echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
    }
}
?>
