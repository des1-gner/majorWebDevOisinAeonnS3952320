<?php 
session_start();
include('includes/header.inc'); 
?>

<div class="details-container">

    <?php 
    include ('includes/db_connect.inc'); 

    $facility_id = $_GET['id'];

    if(isset($_POST['action']) && $_POST['action'] === 'delete') {

        // Fetch image name for deletion
        $fetchImageSQL = "SELECT image FROM facilities WHERE facilityid = ?";
        $fetchImageStmt = $conn->prepare($fetchImageSQL);
        $fetchImageStmt->bind_param("i", $facility_id);
        $fetchImageStmt->execute();
        $imageData = $fetchImageStmt->get_result();
        $imageRow = $imageData->fetch_assoc();
        $imageName = $imageRow['image'];
        $fetchImageStmt->close();

        // Delete facility from database
        $deleteSQL = "DELETE FROM facilities WHERE facilityid = ?";
        $deleteStmt = $conn->prepare($deleteSQL);
        $deleteStmt->bind_param("i", $facility_id);

        if($deleteStmt->execute()) {
            echo "Facility deleted successfully!";
            
            // Delete image from server
            $imagePath = "images/" . $imageName;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $currentUsername = $_SESSION['username'];

            // Adjust user's facilities session data
            if (isset($_SESSION['user_facilities'][$currentUsername])) {
                $index = array_search($facility_id, $_SESSION['user_facilities'][$currentUsername]);
                if($index !== false){
                    unset($_SESSION['user_facilities'][$currentUsername][$index]);
                    // Re-index the array
                    $_SESSION['user_facilities'][$currentUsername] = array_values($_SESSION['user_facilities'][$currentUsername]);
                }
                if (empty($_SESSION['user_facilities'][$currentUsername])) {
                    unset($_SESSION['user_facilities'][$currentUsername]);
                }                
            }

        } else {
            echo "Error deleting the facility!";
        }

        $deleteStmt->close();
    }

    $sql = "SELECT * FROM facilities WHERE facilityid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $facility_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    ?>
        <img class="framed-image" src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['facilityname']; ?>">
        <h1><?php echo $row['facilityname']; ?></h1>
        <p><?php echo $row['description']; ?></p>

        <table class="detail-table">
            <tr>
                <td><i class="material-icons">hotel</i> Bed Configuration:</td>
                <td><?php echo $row['configuration']; ?></td>
            </tr>
            <tr>
                <td><i class="material-icons">people</i> Capacity:</td>
                <td><?php echo $row['capacity']; ?></td>
            </tr>
            <tr>
                <td><i class="material-icons">payment</i> Price:</td>
                <td>$<?php echo number_format($row['price'], 2); ?></td>
            </tr>
        </table>

        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="edit.php?id=<?php echo $facility_id; ?>" class="btn">Edit</a>
            <form action="" method="post" onsubmit="return confirm('Are you sure you want to delete this facility?');">
                <input type="hidden" name="action" value="delete">
                <button type="submit" class="btn">Delete</button>
            </form>
        <?php endif; ?>

    <?php
    } else {
        echo "<p>Facility not found.</p>";
    }

    mysqli_close($conn);
    ?>

</div>

<?php include('includes/footer.inc'); ?>
