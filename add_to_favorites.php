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

    // Check if the form was submitted and movie_id is present
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['movie_id'])) {
        $movieId = $_POST['movie_id'];
        $userId = $_SESSION['user']['id']; // Use the user ID from the session

        // Check if the movie is already in the user's favorites
        $stmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id = :user_id AND movie_id = :movie_id");
        $stmt->execute([':user_id' => $userId, ':movie_id' => $movieId]);

        if ($stmt->rowCount() == 0) {
            // If not already in favorites, insert it
            $stmt = $pdo->prepare("INSERT INTO favorites (user_id, movie_id) VALUES (:user_id, :movie_id)");
            $stmt->execute([':user_id' => $userId, ':movie_id' => $movieId]);

            // Redirect to the favorites page after adding
            header('Location: favorites.php');
            exit();
        } else {
            // If already in favorites, show a message
            $error = "This movie is already in your favorites.";
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorites</title>
</head>
<body>
    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <h1>Movie added to your favorites!</h1>
    <a href="favorites.php">Go to Your Favorites</a>
</body>
</html>
