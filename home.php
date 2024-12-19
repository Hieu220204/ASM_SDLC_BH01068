<?php
session_start();

// Kiểm tra xem session đã được thiết lập chưa
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Role'])) {
    header("Location: login.php");  // Chuyển hướng đến trang đăng nhập nếu session chưa được thiết lập
    exit;
}

$role = $_SESSION['Role'];
$username = isset($_SESSION['Username']) ? $_SESSION['Username'] : 'Guest';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <style>
        /* General Body Styling */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: #f9f9f9;
        }

        /* Container Layout */
        .container {
            display: flex;
            width: 100%;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            background: linear-gradient(45deg, #283048, #859398);
            color: white;
            display: flex;
            flex-direction: column;
            height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 20px;
            color: #fff;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
            margin: 0 20px;
        }

        .sidebar .menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
            width: 100%;
            text-align: center;
        }

        .sidebar .menu li {
            margin: 10px 0;
        }

        .sidebar .menu li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            padding: 10px 20px;
            display: block;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .sidebar .menu li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: scale(1.05);
        }

        /* Main Content Area */
        .main-content {
            flex: 1;
            background: #ffffff;
            padding: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            color: #555;
            text-align: center;
        }

        .main-content h1 {
            font-size: 40px;
            font-weight: bold;
            margin: 0;
            color: #333;
        }

        .main-content p {
            font-size: 18px;
            color: #666;
            margin-top: 15px;
            line-height: 1.6;
            max-width: 600px;
        }

        /* Responsive design for smaller screens */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
            }

            .main-content {
                padding: 20px;
            }
        }

        /* Hình ảnh trong Sidebar (Logo hoặc Avatar) */
        .sidebar img {
            width: 120px;
            /* Kích thước tối ưu */
            height: auto;
            /* Giữ tỷ lệ hình ảnh */
            border-radius: 50%;
            /* Hình ảnh tròn (nếu là avatar) */
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            /* Hiệu ứng đổ bóng */
            transition: transform 0.3s ease;
            /* Hiệu ứng hover */
        }

        .sidebar img:hover {
            transform: scale(1.1);
            /* Phóng to nhẹ khi hover */
        }

        /* Hình ảnh trong Main Content */
        .main-content img {
            max-width: 100%;
            /* Đảm bảo hình ảnh không vượt quá khung chứa */
            height: auto;
            /* Giữ tỷ lệ gốc */
            border-radius: 10px;
            /* Bo góc nhẹ */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng đổ bóng */
            margin-top: 20px;
            /* Tạo khoảng cách với các thành phần khác */
            transition: opacity 0.3s ease, transform 0.3s ease;
            /* Hiệu ứng mờ dần và di chuyển */
        }

        .main-content img:hover {
            opacity: 0.9;
            /* Giảm độ sáng khi hover */
            transform: scale(1.05);
            /* Phóng to nhẹ */
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="sidebar">
            <img src="NEIlogo.png" alt="logo" class="logo">
            <ul class="menu">
                <li><a href="Student.php">Student</a></li>
                <li><a href="teacher.php">Teacher</a></li>
                <li><a href="Class.php">Class</a></li>
                <li><a href="attendance.php">Attendance</a></li>
                <li><a href="grade.php">Grade</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="main-content">
            <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
            <img src="backgroud.png" alt="">
        </div>
    </div>
</body>

</html>