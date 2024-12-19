<?php
session_start();
if ($_SESSION['role'] != 'Admin') {
    header("Location: home.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $name = $_POST['name'];
    $department = $_POST['department'];

    // Insert data into database
    $query = "INSERT INTO Teacher (Name, Department) VALUES ('$name', '$department')";
    if (mysqli_query($conn, $query)) {
        echo "New teacher added successfully!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Teacher</title>
</head>
<body>
    <h1>Add New Teacher</h1>
    <form action="add_teacher.php" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="department">Department:</label><br>
        <input type="text" id="department" name="department" required><br><br>

        <button type="submit">Add Teacher</button>
    </form>

    <br><br>
    <a href="teacher.php">Back to Teacher Management</a>
</body>
</html>
