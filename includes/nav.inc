<?php
// Start the session (if it hasn't been started already)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// If the logout query parameter is set, handle the logout logic
if (isset($_GET['loggedin']) && $_GET['loggedin'] === 'false') {
    $_SESSION['loggedin'] = false; // Set user as logged out
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the current page without the "loggedin" parameter
    exit;
}
?>

<nav class="navbar navbar-expand-lg navbar-dark common-nav"> <!-- added `navbar-dark` class to make the toggle icon white -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="facilities.php">Facilities</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="gallery.php">Gallery</a>
            </li>
            
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <li class="nav-item">
                    <a class="nav-link" href="add.php">Add more</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?loggedin=false">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
