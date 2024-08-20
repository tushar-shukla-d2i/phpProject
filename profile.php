<?php
session_start();

// Check is user loggedIn
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
include 'db_connect.php';

try {
    // Prepare an SQL statement to retrieve the user data
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $_SESSION['user_id']);
    $stmt->execute();

    // Fetch the user data
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <div class="container">
        <h2>Profile of <?php echo htmlspecialchars($user['name']); ?></h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
        <p><strong>Profile Photo:</strong><br>
            <img src="uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo" style="max-width: 200px;" />
        </p>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>

</html>