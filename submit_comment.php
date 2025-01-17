<?php
// Start session and verify user login
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'ShowPick';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Handle new comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'], $_POST['rating'], $_POST['movie_id'])) {
    $comment = $_POST['comment'];
    $rating = (int)$_POST['rating'];
    $movieId = (int)$_POST['movie_id'];
    $userId = $_SESSION['user']['id']; // Assuming user ID is stored in session

    if ($rating < 1 || $rating > 5) {
        die("Invalid rating.");
    }

    $insertQuery = "INSERT INTO comments (movie_id, user_id, comment, rating, created_at) VALUES (:movie_id, :user_id, :comment, :rating, NOW())";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute([
        ':movie_id' => $movieId,
        ':user_id' => $userId,
        ':comment' => $comment,
        ':rating' => $rating
    ]);

    header("Location: detail.php?movie_id=$movieId");
    exit();
}
?>
