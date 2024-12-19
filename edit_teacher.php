<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $teacherID = $_GET['id'];
    $query = "SELECT * FROM Teacher WHERE TeacherID = '$teacherID'";
    $result = mysqli_query($conn, $query);
    $teacher = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated data from form
    $name = $_POST['name'];
    $department = $_POST['department'];

    // Update the record in the database
    $updateQuery = "UPDATE Teacher SET Name = '$name', Department = '$department' WHERE TeacherID = '$teacherID'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Teacher updated successfully!";
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
    <title>Edit Teacher</title>
</head>
<body>
    <h1>Edit Teacher</h1>
    <form action="edit_teacher.php?id=<?php echo $teacher['TeacherID']; ?>" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $teacher['Name']; ?>" required><br><br>

        <label for="department">Department:</label><br>
        <input type="text" id="department" name="department" value="<?php echo $teacher['Department']; ?>" required><br><br>

        <button type="submit">Update Teacher</button>
    </form>

    <br><br>
    <a href="teacher.php">Back to Teacher Management</a>
</body>
</html>
