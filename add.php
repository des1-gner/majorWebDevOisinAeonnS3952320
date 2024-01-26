<?php 
session_start();
include('includes/header.inc'); 

function validateInput($str) {
    $ret = trim($str);
    return $ret;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includes/db_connect.inc');

    // File Upload Logic
    $filename = "";

    if (isset($_FILES["image"]) && is_uploaded_file($_FILES["image"]["tmp_name"])) {
        $allowed = array("jpeg", "JPEG", "jpg", "JPG", "png", "PNG", "gif", "GIF");
        $filename = $_FILES["image"]["name"];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        if (!in_array($ext, $allowed)) {
            die("Error: Please select a valid file format.");
        }

        if ($_FILES["image"]["size"] > 500000) {
            die("Error: File size exceeds 500KB limit.");
        }

        $uploadStatus = move_uploaded_file($_FILES["image"]["tmp_name"], "images/" . $filename);

        if (!$uploadStatus) {
            die("Error moving the uploaded file.");
        }
    } else {
        die("Error uploading file. Error code: " . $_FILES["image"]["error"]);
    }

    // Database Insertion Logic
    $facilityName = validateInput($_POST['facilityName']);
    $description = validateInput($_POST['description']);
    $caption = validateInput($_POST['imageCaption']);
    $price = (float) validateInput($_POST['price']);
    $configuration = validateInput($_POST['bedConfiguration']);
    $capacity = (int) validateInput($_POST['capacity']);

    $sql = "INSERT INTO facilities (facilityname, description, caption, configuration, price, capacity, image) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }

    $stmt->bind_param("ssssdis", $facilityName, $description, $caption, $configuration, $price, $capacity, $filename);

    if (!$stmt->execute()) {
        echo "An error has occurred! Error: (" . $stmt->errno . ") " . $stmt->error;
    } elseif ($stmt->affected_rows > 0) {
        echo "New facility added successfully!";
        
        if (!isset($_SESSION['user_facilities'][$_SESSION['username']])) {
            $_SESSION['user_facilities'][$_SESSION['username']] = [];
        }
        $_SESSION['user_facilities'][$_SESSION['username']][] = $stmt->insert_id;
    }

    $stmt->close();
    $conn->close();
}

?>

<div class="form-container">
    <h2>Add a facility</h2>
    <p>YOU CAN ADD A NEW FACILITY HERE</p>

    <form action="add.php" method="post" enctype="multipart/form-data">
        <fieldset>
            <legend>Facility Information</legend>
            <label for="facilityName">Facility Name:<span class="required">*</span></label>
            <input type="text" id="facilityName" name="facilityName" required>

            <label for="description">Description:<span class="required">*</span></label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <label for="capacity">Capacity:<span class="required">*</span></label>
            <input type="number" id="capacity" name="capacity" min="1" required>

            <label for="bedConfiguration">Bed Configuration:<span class="required">*</span></label>
            <select id="bedConfiguration" name="bedConfiguration" required>
                <option value="" disabled selected>Choose an option...</option>
                <option value="1 Double">1 Double</option>
                <option value="1 Queen">1 Queen</option>
                <option value="1 King">1 King</option>
                <option value="2 Single">2 Single</option>
                <option value="N/A">N/A</option>
            </select>
        </fieldset>

        <fieldset>
            <legend>Image Information</legend>
            <label for="image">Select an Image:<span class="required">*MAX IMAGE SIZE: 500KB</span></label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="imageCaption">Image Caption:<span class="required">*</span></label>
            <input type="text" id="imageCaption" name="imageCaption" required>
        </fieldset>

        <fieldset>
            <legend>Price Information</legend>
            <label for="price">Price:<span class="required">*</span></label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>
        </fieldset>

        <div>
            <button type="submit">Submit</button>
            <button type="reset">Clear</button>
        </div>
    </form>
</div>

<?php include('includes/footer.inc'); ?>
