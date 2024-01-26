<?php 
session_start();
include('includes/header.inc'); 
?>

<div class="details-container">

    <?php 
    include ('includes/db_connect.inc'); 

    $username = $_GET['username'] ?? '';

    // Ensure that a username is provided
    if(empty($username)) {
        echo "<p>No username provided.</p>";
        exit();
    }

    if(!isset($_SESSION['user_facilities'][$username]) || empty($_SESSION['user_facilities'][$username])) {
        echo "<p>No facilities added by this user during this session.</p>";
        exit();
    }

    // Fetch facilities added by this user from the session
    $facilities = $_SESSION['user_facilities'][$username];
    $placeholders = implode(',', array_fill(0, count($facilities), '?'));

    $sql = "SELECT * FROM facilities WHERE facilityid IN ($placeholders)";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "SQL error: " . $conn->error;
        exit();
    }

    $stmt->bind_param(str_repeat('i', count($facilities)), ...$facilities);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
    ?>

        <img class="framed-image" src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['facilityname']; ?>">
        <h1><?php echo $row['facilityname']; ?></h1>
        <p><?php echo $row['description']; ?></p>

        <table class="detail-table">
            <tr>
                <td>Bed Configuration:</td>
                <td><?php echo $row['configuration']; ?></td>
            </tr>
            <tr>
                <td>Capacity:</td>
                <td><?php echo $row['capacity']; ?></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
            </tr>
        </table>

        <!-- Show the Edit and Delete buttons only if the user is logged in and it's their facility -->
        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && $_SESSION['username'] == $username): ?>
            <a href="edit.php?id=<?php echo $row['facilityid']; ?>" class="btn">Edit</a>
            <form action="delete.php" method="post" onsubmit="return confirm('Are you sure you want to delete this facility?');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="facilityid" value="<?php echo $row['facilityid']; ?>">
                <button type="submit" class="btn">Delete</button>
            </form>
        <?php endif; ?>

    <?php
        } // end of while loop
    } else {
        echo "<p>No facilities found for user: {$username} during this session.</p>";
    }

    $stmt->close();
    mysqli_close($conn);
    ?>

</div>

<?php include('includes/footer.inc'); ?>
