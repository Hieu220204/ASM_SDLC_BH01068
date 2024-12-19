<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $teacherID = $_GET['id'];

    // Delete record from database
    $deleteQuery = "DELETE FROM Teacher WHERE TeacherID = '$teacherID'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Teacher deleted successfully!";
        header("Location: teacher.php");
    } else {
        echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
    }
}
?>
