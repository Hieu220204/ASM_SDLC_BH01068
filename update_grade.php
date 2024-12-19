<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Teacher') {
    echo "<script>alert('Bạn không có quyền cập nhật điểm!');</script>";
    header("Location: grade.php");
    exit();
}

if (isset($_POST['update'])) {
    $gradeID = $_POST['GradeID'];
    $subjectName = $_POST['SubjectName'];
    $grade = $_POST['Grade'];

    if ($grade < 0 || $grade > 10) {
        echo "<script>alert('Grade must be between 0 and 10.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $sql = "UPDATE grade SET SubjectName = '$subjectName', Grade = '$grade' WHERE GradeID = '$gradeID'";

    if (mysqli_query($conn, $sql)) {
        header("Location: grade.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
