<?php
session_start();
include('db.php');

// Kiểm tra nếu có StudentID trong URL
if (isset($_GET['StudentID'])) {
    $studentID = $_GET['StudentID'];

    // Lấy thông tin sinh viên
    $query = "SELECT s.StudentID, s.FirstName, s.LastName, c.ClassName, c.ClassDescription
              FROM student s 
              JOIN Class c ON s.ClassID = c.ClassID
              WHERE s.StudentID = $studentID";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $studentName = $row['FirstName'] . " " . $row['LastName'];
        $className = $row['ClassName'];
        $classDescription = $row['ClassDescription'];
    } else {
        echo "Student not found!";
        exit;
    }
} else {
    echo "No Student ID provided!";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Class Details</title>
    <style>
        /* Đặt kiểu chung cho trang */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    padding: 0;
    height: 100vh;
    display: flex;
    flex-direction: column; /* Sắp xếp theo cột */
    justify-content: center; /* Căn giữa theo chiều dọc */
    align-items: center; /* Căn giữa theo chiều ngang */
}

/* Định dạng tiêu đề */
h2 {
    color: #333;
    text-align: center; /* Căn giữa tiêu đề */
    margin-bottom: 10px; /* Khoảng cách dưới tiêu đề */
}

/* Tạo khung chứa thông tin sinh viên */
.container {
    width: 300px; /* Chiều rộng của khung (giảm xuống thành ô vuông) */
    background-color: #fff;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: left; /* Căn lề trái cho văn bản trong khung */
    margin-top: 20px; /* Khoảng cách giữa tiêu đề và khung */
}

/* Định dạng phần thông tin trong khung */
h3 {
    color: #333;
    margin-bottom: 15px; /* Khoảng cách dưới tiêu đề lớp */
}

/* Định dạng các mục thông tin */
p {
    font-size: 16px;
    color: #555;
    line-height: 1.6;
    margin-bottom: 10px; /* Khoảng cách giữa các đoạn văn bản */
}

/* Định dạng tên mục thông tin và giá trị */
p strong {
    display: inline-block;
    width: 150px; /* Chiều rộng cố định cho tên mục */
    text-align: left; /* Căn lề trái cho tên mục */
}

p span {
    text-align: right; /* Căn lề phải cho giá trị thông tin */
}

/* Định dạng cho các liên kết */
a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
}

/* Hiệu ứng hover cho liên kết */
a:hover {
    color: #0056b3;
}

/* Định dạng cho nút quay lại */
.back-btn {
    position: absolute;
    top: 20px;  /* Đặt ở góc trên bên trái */
    left: 20px;
    padding: 10px 20px;
    background-color: #28a745;
    color: #fff;
    border-radius: 5px;
    text-align: center;
    font-size: 14px;
}

.back-btn:hover {
    background-color: #218838;
}

    </style>
</head>

<body>
    <a href="Student.php" class="back-btn">Back to Student List</a> <!-- Nút quay lại -->
    <h2>Student: <?= $studentName ?></h2> <!-- Tiêu đề trang -->

    <div class="container">
        <h3>Class Details</h3>
        <p><strong>Class Name:</strong> <?= $className ?></p>
        <p><strong>Class Description:</strong> <?= $classDescription ?></p>
    </div>
</body>

</html>