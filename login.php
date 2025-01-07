<?php
// Start session only if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost'; // Replace with your host
$dbname = 'ShowPick'; // Replace with your actual database name
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $inputUsername = $_POST['username'];
        $inputPassword = $_POST['password'];

        // Query to check if the user exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $inputUsername);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Verify password (if hashed)
            if (password_verify($inputPassword, $user['password'])) {
                $_SESSION['user'] = $user['username'];
                header('Location: home.php');
                exit();
            } else {
                $error = 'Invalid password.';
            }
        } else {
            $error = 'User not found.';
        }
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ShowPick</title>

    <style> 
        /* General Styles */
body {
    font-family: 'Poppins', Arial, sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #1c1c2e, #3e3e58);
    color: #f4f4f4;
}

h1 {
    font-size: 24px;
    color: #ffcc00;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    margin-bottom: 20px;
    text-align: center;
}

button {
    background-color: #ffcc00;
    color: #1c1c2e;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 25px;
    font-size: 16px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

button:hover {
    background-color: #f9a825;
    transform: scale(1.1);
}

a {
    color: #ffcc00;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    background: rgba(0, 0, 0, 0.6);
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    margin: 20px;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    max-width: 400px;
}

label {
    align-self: flex-start;
    margin: 10px 0 5px;
}

input {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    background: #3e3e58;
    color: #f4f4f4;
}

input:focus {
    outline: none;
    border: 2px solid #ffcc00;
}

#register-link {
    margin-top: 10px;
    font-size: 14px;
}

.hidden {
    display: none;
}

#header-logo {
            max-width: 60px;
            margin-right: 10px;
            border-radius: 50%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }


    </style>
</head>
<body>
    <div class="form-container">
    <img src="ShowPick icon.png" id="header-logo" alt="ShowPick Logo">
    <h1>Welcome to ShowPick</h1>
        <form method="POST">
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
            <a href="register.php" id="register-link">Don't have an account? Register here</a>
        </form>
    </div>
</body>
</html>
