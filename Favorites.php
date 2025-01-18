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
    <link rel="shortcut icon" href="ShowPick icon.png">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1c1c2e, #3e3e58);
            color: #f4f4f4;
        }

        h1 {
            font-size: 28px;
            color: #ffcc00;
            text-align: center;
            margin-top: 20px;
        }

        .content {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            justify-content: center;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .movie-card {
            background: #3e3e58;
            padding: 10px;
            text-align: center;
            border-radius: 10px;
            border: 2px solid #ffcc00;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .movie-card img {
            width: 100%;
            height: auto;
            border-radius: 5px;
        }

        .movie-card h3 {
            color: #ffcc00;
            margin: 10px 0;
        }

        .remove-button {
            background: #f44336;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .remove-button:hover {
            background: #d32f2f;
        }

        .back-home {
            text-align: center;
            margin-top: 20px;
        }

        .back-home a button {
            background: #ffcc00;
            color: #1c1c2e;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .back-home a button:hover {
            background: #f9a825;
        }
    </style>
</head>
<body>
    <h1>Your Favorite Movies</h1>
    <div class="content">
        <?php if (count($favorites) > 0): ?>
            <?php foreach ($favorites as $movie): ?>
                <div class="movie-card">
                    <img src="<?php echo htmlspecialchars($movie['image_url']); ?>" alt="Movie Poster">
                    <h3><?php echo htmlspecialchars($movie['title']); ?></h3>
                    <form method="POST" action="remove_from_favorites.php">
                        <input type="hidden" name="movie_id" value="<?php echo htmlspecialchars($movie['id']); ?>">
                        <button class="remove-button" type="submit">Remove from Favorites</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You don't have any favorites yet.</p>
        <?php endif; ?>
    </div>
    <div class="back-home">
        <a href="home.php"><button>Back to Home</button></a>
    </div>
</body>
</html>
