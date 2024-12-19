<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Teacher') {
    echo "<script>alert('Bạn không có quyền xóa điểm!');</script>";
    header("Location: grade.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM grade WHERE GradeID = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: grade.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
