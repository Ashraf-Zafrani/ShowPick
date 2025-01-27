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

if (!$movie) {
    die("Movie not found.");
}

// Function to convert YouTube URL to embed URL
function convertToEmbedUrl($url) {
    if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
        return "https://www.youtube.com/embed/" . $matches[1];
    }
    return $url; // Return as is if not a YouTube watch URL
}

// Convert Trailer URL to embed URL
$embedUrl = convertToEmbedUrl($movie['Trailers']);

// Check if the movie is already in favorites
$userId = $_SESSION['user']['id'];
$queryFavorites = "SELECT * FROM favorites WHERE movie_id = :movie_id AND user_id = :user_id";
$stmtFavorites = $pdo->prepare($queryFavorites);
$stmtFavorites->execute([':movie_id' => $movieId, ':user_id' => $userId]);
$isFavorite = $stmtFavorites->fetch(PDO::FETCH_ASSOC);

// Handle adding to favorites
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_favorites'])) {
    if (!$isFavorite) {
        $insertFavorite = "INSERT INTO favorites (movie_id, user_id) VALUES (:movie_id, :user_id)";
        $stmtInsertFavorite = $pdo->prepare($insertFavorite);
        $stmtInsertFavorite->execute([':movie_id' => $movieId, ':user_id' => $userId]);
        $successMessage = "Movie added to favorites.";
    } else {
        $errorMessage = "This movie is already in your favorites.";
    }
}

// Fetch existing comments for the movie
$queryComments = "
    SELECT c.comment, c.rating, u.username, c.id, c.user_id 
    FROM comments c 
    JOIN users u ON c.user_id = u.id 
    WHERE movie_id = :movie_id 
    ORDER BY c.created_at DESC";
$stmtComments = $pdo->prepare($queryComments);
$stmtComments->execute([':movie_id' => $movieId]);
$comments = $stmtComments->fetchAll(PDO::FETCH_ASSOC);

// Calculate average rating
$totalRating = 0;
$numberOfRatings = count($comments);

if ($numberOfRatings > 0) {
    foreach ($comments as $c) {
        $totalRating += $c['rating'];
    }
    $averageRating = $totalRating / $numberOfRatings;
} else {
    $averageRating = 0;
}

// Handle comment submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $rating = $_POST['rating'];
   
    // Check if the user has already commented on this movie
    $checkCommentQuery = "SELECT * FROM comments WHERE movie_id = :movie_id AND user_id = :user_id";
    $stmtCheckComment = $pdo->prepare($checkCommentQuery);
    $stmtCheckComment->execute([':movie_id' => $movieId, ':user_id' => $userId]);
    $existingComment = $stmtCheckComment->fetch(PDO::FETCH_ASSOC);

    if (!$existingComment) {
        // Insert comment into database if it doesn't exist
        $insertQuery = "INSERT INTO comments (movie_id, user_id, comment, rating) VALUES (:movie_id, :user_id, :comment, :rating)";
        $stmtInsert = $pdo->prepare($insertQuery);
        $stmtInsert->execute([
            ':movie_id' => $movieId,
            ':user_id' => $userId,
            ':comment' => $comment,
            ':rating' => $rating
        ]);

        // Redirect to the same movie details page to display the new comment
        header("Location: detail.php?movie_id=$movieId");
        exit();
    } else {
        $errorMessage = "You can only submit one comment per movie.";
    }
}

// Handle comment editing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_comment'])) {
    $commentId = $_POST['comment_id'];
    
    // Fetch the existing comment
    $queryComment = "SELECT * FROM comments WHERE id = :comment_id AND user_id = :user_id";
    $stmtComment = $pdo->prepare($queryComment);
    $stmtComment->execute([':comment_id' => $commentId, ':user_id' => $userId]);
    $existingComment = $stmtComment->fetch(PDO::FETCH_ASSOC);

    if ($existingComment) {
        // Show a form to edit the comment
        $editComment = true;
        $commentToEdit = $existingComment['comment'];
        $ratingToEdit = $existingComment['rating'];
        $commentIdToEdit = $existingComment['id'];
    }
}

