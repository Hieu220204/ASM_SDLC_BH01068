<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'Admin' && $_SESSION['role'] !== 'Teacher') {
    echo "<script>alert('Bạn không có quyền sửa điểm!');</script>";
    header("Location: grade.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM grade WHERE GradeID = '$id'");
    $row = mysqli_fetch_assoc($result);

    // Hiển thị form chỉnh sửa điểm
    echo '
    <form action="update_grade.php" method="POST">
        <input type="hidden" name="GradeID" value="' . $row['GradeID'] . '">
        <input type="text" name="SubjectName" value="' . $row['SubjectName'] . '" required>
        <input type="number" name="Grade" value="' . $row['Grade'] . '" min="0" max="10" step="0.01" required>
        <button type="submit" name="update">Update</button>
    </form>';
}
?>
