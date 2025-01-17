<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("User is not logged in.");
}

$host = 'localhost'; // Replace with your host
$dbname = 'ShowPick'; // Replace with your actual database name
$username = 'root'; // Replace with your MySQL username
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
        $movieId = $_POST['movie_id'];
        $userId = $_SESSION['user']['id'];

        // Check if the movie is already in the user's favorites
        $stmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND movie_id = :movie_id");
        $stmt->execute([':user_id' => $userId, ':movie_id' => $movieId]);

        if ($stmt->rowCount() == 0) {
            // Add to favorites
            $stmt = $pdo->prepare("INSERT INTO favorites (user_id, movie_id) VALUES (:user_id, :movie_id)");
            $stmt->execute([':user_id' => $userId, ':movie_id' => $movieId]);
            $_SESSION['success_message'] = "Movie added to your favorites!";
        } else {
            $_SESSION['error_message'] = "This movie is already in your favorites.";
        }
    }

    // Redirect back to the detail page
    header("Location: detail.php?movie_id=" . $_POST['movie_id']);
    exit();
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>