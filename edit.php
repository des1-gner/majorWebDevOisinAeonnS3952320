<?php 
session_start();

// If not logged in, redirect to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: login.php");
    exit;
}

include('includes/header.inc');

$facility_id = $_GET['id'];
$facility = [];

function validateInput($str) {
    return trim($str);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includes/db_connect.inc');

    $facilityName = validateInput($_POST['facilityName']);
    $description = validateInput($_POST['description']);
    $caption = validateInput($_POST['imageCaption']);
    $configuration = validateInput($_POST['bedConfiguration']);
    $capacity = (int) validateInput($_POST['capacity']);
    $price = (float) validateInput($_POST['price']);

    $filename = $_POST['existingImage'];
    if (isset($_FILES["image"]) && is_uploaded_file($_FILES["image"]["tmp_name"])) {
        $newFilename = $_FILES["image"]["name"];

        // If there's an existing image and it's different from the newly uploaded one, delete it
        if ($filename && $filename !== $newFilename) {
            $existingImagePath = "images/" . $filename;
            if (file_exists($existingImagePath)) {
                unlink($existingImagePath);
            }
        }
        
        $filename = $newFilename;
        move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $filename);
    }

    $sql = "UPDATE facilities SET facilityname=?, description=?, caption=?, configuration=?, price=?, capacity=?, image=? WHERE facilityid=?";
    $stmt = $conn->prepare($sql);
    
    if(!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssssdisi", $facilityName, $description, $caption, $configuration, $price, $capacity, $filename, $facility_id);

    if($stmt->execute()) {
        echo "Facility updated successfully!";
    } else {
        echo "An error occurred: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    include('includes/db_connect.inc');

    $sql = "SELECT * FROM facilities WHERE facilityid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $facility_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $facility = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}
?>

<div class="form-container">
    <h2>Edit Facility</h2>

    <form action="edit.php?id=<?php echo $facility_id; ?>" method="post" enctype="multipart/form-data">
        
        <fieldset>
            <legend>Facility Information</legend>
            
            <label for="facilityName">Facility Name:</label>
            <input type="text" id="facilityName" name="facilityName" required value="<?php echo $facility['facilityname']; ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required><?php echo $facility['description']; ?></textarea>

            <label for="capacity">Capacity:</label>
            <input type="number" id="capacity" name="capacity" min="1" required value="<?php echo $facility['capacity']; ?>">

            <label for="bedConfiguration">Bed Configuration:</label>
            <select id="bedConfiguration" name="bedConfiguration" required>
                <option value="1 Double" <?php if($facility['configuration'] == "1 Double") echo 'selected'; ?>>1 Double</option>
                <option value="1 Queen" <?php if($facility['configuration'] == "1 Queen") echo 'selected'; ?>>1 Queen</option>
                <option value="1 King" <?php if($facility['configuration'] == "1 King") echo 'selected'; ?>>1 King</option>
                <option value="2 Single" <?php if($facility['configuration'] == "2 Single") echo 'selected'; ?>>2 Single</option>
                <option value="N/A" <?php if($facility['configuration'] == "N/A") echo 'selected'; ?>>N/A</option>
            </select>
        </fieldset>
        
        <fieldset>
            <legend>Image Information</legend>
            
            <img src="images/<?php echo $facility['image']; ?>" alt="Current Image" width="150">
            <label for="image">Change Image (leave empty to keep current):</label>
            <input type="file" id="image" name="image" accept="image/*">

            <!-- Hidden field to retain the existing image name -->
            <input type="hidden" name="existingImage" value="<?php echo $facility['image']; ?>">

            <label for="imageCaption">Image Caption:</label>
            <input type="text" id="imageCaption" name="imageCaption" required value="<?php echo $facility['caption']; ?>">
        </fieldset>
        
        <fieldset>
            <legend>Price Information</legend>
            
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required value="<?php echo $facility['price']; ?>">
        </fieldset>
        
        <div>
            <button type="submit">Update</button>
        </div>
    </form>
</div>

<?php include('includes/footer.inc'); ?>
