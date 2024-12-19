<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $classID = $_GET['id'];

    // Delete record from database
    $deleteQuery = "DELETE FROM Class WHERE ClassID = '$classID'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Class deleted successfully!";
        header("Location: class.php");
    } else {
        echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
    }
}
?>
