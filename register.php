<?php
// Start session
session_start();

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

// Handle registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $regUsername = trim($_POST['username']);
    $regEmail = trim($_POST['email']);
    $regPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate inputs
    if (empty($regUsername) || empty($regEmail) || empty($regPassword) || empty($confirmPassword)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } 
    elseif (strlen($regPassword) < 8) {
        $error = 'Password must be at least 8 characters long.';
    }
    elseif ($regPassword !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } else {
        // Hash the password
        $hashedPassword = password_hash($regPassword, PASSWORD_BCRYPT);

        // Insert into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute([
                ':username' => $regUsername,
                ':email' => $regEmail,
                ':password' => $hashedPassword
            ]);
            $_SESSION['success'] = 'Registration successful! You can now log in.';
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            // Check for duplicate entries
            if ($e->getCode() == 23000) {
                $error = 'Username or email already exists.';
            } else {
                $error = 'Registration failed: ' . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ShowPick</title>
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
    padding: 10px;
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
    <h1>Create Your Account</h1>
        <form method="POST">
            <?php if (!empty($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Choose a username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Create a password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>

            <button type="submit">Register</button>
            <a href="login.php" id="login-link">Already have an account? Login here</a>
        </form>
    </div>
</body>
</html>
