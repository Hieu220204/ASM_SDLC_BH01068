<?php
session_start();
include('db.php');

// Role-based access control
if (!isset($_SESSION['UserID']) || $_SESSION['Role'] == 'Student') {
    header("Location: home.php");
    exit;
}

// Handle Add, Edit, Delete actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['Role'] == 'Admin') {
    $action = $_POST['action'];

    if ($action == 'Add') {
        $className = $_POST['ClassName'];
        $classDescription = $_POST['ClassDescription'];
        $teacherID = $_POST['TeacherID'];

        $query = "INSERT INTO Class (ClassName, ClassDescription, TeacherID) 
                  VALUES ('$className', '$classDescription', $teacherID)";
        mysqli_query($conn, $query);
    } elseif ($action == 'Edit') {
        $classID = $_POST['ClassID'];
        $className = $_POST['ClassName'];
        $classDescription = $_POST['ClassDescription'];
        $teacherID = $_POST['TeacherID'];

        $query = "UPDATE Class 
                  SET ClassName='$className', ClassDescription='$classDescription', TeacherID=$teacherID 
                  WHERE ClassID=$classID";
        mysqli_query($conn, $query);
    } elseif ($action == 'Delete') {
        $classID = $_POST['ClassID'];
        $query = "DELETE FROM Class WHERE ClassID=$classID";
        mysqli_query($conn, $query);
    }
}

// Fetch classes from the database
$result = mysqli_query($conn, "SELECT * FROM Class");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Class Management</title>
    <link rel="stylesheet" type="text/css" href="class.css">


    <a href="home.php">Back to Home</a>
</head>
<body>
    <h2>Manage Classes</h2>
    <?php if ($_SESSION['Role'] == 'Admin'): ?>
    <form method="POST">
        <input type="text" name="ClassName" placeholder="Class Name" required>
        <input type="text" name="ClassDescription" placeholder="Class Description" required>
        <input type="text" name="TeacherID" placeholder="Teacher ID" required>
        <button type="submit" name="action" value="Add">Add</button>
    </form>
    <?php endif; ?>

    <h3>Class List</h3>
    <table border="1">
        <tr>
            <th>ClassID</th>
            <th>ClassName</th>
            <th>ClassDescription</th>
            <th>TeacherID</th>
            <?php if ($_SESSION['Role'] == 'Admin'): ?>
            <th>Actions</th>
            <?php endif; ?>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <form method="POST">
                <td><?= $row['ClassID'] ?><input type="hidden" name="ClassID" value="<?= $row['ClassID'] ?>"></td>
                <td><input type="text" name="ClassName" value="<?= $row['ClassName'] ?>"></td>
                <td><input type="text" name="ClassDescription" value="<?= $row['ClassDescription'] ?>"></td>
                <td><input type="text" name="TeacherID" value="<?= $row['TeacherID'] ?>"></td>
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
