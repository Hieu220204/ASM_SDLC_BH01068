<?php
session_start();

// Kiểm tra xem session đã được thiết lập chưa
if (!isset($_SESSION['UserID']) || !isset($_SESSION['Role'])) {
    header("Location: login.php");  // Chuyển hướng đến trang đăng nhập nếu session chưa được thiết lập
    exit;
}

$role = $_SESSION['Role'];
$userID = $_SESSION['UserID'];

// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root"; // Đổi lại nếu cần
$password = "";
$dbname = "asm_final"; // Đổi lại nếu cần

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy danh sách điểm từ cơ sở dữ liệu
$sql = "SELECT g.GradeID, s.FirstName, s.LastName, c.ClassName, g.Grade
        FROM grade g
        JOIN student s ON g.StudentID = s.StudentID
        JOIN class c ON g.ClassID = c.ClassID";
$result = $conn->query($sql);

// Thêm, sửa, xóa điểm (Chỉ Admin và Teacher có thể thực hiện)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($role == 'Admin' || $role == 'Teacher') {
        // Thêm điểm
        if (isset($_POST['add_grade'])) {
            $studentID = $_POST['studentID'];
            $classID = $_POST['classID'];
            $grade = $_POST['grade'];
            $sql_add = "INSERT INTO grade (StudentID, ClassID, Grade) VALUES ('$studentID', '$classID', '$grade')";
            $conn->query($sql_add);
        }

        // Sửa điểm
        if (isset($_POST['edit_grade'])) {
            $gradeID = $_POST['gradeID'];
            $grade = $_POST['grade'];
            $sql_edit = "UPDATE grade SET Grade = '$grade' WHERE GradeID = '$gradeID'";
            $conn->query($sql_edit);
        }

        // Xóa điểm
        if (isset($_POST['delete_grade'])) {
            $gradeID = $_POST['gradeID'];
            $sql_delete = "DELETE FROM grade WHERE GradeID = '$gradeID'";
            $conn->query($sql_delete);
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Grade Management</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Container to hold the content */
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Header and title */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Back to Home link */
        a.back-button {
            display: inline-block;
            margin: 10px 0 20px 0;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        a.back-button:hover {
            background-color: #2980b9;
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        form label {
            font-weight: bold;
            color: #444;
        }

        form input,
        form select {
            width: 250px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        form input:focus,
        form select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.3);
        }

        form button {
            padding: 10px 20px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #2ecc71;
        }

        /* Table styling */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        table th,
        table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #3498db;
            color: white;
            font-size: 15px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        /* Buttons inside table */
        table button {
            padding: 6px 12px;
            background-color: #f39c12;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        table button:hover {
            background-color: #e67e22;
        }

        table button:active {
            background-color: #d35400;
        }

        /* Input field in table */
        table input[type="number"] {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            width: 80px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                width: 95%;
                padding: 15px;
            }

            table th,
            table td {
                padding: 8px;
            }

            form input,
            form select {
                width: 100%;
            }

            form button {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Nút Back to Home -->
    <a href="home.php" class="back-button">Back to Home</a>

    <div class="container">
        <div class="content">
            <h2>Grade Management</h2>

            <?php if ($role == 'Admin' || $role == 'Teacher') { ?>
                <!-- Form to Add Grade -->
                <div class="form-container">
                    <h3>Add Grade</h3>
                    <form method="POST">
                        <label for="studentID">Student</label>
                        <select name="studentID" required>
                            <?php
                            // Lấy danh sách sinh viên
                            $sql_students = "SELECT StudentID, FirstName, LastName FROM student";
                            $students = $conn->query($sql_students);
                            while ($row = $students->fetch_assoc()) {
                                echo "<option value='" . $row['StudentID'] . "'>" . $row['FirstName'] . " " . $row['LastName'] . "</option>";
                            }
                            ?>
                        </select><br><br>

                        <label for="classID">Class</label>
                        <select name="classID" required>
                            <?php
                            // Lấy danh sách lớp học
                            $sql_classes = "SELECT ClassID, ClassName FROM class";
                            $classes = $conn->query($sql_classes);
                            while ($row = $classes->fetch_assoc()) {
                                echo "<option value='" . $row['ClassID'] . "'>" . $row['ClassName'] . "</option>";
                            }
                            ?>
                        </select><br><br>

                        <label for="grade">Grade</label>
                        <input type="number" name="grade" step="0.01" min="0" max="10" required><br><br>

                        <input type="submit" name="add_grade" value="Add Grade" class="button">
                    </form>
                </div>
            <?php } ?>

            <h3>Grade List</h3>
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Grade</th>
                    <?php if ($role == 'Admin' || $role == 'Teacher') { ?>
                        <th>Actions</th>
                    <?php } ?>
                </tr>

                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>";
                    echo "<td>" . $row['ClassName'] . "</td>";
                    echo "<td>
                        <form method='POST' style='display:inline'>
                            <input type='hidden' name='gradeID' value='" . $row['GradeID'] . "'>
                            <input type='number' name='grade' value='" . $row['Grade'] . "' step='0.01' min='0' max='10'>
                            <input type='submit' name='edit_grade' value='Save' class='button'>
                        </form>
                    </td>";
                    if ($role == 'Admin' || $role == 'Teacher') {
                        echo "<td>
                            <form method='POST' style='display:inline'>
                                <input type='hidden' name='gradeID' value='" . $row['GradeID'] . "'>
                                <input type='submit' name='delete_grade' value='Delete' class='button' onclick='return confirm(\"Are you sure?\")'>
                            </form>
                        </td>";
                    }
                    echo "</tr>";
                }
                ?>

            </table>
        </div>
    </div>

</body>

</html>

<?php
$conn->close();
?>