// Handle comment update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_comment'])) {
    $commentId = $_POST['comment_id'];
    $updatedComment = $_POST['comment'];
    $updatedRating = $_POST['rating'];

    // Update the comment in the database
    $updateQuery = "UPDATE comments SET comment = :comment, rating = :rating WHERE id = :comment_id AND user_id = :user_id";
    $stmtUpdate = $pdo->prepare($updateQuery);
    $stmtUpdate->execute([
        ':comment' => $updatedComment,
        ':rating' => $updatedRating,
        ':comment_id' => $commentId,
        ':user_id' => $userId
    ]);

    // Redirect to the same movie details page
    header("Location: detail.php?movie_id=$movieId");
    exit();
}

// Handle comment deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment'])) {
    $commentId = $_POST['comment_id'];

    // Delete the comment from the database
    $deleteQuery = "DELETE FROM comments WHERE id = :comment_id AND user_id = :user_id";
    $stmtDelete = $pdo->prepare($deleteQuery);
    $stmtDelete->execute([':comment_id' => $commentId, ':user_id' => $userId]);

    // Redirect to the same movie details page
    header("Location: detail.php?movie_id=$movieId");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShowPick - Movie/Series Details</title>
    <link rel="shortcut icon" href="ShowPick icon.png">
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

        .movie-poster {
            width: 100%;
            max-width: 400px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            color: #ffcc00;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        .average-rating {
            font-size: 20px;
            margin: 10px 0;
        }

        .star-rating {
            color: #ffcc00;
            font-size: 24px;
            cursor: pointer;
        }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
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
            flex: 1;
            margin: 0 10px;
        }

        .action-buttons button:hover {
            background: #f9a825;
        }

        .comments-section {
            margin-top: 30px;
            text-align: left;
        }

        .comments-section h2 {
            margin-bottom: 10px;
        }

        .comments-section textarea {
            width: 95%;
            height: 100px;
            margin-bottom: 10px;
            resize: none;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #444;
            color: #f4f4f4;
        }

        .comments-section button {
            background: #ffcc00;
            color: #1c1c2e;
            border: none;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .comments-section button:hover {
            background: #f9a825;
        }

        .comments-list {
            list-style: none;
            padding: 0;
        }

        .comments-list li {
            margin-bottom: 10px;
            padding: 10px;
            background: #444;
            border-radius: 5px;
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

        /* Trailer Styles */
        iframe {
            width: 100%;
            height: 400px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (isset($successMessage)): ?>
            <div class="message success"><?= htmlspecialchars($successMessage) ?></div>
        <?php elseif (isset($errorMessage)): ?>
            <div class="message error"><?= htmlspecialchars($errorMessage) ?></div>
        <?php endif; ?>

        <img src="<?= htmlspecialchars($movie['image_url']) ?>" alt="Movie Poster" class="movie-poster">
        <h1><?= htmlspecialchars($movie['title']) ?></h1>
        <p><strong>Genre:</strong> <?= htmlspecialchars($movie['genre']) ?></p>
        <p><strong>Age Classification:</strong> <?= htmlspecialchars($movie['age_class']) ?></p>
        <p><strong>Release Year:</strong> <?= htmlspecialchars($movie['Release_Year']) ?></p>
        <p><strong>Description:</strong> <?= htmlspecialchars($movie['description']) ?></p>

        <!-- Average Rating Display -->
        <div class="average-rating">
            <strong>Average Rating: </strong>
            <?= number_format($averageRating, 1) ?> / 5.0 (<?= $numberOfRatings ?> user<?= $numberOfRatings === 1 ? '' : 's' ?>)
            <div class="star-rating">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span style="color: <?= $i <= $averageRating ? '#ffcc00' : '#ccc' ?>;">&#9733;</span>
                <?php endfor; ?>
            </div>
        </div>

        <?php if (!empty($embedUrl)): ?>
            <h2>Trailer:</h2>
            <iframe src="<?= htmlspecialchars($embedUrl) ?>" allowfullscreen></iframe>
        <?php else: ?>
            <p>No trailer available.</p>
        <?php endif; ?>

        <div class="action-buttons">
            <form method="POST" action="">
                <input type="hidden" name="add_to_favorites" value="1">
                <button type="submit">Add to Favorites</button>
            </form>
            <a href="home.php">
                <button>Back to Home</button>
            </a>
        </div>
        
        <div class="comments-section">
            <h2>User Comments:</h2>
            <form method="POST" action="">
                <textarea name="comment" required placeholder="Leave a comment..."></textarea>
                <br>
                <div class="star-rating" id="user-rating" data-rating="0">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="1" required>
                <br>
                <button type="submit">Submit Comment</button>
            </form>

            <?php if (isset($editComment) && $editComment): ?>
                <h2>Edit Your Comment:</h2>
                <form method="POST" action="">
                    <textarea name="comment" required><?= htmlspecialchars($commentToEdit) ?></textarea>
                    <br>
                    <div class="star-rating" id="user-rating-edit" data-rating="<?= htmlspecialchars($ratingToEdit) ?>">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>
                    <input type="hidden" name="rating" id="rating_edit" value="<?= htmlspecialchars($ratingToEdit) ?>" required>
                    <input type="hidden" name="comment_id" value="<?= htmlspecialchars($commentIdToEdit) ?>">
                    <input type="hidden" name="update_comment" value="1">
                    <br>
                    <button type="submit">Update Comment</button>
                </form>
            <?php endif; ?>

            <?php if ($comments): ?>
                <ul class="comments-list">
                    <?php foreach ($comments as $c): ?>
                        <li>
                            <strong><?= htmlspecialchars($c['username']) ?> (<?= htmlspecialchars($c['rating']) ?> Star<?= $c['rating'] > 1 ? 's' : '' ?>):</strong>
                            <div class="star-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span style="color: <?= $i <= $c['rating'] ? '#ffcc00' : '#ccc' ?>;">&#9733;</span>
                                <?php endfor; ?>
                            </div>
                            <p><?= htmlspecialchars($c['comment']) ?></p>
                            <?php if ($c['user_id'] == $userId): ?>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="comment_id" value="<?= htmlspecialchars($c['id']) ?>">
                                    <input type="hidden" name="edit_comment" value="1">
                                    <button type="submit">Edit</button>
                                </form>
                                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="comment_id" value="<?= htmlspecialchars($c['id']) ?>">
                                    <input type="hidden" name="delete_comment" value="1">
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this comment?');">Delete</button>
                                </form>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>No comments yet.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function setRating(rating, starElements) {
            starElements.forEach(star => {
                star.style.color = star.getAttribute('data-value') <= rating ? '#ffcc00' : '#ccc';
            });
        }

        const starsNew = document.querySelectorAll('#user-rating .star');
        const ratingInputNew = document.getElementById('rating');

        starsNew.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-value');
                ratingInputNew.value = rating;
                setRating(rating, starsNew);
            });
        });

        // For the edit section
        const starsEdit = document.querySelectorAll('#user-rating-edit .star');
        const ratingInputEdit = document.getElementById('rating_edit');

        starsEdit.forEach(star => {
            star.addEventListener('click', () => {
                const rating = star.getAttribute('data-value');
                ratingInputEdit.value = rating;
                setRating(rating, starsEdit);
            });
        });

        // Initialize ratings
        setRating(0, starsNew);
        setRating(document.getElementById('user-rating-edit').getAttribute('data-rating'), starsEdit);
    </script>
</body>
</html>