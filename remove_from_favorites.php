<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("User is not logged in.");
}

$host = 'localhost'; // Replace with your host
$dbname = 'ShowPick'; // Replace with your actual database name
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the movie_id is passed
    if (isset($_POST['movie_id'])) {
        $movieId = $_POST['movie_id'];
        $userId = $_SESSION['user']['id']; // Get the logged-in user ID from session

        // Remove the movie from favorites
        $stmt = $pdo->prepare("DELETE FROM favorites WHERE user_id = :user_id AND movie_id = :movie_id");
        $stmt->execute([':user_id' => $userId, ':movie_id' => $movieId]);

        // Redirect back to favorites page after removal
        header('Location: favorites.php');
        exit();
    } else {
        die("Movie ID not provided.");
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
