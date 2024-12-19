<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $attendanceID = $_GET['id'];
    $query = "SELECT * FROM Attendance WHERE AttendanceID = '$attendanceID'";
    $result = mysqli_query($conn, $query);
    $attendance = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated data from form
    $studentID = $_POST['studentID'];
    $classID = $_POST['classID'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    // Update the record in the database
    $updateQuery = "UPDATE Attendance SET StudentID = '$studentID', ClassID = '$classID', Date = '$date', Status = '$status' WHERE AttendanceID = '$attendanceID'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Attendance updated successfully!";
    } else {
        echo "Error: " . $updateQuery . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Attendance</title>
</head>
<body>
    <h1>Edit Attendance</h1>
    <form action="edit_attendance.php?id=<?php echo $attendance['AttendanceID']; ?>" method="POST">
        <label for="studentID">Student ID:</label><br>
        <input type="number" id="studentID" name="studentID" value="<?php echo $attendance['StudentID']; ?>" required><br><br>

        <label for="classID">Class ID:</label><br>
        <input type="number" id="classID" name="classID" value="<?php echo $attendance['ClassID']; ?>" required><br><br>

        <label for="date">Date:</label><br>
        <input type="date" id="date" name="date" value="<?php echo $attendance['Date']; ?>" required><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="Present" <?php echo ($attendance['Status'] == 'Present') ? 'selected' : ''; ?>>Present</option>
            <option value="Absent" <?php echo ($attendance['Status'] == 'Absent') ? 'selected' : ''; ?>>Absent</option>
        </select><br><br>

        <button type="submit">Update Attendance</button>
    </form>

    <br><br>
    <a href="attendance.php">Back to Attendance Management</a>
</body>
</html>
