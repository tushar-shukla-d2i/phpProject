<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

try {
    // Prepare an SQL statement to retrieve all users
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
    <div class="container">
        <h2>Registered Users</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Profile Photo</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['id']); ?></td>
                        <td><?php echo htmlspecialchars($user['name']); ?></td>
                        <td><?php echo htmlspecialchars($user['age']); ?></td>
                        <td><?php echo htmlspecialchars($user['email']); ?></td>
                        <td><img src="uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" alt="Profile Photo" style="max-width: 100px;" /></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><a href="dashboard.php">Back to Dashboard</a></p>
    </div>
</body>

</html>