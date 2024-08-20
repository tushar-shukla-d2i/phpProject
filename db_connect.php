<?php
$servername = "localhost"; // or your server IP/hostname
$username = "root"; // or your MySQL username
$password = "admin123"; 
$dbname = "user_management"; // replace with your database name

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
