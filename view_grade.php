<?php
session_start();  // Bắt đầu session để kiểm tra người dùng

// Kiểm tra xem session có tồn tại và có vai trò hợp lệ không
if (!isset($_SESSION['role'])) {
    header("Location: login.php");  // Nếu không có session, chuyển hướng đến trang đăng nhập
    exit();
}

$role = $_SESSION['role'];  // Lấy vai trò người dùng từ session
?>


<?php
session_start();
include 'db.php';

$studentID = $_SESSION['StudentID']; // Lấy ID sinh viên từ session
$result = mysqli_query($conn, "SELECT * FROM grade WHERE StudentID = $studentID");

echo "<table class='table'>";
echo "<tr><th>Subject</th><th>Grade</th><th>Exam Date</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['SubjectName']}</td>
        <td>" . number_format($row['Grade'], 2) . "</td>
        <td>{$row['ExamDate']}</td>
    </tr>";
}
echo "</table>";
?>


