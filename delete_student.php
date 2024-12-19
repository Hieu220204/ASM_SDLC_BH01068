<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    // Xóa học sinh từ cơ sở dữ liệu
    $deleteQuery = "DELETE FROM Student WHERE StudentID = '$studentID'";
    if (mysqli_query($conn, $deleteQuery)) {
        echo "Student deleted successfully!";
        header("Location: student.php");
    } else {
        echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
    }
}
?>
