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
// Fetch movies if filters are set
$movies = [];
$searchTerm = $_GET['search'] ?? '';
$ageClass = $_GET['age_class'] ?? '';
$genre = $_GET['genre'] ?? '';
$isFiltered = isset($_GET['filter']); // Check if the filter button was used

if ($isFiltered) {
    $query = "SELECT * FROM movies WHERE 1=1";
    $params = [];

    // Apply search term filter
    if (!empty($searchTerm)) {
        $query .= " AND LOWER(title) LIKE :search_term";
        $params[':search_term'] = '%' . strtolower($searchTerm) . '%';
    }

    // Apply age classification filter
    if (!empty($ageClass) && $ageClass !== 'all') {
        $query .= " AND age_class = :age_class";
        $params[':age_class'] = $ageClass;
    }

    // Apply genre filter
    if (!empty($genre) && $genre !== 'all') {
        $query .= " AND genre = :genre";
        $params[':genre'] = $genre;
    }

    // Execute query
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Fetch 10 random movies if no filters are applied
    $query = "SELECT * FROM movies ORDER BY RAND() LIMIT 10";
    $stmt = $pdo->query($query);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Set dynamic title
if (!$isFiltered) {
    $title = "Random Movies/Series"; // Default title after login
} else {
    if (empty($searchTerm) && $ageClass === 'all' && $genre === 'all') {
        $title = "All Movies/Series"; // Title for all filters selected as "All"
    } else {
        $filters = [];
        if (!empty($searchTerm)) {
            $filters[] = "Search: " . htmlspecialchars($searchTerm);
        }
        if (!empty($ageClass) && $ageClass !== 'all') {
            $filters[] = "Age Class: " . htmlspecialchars($ageClass);
        }
        if (!empty($genre) && $genre !== 'all') {
            $filters[] = "Genre: " . htmlspecialchars($genre);
        }
        $title = implode(", ", $filters);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <title>ShowPick - Home</title>
</head>
<body>
    <div id="search-section">
        <div id="logo-container">
            <img src="ShowPick icon.png" id="header-logo" alt="ShowPick Logo">
            <h1>ShowPick</h1>
        </div>
        <div id="search-container">
            <form method="GET" action="">
                <input type="text" id="search-bar" name="search" placeholder="Search...">
                <select name="age_class" class="dropdown">
                    <option value="all" selected>All</option>
                    <option value="kids">Kids</option>
                    <option value="adult">Adult</option>
                </select>
                <select name="genre" class="dropdown">
                    <option value="all" selected>All</option>
                    <option value="action">Action</option>
                    <option value="comedy">Comedy</option>
                    <option value="horror">Horror</option>
                    <option value="drama">Drama</option>
                    <option value="romance">Romance</option>
                </select>
                <button type="submit" name="filter" id="search-button">Search</button>
            </form>
        </div>
        <div id="logout-container">
            <form method="POST" action="logout.php">
                <button type="submit" id="logout-button">Logout</button>
            </form>
        </div>
    </div>

    <div id="random-movies-title"><?= htmlspecialchars($title) ?></div>

    <div id="content">
    <?php if (!empty($movies)): ?>
        <?php foreach ($movies as $movie): ?>
            <div class="movie-card">
                <a href="detail.php?movie_id=<?= urlencode($movie['id']) ?>">
                    <img src="<?= htmlspecialchars($movie['image_url']) ?>" alt="<?= htmlspecialchars($movie['title']) ?>">
                </a>
                <h3><?= htmlspecialchars($movie['title']) ?></h3>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No movies found. Use the search to find content.</p>
    <?php endif; ?>
    </div>

</body>
</html>
