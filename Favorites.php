<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShowPick - Favorites</title>
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
            margin: 20px 0;
        }

        .content {
            margin: 20px auto;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .movie-card {
            background: #3e3e58;
            margin: 10px;
            padding: 10px;
            width: 270px;
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
    <h1>Your Favorites</h1>
    <div class="content">
        <?php if (!empty($favorites)): ?>
            <?php foreach ($favorites as $favorite): ?>
                <div class="movie-card">
                    <img src="<?= htmlspecialchars($favorite['image_url']) ?>" alt="<?= htmlspecialchars($favorite['title']) ?>">
                    <h3><?= htmlspecialchars($favorite['title']) ?></h3>
                    <form method="POST" action="remove_favorite.php">
                        <input type="hidden" name="movie_id" value="<?= htmlspecialchars($favorite['id']) ?>">
                        <button class="remove-button" type="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No favorites added yet. Browse movies and add them to your list!</p>
        <?php endif; ?>
    </div>
    <div class="back-home">
        <a href="home.php"><button>Back to Home</button></a>
    </div>
</body>
</html>
