<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from form
    $className = $_POST['className'];

    // Insert data into database
    $query = "INSERT INTO Class (ClassName) VALUES ('$className')";
    if (mysqli_query($conn, $query)) {
        echo "New class added successfully!";
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
    <title>Add Class</title>
</head>
<body>
    <h1>Add New Class</h1>
    <form action="add_class.php" method="POST">
        <label for="className">Class Name:</label><br>
        <input type="text" id="className" name="className" required><br><br>

        <button type="submit">Add Class</button>
    </form>

    <br><br>
    <a href="class.php">Back to Class Management</a>
</body>
</html>
