<?php 
include('includes/header.inc');
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>

<div class="form-container">

    <h2>Register New User</h2>
    
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        include('includes/db_connect.inc');

        if (!$conn) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Hashing the password using SHA-1
        $hashedPassword = hash('sha1', $password);

        // Checking if username already exists
        $checkUserQuery = "SELECT username FROM users WHERE username=?";
        $checkUserStmt = $conn->prepare($checkUserQuery);
        $checkUserStmt->bind_param("s", $username);
        $checkUserStmt->execute();
        $checkUserStmt->store_result();

        if ($checkUserStmt->num_rows > 0) {
            echo "Username already taken!";
        } else {

            $sql = "INSERT INTO users (username, password, reg_date) VALUES (?, ?, NOW())";

            $stmt = $conn->prepare($sql);

            if(!$stmt) {
                die("Statement preparation failed: " . $conn->error);
            }

            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }

        $checkUserStmt->close();
        $conn->close();
    }
    ?>

<form action="register.php" method="post" class="registration-form">

<fieldset>

    <legend>Register</legend>
    
    <div class="input-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
    </div>

    <div class="input-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn-register">Register</button>
    </div>

</fieldset>

</form>

</div>

<?php include('includes/footer.inc'); ?>