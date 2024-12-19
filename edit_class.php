<?php
session_start();
if ($_SESSION['role'] != 'Admin' && $_SESSION['role'] != 'Teacher') {
    header("Location: home.php");
    exit;
}

include('db.php');

if (isset($_GET['id'])) {
    $classID = $_GET['id'];
    $query = "SELECT * FROM Class WHERE ClassID = '$classID'";
    $result = mysqli_query($conn, $query);
    $class = mysqli_fetch_assoc($result);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get updated data from form
    $className = $_POST['className'];

    // Update the record in the database
    $updateQuery = "UPDATE Class SET ClassName = '$className' WHERE ClassID = '$classID'";
    if (mysqli_query($conn, $updateQuery)) {
        echo "Class updated successfully!";
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
    <title>Edit Class</title>
</head>
<body>
    <h1>Edit Class</h1>
    <form action="edit_class.php?id=<?php echo $class['ClassID']; ?>" method="POST">
        <label for="className">Class Name:</label><br>
        <input type="text" id="className" name="className" value="<?php echo $class['ClassName']; ?>" required><br><br>

        <button type="submit">Update Class</button>
    </form>

    <br><br>
    <a href="class.php">Back to Class Management</a>
</body>
</html>
