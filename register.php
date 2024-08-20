<?php
include 'db_connect.php'; // database connection file

// Checks our fomr submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Capture and sanitize the form data
    $name = htmlspecialchars($_POST['name']);
    $age = (int) $_POST['age'];
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Handle the file upload
    $profile_photo = $_FILES['profile_photo']['name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_photo);
    if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $target_file)) {
        echo "File uploaded successfully.";
    } else {
        echo "File upload failed.";
    }

    try {
        // SQL statement to insert the user data
        $stmt = $pdo->prepare("INSERT INTO users (name, age, email, profile_photo, password) 
                               VALUES (:name, :age, :email, :profile_photo, :password)");

        // Bind parameters to prepared statement
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':profile_photo', $profile_photo);
        $stmt->bindParam(':password', $password);

        $stmt->execute();

        echo "New record created successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="./styles.css">

</head>

<body>
    <div class="container">
        <h2>User Registration</h2>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" required><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <label for="profile_photo">Profile Photo:</label>
            <input type="file" id="profile_photo" name="profile_photo"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>

            <input type="submit" name="register" value="Register">
        </form>
        <div>
            <p>Already Have an Account?? <a href="login.php">Login</a> </p>
        </div>
    </div>
</body>

</html>