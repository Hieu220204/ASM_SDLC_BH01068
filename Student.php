<?php
session_start();
include('db.php');

// Role-based access control
if (!isset($_SESSION['UserID'])) {
    header("Location: home.php");
    exit;
}

// Handle Add, Edit, Delete actions (only Admin or Teacher can do this)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher')) {
    $action = $_POST['action'];

    if ($action == 'Add') {
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $dateOfBirth = $_POST['DateOfBirth'];
        $gender = $_POST['Gender'];
        $enrollmentDate = $_POST['EnrollmentDate'];
        $classID = $_POST['ClassID'];

        $query = "INSERT INTO student (FirstName, LastName, DateOfBirth, Gender, EnrollmentDate, ClassID) 
                  VALUES ('$firstName', '$lastName', '$dateOfBirth', '$gender', '$enrollmentDate', $classID)";
        mysqli_query($conn, $query);
    } elseif ($action == 'Edit') {
        $studentID = $_POST['StudentID'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $dateOfBirth = $_POST['DateOfBirth'];
        $gender = $_POST['Gender'];
        $enrollmentDate = $_POST['EnrollmentDate'];
        $classID = $_POST['ClassID'];

        $query = "UPDATE Student 
                  SET FirstName='$firstName', LastName='$lastName', DateOfBirth='$dateOfBirth', Gender='$gender', 
                      EnrollmentDate='$enrollmentDate', ClassID=$classID 
                  WHERE StudentID=$studentID";
        mysqli_query($conn, $query);
    } elseif ($action == 'Delete') {
        $studentID = $_POST['StudentID'];
        // Delete related records in attendance table first
        $deleteAttendanceQuery = "DELETE FROM attendance WHERE StudentID = ?";
        $stmt = mysqli_prepare($conn, $deleteAttendanceQuery);
        mysqli_stmt_bind_param($stmt, 'i', $studentID);
        mysqli_stmt_execute($stmt);

        // Then delete the student record
        $deleteStudentQuery = "DELETE FROM student WHERE StudentID = ?";
        $stmt = mysqli_prepare($conn, $deleteStudentQuery);
        mysqli_stmt_bind_param($stmt, 'i', $studentID);
        mysqli_stmt_execute($stmt);
    }
}

// Fetch students from the database
$result = mysqli_query($conn, "SELECT * FROM student");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <link rel="stylesheet" type="text/css" href="student.css">
    <a href="home.php">Back to Home</a>
</head>
<body>
    <h2>Manage Students</h2>
    <?php if ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher'): ?>
    <!-- Form for Admin or Teacher to add a new student -->
    <form method="POST">
        <input type="text" name="FirstName" placeholder="First Name" required>
        <input type="text" name="LastName" placeholder="Last Name" required>
        <input type="date" name="DateOfBirth" required>
        <input type="text" name="Gender" placeholder="Gender" required>
        <input type="date" name="EnrollmentDate" required>
        <input type="text" name="ClassID" placeholder="Class ID" required>
        <button type="submit" name="action" value="Add">Add</button>
    </form>
    <?php endif; ?>
    
    <h3>Student List</h3>
    <table border="1">
        <tr>
            <th>StudentID</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>DateOfBirth</th>
            <th>Gender</th>
            <th>EnrollmentDate</th>
            <th>ClassID</th>
            <?php if ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher'): ?>
            <th>Actions</th>
            <?php endif; ?>
            <th>View Class</th> <!-- Add View Class Column -->
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <form method="POST">
                <td><?= $row['StudentID'] ?><input type="hidden" name="StudentID" value="<?= $row['StudentID'] ?>"></td>
                <td><input type="text" name="FirstName" value="<?= $row['FirstName'] ?>"></td>
                <td><input type="text" name="LastName" value="<?= $row['LastName'] ?>"></td>
                <td><input type="date" name="DateOfBirth" value="<?= $row['DateOfBirth'] ?>"></td>
                <td><input type="text" name="Gender" value="<?= $row['Gender'] ?>"></td>
                <td><input type="date" name="EnrollmentDate" value="<?= $row['EnrollmentDate'] ?>"></td>
                <td><input type="text" name="ClassID" value="<?= $row['ClassID'] ?>"></td>
                <?php if ($_SESSION['Role'] == 'Admin' || $_SESSION['Role'] == 'Teacher'): ?>
                <td>
                    <button type="submit" name="action" value="Edit">Edit</button>
                    <button type="submit" name="action" value="Delete" onclick="return confirm('Are you sure?')">Delete</button>
                </td>
                <?php endif; ?>
                <td>
                    <a href="view_class.php?StudentID=<?= $row['StudentID'] ?>">View Class</a> <!-- Link to view class -->
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
