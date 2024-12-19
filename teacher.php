<?php
session_start();
include('db.php');

// Role-based access control
if (!isset($_SESSION['UserID']) || ($_SESSION['Role'] == 'Student')) {
    header("Location: home.php");
    exit;
}

// Handle Add, Edit, Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Role'] == 'Admin') {
    $action = $_POST['action'];

    if ($action == 'Add') {
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $subject = $_POST['Subject'];
        $hireDate = $_POST['HireDate'];

        $query = "INSERT INTO Teacher (FirstName, LastName, Subject, HireDate) VALUES ('$firstName', '$lastName', '$subject', '$hireDate')";
        mysqli_query($conn, $query);
    } elseif ($action == 'Edit') {
        $teacherID = $_POST['TeacherID'];
        $firstName = $_POST['FirstName'];
        $lastName = $_POST['LastName'];
        $subject = $_POST['Subject'];
        $hireDate = $_POST['HireDate'];

        $query = "UPDATE Teacher SET FirstName='$firstName', LastName='$lastName', Subject='$subject', HireDate='$hireDate' WHERE TeacherID=$teacherID";
        mysqli_query($conn, $query);
    } elseif ($action == 'Delete') {
        $teacherID = $_POST['TeacherID'];
        $query = "DELETE FROM Teacher WHERE TeacherID=$teacherID";
        mysqli_query($conn, $query);
    }
}

// Fetch teachers from the database
$result = mysqli_query($conn, "SELECT * FROM Teacher");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Management</title>
    <link rel="stylesheet" type="text/css" href="teacher.css">


    <a href="home.php">Back to Home</a>

</head>
<body>
    <h2>Manage Teachers</h2>
    <?php if ($_SESSION['Role'] == 'Admin'): ?>
    <form method="POST">
        <input type="text" name="FirstName" placeholder="First Name" required>
        <input type="text" name="LastName" placeholder="Last Name" required>
        <input type="text" name="Subject" placeholder="Subject" required>
        <input type="date" name="HireDate" required>
        <button type="submit" name="action" value="Add">Add</button>
    </form>
    <?php endif; ?>
    
    <h3>Teacher List</h3>
    <table border="1">
        <tr>
            <th>TeacherID</th>
            <th>FirstName</th>
            <th>LastName</th>
            <th>Subject</th>
            <th>HireDate</th>
            <?php if ($_SESSION['Role'] == 'Admin'): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <form method="POST">
                <td><?= $row['TeacherID'] ?><input type="hidden" name="TeacherID" value="<?= $row['TeacherID'] ?>"></td>
                <td><input type="text" name="FirstName" value="<?= $row['FirstName'] ?>"></td>
                <td><input type="text" name="LastName" value="<?= $row['LastName'] ?>"></td>
                <td><input type="text" name="Subject" value="<?= $row['Subject'] ?>"></td>
                <td><input type="date" name="HireDate" value="<?= $row['HireDate'] ?>"></td>
                <?php if ($_SESSION['Role'] == 'Admin'): ?>
                <td>
                    <button type="submit" name="action" value="Edit">Edit</button>
                    <button type="submit" name="action" value="Delete" onclick="return confirm('Are you sure?')">Delete</button>
                </td>
                <?php endif; ?>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
