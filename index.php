<?php
// Start the session to manage user authentication
session_start();

// Determine which page to show
$page = isset($_GET['page']) ? $_GET['page'] : 'login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="text.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShowPick</title>
    <link rel="shortcut icon" href="ShowPick icon.png">
    <style>
        /* Include your CSS styles here (same as in the provided HTML file) */
    </style>
</head>
<body>
    <?php
    // Load the appropriate page
    if ($page === 'login') {
        include 'login.php';
    } elseif ($page === 'register') {
        include 'register.php';
    } elseif ($page === 'home') {
        include 'home.php';
    } else {
        echo '<h1>Page not found!</h1>';
    }
    ?>
</body>
</html>