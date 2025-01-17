<?php
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

// Get movie ID from query string
$movieId = $_GET['movie_id'] ?? null;

if (!$movieId) {
    die("Invalid movie ID.");
}

// Fetch movie details
$query = "SELECT * FROM movies WHERE id = :movie_id";
$stmt = $pdo->prepare($query);
$stmt->execute([':movie_id' => $movieId]);
$movie = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if movie was found
if (!$movie) {
    die("Movie not found.");
}

<<<<<<< HEAD
// Debugging: check the contents of $movie
// var_dump($movie); // Uncomment this line to debug

// Function to convert YouTube watch URL to embed URL
=======
// Display success/error message if available
$successMessage = $_SESSION['success_message'] ?? null;
$errorMessage = $_SESSION['error_message'] ?? null;

// Clear messages after displaying
unset($_SESSION['success_message'], $_SESSION['error_message']);

// Function to convert YouTube URL to embed URL
>>>>>>> b787ff3cdd4b36fff67adf15908425d60be0c4dc
function convertToEmbedUrl($url) {
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return "https://www.youtube.com/embed/" . $matches[1];
    }
<<<<<<< HEAD
    return $url;
=======
    return $url; // Return as is if not a YouTube watch URL
>>>>>>> b787ff3cdd4b36fff67adf15908425d60be0c4dc
}

// Convert Trailer URL to embed URL
$embedUrl = convertToEmbedUrl($movie['Trailers']);

// Fetch existing comments for the movie
$queryComments = "
    SELECT c.comment, c.rating, u.username 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    WHERE movie_id = :movie_id 
    ORDER BY c.created_at DESC";
$stmtComments = $pdo->prepare($queryComments);
$stmtComments->execute([':movie_id' => $movieId]);
$comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
    
    // Insert comment into database
    $insertQuery = "INSERT INTO comments (movie_id, user_id, comment, rating) VALUES (:movie_id, :user_id, :comment, :rating)";
    $stmtInsert = $pdo->prepare($insertQuery);
    $stmtInsert->execute([
        ':movie_id' => $movieId,
        ':user_id' => $_SESSION['user']['id'],
        ':comment' => $comment,
        ':rating' => $rating
    ]);
    header("Location: movie_details.php?movie_id=$movieId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShowPick - Movie Details</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1c1c2e, #3e3e58);
            color: #f4f4f4;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #3e3e58;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        /* Movie Poster */
        .movie-poster {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        /* Titles and Text */
        h1 {
            font-size: 28px;
            color: #ffcc00;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        /* Trailer */
        iframe {
            width: 100%;
            height: 400px;
            border: none;
            border-radius: 10px;
            margin-top: 20px;
        }

        /* Action Buttons */
        .action-buttons {
            margin-top: 20px;
        }

        .action-buttons button {
            background: #ffcc00;
            color: #1c1c2e;
            border: none;
            padding: 10px 20px;
            margin: 5px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .action-buttons button:hover {
            background: #f9a825;
        }

        /* Message Styles */
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .comments-section {
            margin-top: 30px;
            text-align: left;
        }

        .comments-section h2 {
            margin-bottom: 10px;
        }

        .comments-section textarea {
            width: 100%;
            margin-bottom: 10px;
        }

        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            color: #ccc;
            cursor: pointer;
        }

        .star-rating input:checked ~ label {
            color: #ffcc00;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffcc00;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($successMessage): ?>
            <div class="message success"><?= htmlspecialchars($successMessage) ?></div>
        <?php elseif ($errorMessage): ?>
            <div class="message error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <img src="<?= htmlspecialchars($movie['image_url']) ?>" alt="Movie Poster" class="movie-poster">
        <h1><?= htmlspecialchars($movie['title']) ?></h1>
        <p><strong>Genre:</strong> <?= htmlspecialchars($movie['genre']) ?></p>
        <p><strong>Age Classification:</strong> <?= htmlspecialchars($movie['age_class']) ?></p>
        <p><strong>Release Year:</strong> <?= htmlspecialchars($movie['Release_Year']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($movie['description']) ?></p>

        <!-- Trailer -->
        <?php if (!empty($embedUrl)): ?>
<<<<<<< HEAD
            <h2>Trailer:</h2>
=======
            <h2 style="color: #ffcc00;">Trailer:</h2>
>>>>>>> b787ff3cdd4b36fff67adf15908425d60be0c4dc
            <iframe src="<?= htmlspecialchars($embedUrl) ?>" allowfullscreen></iframe>
        <?php else: ?>
            <p>No trailer available for this movie.</p>
        <?php endif; ?>

        <div class="action-buttons">
            <form method="POST" action="add_to_favorites.php">
                <input type="hidden" name="movie_id" value="<?= htmlspecialchars($movie['id']) ?>">
                <button type="submit">Add to Favorites</button>
            </form>
            <a href="home.php"><button>Back to Home</button></a>
        </div>
        
        <div class="comments-section">
            <h2>User Comments:</h2>
            <form method="POST" action="">
                <textarea name="comment" rows="4" required placeholder="Leave a comment..."></textarea>
                <br>
                <div class="star-rating">
                    <input type="radio" id="star1" name="rating" value="5" required>
                    <label for="star1">&#9733;</label>
                    <input type="radio" id="star2" name="rating" value="4">
                    <label for="star2">&#9733;</label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3">&#9733;</label>
                    <input type="radio" id="star4" name="rating" value="2">
                    <label for="star4">&#9733;</label>
                    <input type="radio" id="star5" name="rating" value="1">
                    <label for="star5">&#9733;</label>
                </div>
                <br>
                <button type="submit">Submit Comment</button>
            </form>

            <?php if ($comments): ?>
                <ul class="comments-list">
                    <?php foreach ($comments as $c): ?>
                        <li>
                            <strong><?= htmlspecialchars($c['username']) ?> (<?= htmlspecialchars($c['rating']) ?> Star<?= $c['rating'] > 1 ? 's' : '' ?>):</strong>
                            <p><?= htmlspecialchars($c['comment']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>