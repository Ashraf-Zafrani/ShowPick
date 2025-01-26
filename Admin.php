<?php
$servername = "localhost";
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$dbname = "showpick";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle adding a movie
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_movie'])) {
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $trailers = $_POST['trailers'];
    $age_class = $_POST['age_class'];

    $sql = "INSERT INTO movies (title, genre, Release_Year, description, image_url, Trailers, age_class) VALUES ('$title', '$genre', '$release_year', '$description', '$image_url', '$trailers', '$age_class')";
    
    if ($conn->query($sql) === TRUE) {
        echo "New movie added successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle deleting a movie
if (isset($_GET['delete_movie'])) {
    $id = $_GET['delete_movie'];
    $conn->query("DELETE FROM movies WHERE id=$id");
}

// Handle deleting a comment
if (isset($_GET['delete_comment'])) {
    $id = $_GET['delete_comment'];
    $conn->query("DELETE FROM comments WHERE id=$id");
}

// Handle updating a movie
if (isset($_POST['update_movie'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'];
    $release_year = $_POST['release_year'];
    $description = $_POST['description'];
    $image_url = $_POST['image_url'];
    $trailers = $_POST['trailers'];
    $age_class = $_POST['age_class'];

    $sql = "UPDATE movies SET title='$title', genre='$genre', Release_Year='$release_year', description='$description', image_url='$image_url', Trailers='$trailers', age_class='$age_class' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Movie updated successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch movies and comments
$movies = $conn->query("SELECT * FROM movies");
$comments = $conn->query("SELECT * FROM comments");

// Fetch movie for updating
$movie_to_edit = null;
if (isset($_GET['edit_movie'])) {
    $id = $_GET['edit_movie'];
    $movie_to_edit = $conn->query("SELECT * FROM movies WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin & Moderation Interface</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1c1c2e, #3e3e58);
            color: #f4f4f4;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #3e3e58;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        h1 {
            text-align: center;
            color: #ffcc00;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #555;
        }

        table th {
            background: #444;
            color: #fff;
        }

        a {
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
            transition: background 0.3s;
        }

        .edit-button {
            background: #007bff;
        }

        .delete-button {
            background: #dc3545;
        }

        .edit-button:hover {
            background: #0056b3;
        }

        .delete-button:hover {
            background: #c82333;
        }

        .form-container {
            margin-bottom: 20px;
        }

        .form-container input, .form-container textarea, .form-container select {
            width: 96%;
            padding: 15px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background: #2a2a3a;
            color: #fff;
            font-size: 16px;
            transition: border 0.3s, background 0.3s, color 0.3s;
        }

        .form-container input:focus, .form-container textarea:focus, .form-container select:focus {
            border: 1px solid #ffcc00;
            background: #3e3e58;
            color: #fff;
            outline: none;
        }

        .form-container button {
            background: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .form-container button:hover {
            background: #218838;
        }

        .update-section {
            margin-top: 20px;
        }

        .update-section h2 {
            color: #ffcc00;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function showUpdateSection() {
            document.getElementById('update-section').style.display = 'block';
        }
    </script>
        <link rel="shortcut icon" href="ShowPick icon.png">
</head>
<body>
<div class="container">
    <h1>Admin & Moderation Interface</h1>
    
    <div class="form-container">
        <h2>Add New Movie</h2>
        <form method="POST" class="form-container">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="genre" placeholder="Genre" required>
            <input type="number" name="release_year" placeholder="Release Year" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="image_url" placeholder="Image URL" required>
            <input type="text" name="trailers" placeholder="Trailer URL" required>
            <select name="age_class" required>
                <option value="">Select Age Class</option>
                <option value="adult">Adult</option>
                <option value="kids">Kids</option>
            </select>
            <button type="submit" name="add_movie">Add Movie</button>
        </form>
    </div>
    
    <h2>Existing Movies</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Genre</th>
            <th>Release Year</th>
            <th>Actions</th>
        </tr>
        <?php while ($movie = $movies->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($movie['title']); ?></td>
                <td><?php echo htmlspecialchars($movie['genre']); ?></td>
                <td><?php echo htmlspecialchars($movie['Release_Year']); ?></td>
                <td>
                    <a class="edit-button" href="?edit_movie=<?php echo $movie['id']; ?>" onclick="showUpdateSection();">Edit</a> | 
                    <a class="delete-button" href="?delete_movie=<?php echo $movie['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php if ($movie_to_edit): ?>
        <div id="update-section" class="update-section">
            <h2>Update Movie</h2>
            <form method="POST" class="form-container">
                <input type="hidden" name="id" value="<?php echo $movie_to_edit['id']; ?>">
                <input type="text" name="title" value="<?php echo htmlspecialchars($movie_to_edit['title']); ?>" placeholder="Title" required>
                <input type="text" name="genre" value="<?php echo htmlspecialchars($movie_to_edit['genre']); ?>" placeholder="Genre" required>
                <input type="number" name="release_year" value="<?php echo htmlspecialchars($movie_to_edit['Release_Year']); ?>" placeholder="Release Year" required>
                <textarea name="description" placeholder="Description" required><?php echo htmlspecialchars($movie_to_edit['description']); ?></textarea>
                <input type="text" name="image_url" value="<?php echo htmlspecialchars($movie_to_edit['image_url']); ?>" placeholder="Image URL" required>
                <input type="text" name="trailers" value="<?php echo htmlspecialchars($movie_to_edit['Trailers']); ?>" placeholder="Trailer URL" required>
                <select name="age_class" required>
                    <option value="adult" <?php if ($movie_to_edit['age_class'] == 'adult') echo 'selected'; ?>>Adult</option>
                    <option value="kids" <?php if ($movie_to_edit['age_class'] == 'kids') echo 'selected'; ?>>Kids</option>
                </select>
                <button type="submit" name="update_movie">Update Movie</button>
            </form>
        </div>
    <?php endif; ?>
</div>

<div class="container">
    <h2>Comments</h2>
    <table>
        <tr>
            <th>Movie</th>
            <th>User</th>
            <th>Comment</th>
            <th>Actions</th>
        </tr>
        <?php while ($comment = $comments->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($comment['movie_id']); ?></td>
                <td><?php echo htmlspecialchars($comment['user_id']); ?></td>
                <td><?php echo htmlspecialchars($comment['comment']); ?></td>
                <td><a class="delete-button" href="?delete_comment=<?php echo $comment['id']; ?>">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>

<?php
$conn->close();
?>
