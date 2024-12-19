<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Teacher') {
    echo "<script>alert('Bạn không có quyền thêm điểm!');</script>";
    header("Location: grade.php");
    exit();
}

if (isset($_POST['add'])) {
    $studentID = $_POST['StudentID'];
    $classID = $_POST['ClassID'];
    $subjectName = $_POST['SubjectName'];
    $grade = $_POST['Grade'];
    $examDate = date('Y-m-d');

    // Kiểm tra điểm nhập vào có hợp lệ không
    if ($grade < 0 || $grade > 10) {
        echo "<script>alert('Grade must be between 0 and 10.');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    $checkStudent = mysqli_query($conn, "SELECT * FROM student WHERE StudentID = '$studentID'");
    if (mysqli_num_rows($checkStudent) == 0) {
        echo "<script>alert('Student ID không tồn tại!');</script>";
        echo "<script>window.history.back();</script>";
        exit();
    }

    // Thêm điểm vào bảng grade
    $sql = "INSERT INTO grade (StudentID, ClassID, SubjectName, Grade, ExamDate) 
            VALUES ('$studentID', '$classID', '$subjectName', '$grade', '$examDate')";

    if (mysqli_query($conn, $sql)) {
        header("Location: grade.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
