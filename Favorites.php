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

    // Fetch user's favorite movies
    $stmt = $pdo->prepare("SELECT m.* FROM movies m
                           JOIN favorites f ON m.id = f.movie_id
                           WHERE f.user_id = :user_id");
    $stmt->execute([':user_id' => $_SESSION['user']['id']]);
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorites</title>
</head>
<body>
    <h1>Your Favorite Movies</h1>
    <?php if (count($favorites) > 0): ?>
        <ul>
            <?php foreach ($favorites as $movie): ?>
                <li>
                    <strong><?php echo htmlspecialchars($movie['title']); ?></strong><br>
                    <img src="<?php echo htmlspecialchars($movie['image_url']); ?>" alt="Movie Poster" width="100"><br>
                    <!-- Add Remove Button -->
                    <form method="POST" action="remove_from_favorites.php">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id']); ?>">
                        <button type="submit">Remove from Favorites</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>You don't have any favorites yet.</p>
    <?php endif; ?>
</body>
</html>
