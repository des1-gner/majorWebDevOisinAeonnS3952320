<?php 
session_start();
include('includes/header.inc'); 
?>

<div class="form-container">

    <h2>Login</h2>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include('includes/db_connect.inc');
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        // Hashing the password input for comparison
        $hashedPassword = hash('sha1', $password);

        // Check the credentials
        $sql = "SELECT userID, username FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);

        if(!$stmt) {
            die("Statement preparation failed: " . $conn->error);
        }

        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($userID, $retrievedUsername);

        if ($stmt->num_rows > 0) {
            $stmt->fetch(); // Fetch the results
            echo '<div class="feedback success">Login successful! Welcome, ' . htmlspecialchars($retrievedUsername) . '</div>';
        
            // Set session variables upon successful login
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $retrievedUsername;
            $_SESSION['userID'] = $userID;
        
            // Initialize the 'users_added_facilities' session variable if it's not already set
            if(!isset($_SESSION['user_facilities'])) {
                $_SESSION['user_facilities'] = array();
            }
        
        } else {
            echo '<div class="feedback error">Incorrect username or password!</div>';
        }        

        $stmt->close();
        $conn->close();
    }
    ?>

    <form action="login.php" method="post" class="login-form">   
        <fieldset>
            <legend>Login</legend>
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="btn-group">
                <button type="submit" class="btn-login">Login</button>
            </div>
        </fieldset>
    </form>
</div>

<?php include('includes/footer.inc'); ?>
