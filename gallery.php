<?php include('includes/header.inc'); ?>

<div class="gallery-container container">

    <h2>Melbourne has a lot to offer!</h2>
    <p>AND WHAT BETTER WAY TO DISCOVER MELBOURNE... YOUR OWN WAY. MELBOURNE INTERNATIONAL HOTEL CAN SERVE AS THE PERFECT GATEWAY. WE CATER FOR EITHER PLEASURE OR BUSINESS STAYS. ARE YOU READY TO EXPLORE</p>

    <!-- Dropdown filter for bed configurations -->
    <form method="get" action="gallery.php">
        <select name="configuration" id="configuration" class="form-select mb-3" onchange="this.form.submit();">
            <option value="" disabled selected>Choose an option...</option>
            <option value="all">All Configurations</option>
            <option value="1 Double">1 Double</option>
            <option value="1 Queen">1 Queen</option>
            <option value="1 King">1 King</option>
            <option value="2 Single">2 Single</option>
            <option value="N/A">N/A</option>
        </select>
    </form>

    <div class="d-flex justify-content-center"> <!-- Flex container for centering the row -->
        <div class="gallery row">
            <?php
            // Connect to Database
            include('includes/db_connect.inc');

            // Filtering based on configuration selection
            $configuration = isset($_GET['configuration']) ? mysqli_real_escape_string($conn, $_GET['configuration']) : '';

            $query = "SELECT facilityid, facilityname, description, caption, image FROM facilities";
            if (!empty($configuration) && $configuration !== 'all') {
                $query .= " WHERE configuration='" . $configuration . "'";
            }

            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-10 col-sm-5 col-md-3 mb-4">'; // Adjusted column classes
                echo '<a href="details.php?id=' . $row['facilityid'] . '">';
                echo '<figure class="figure">';
                echo '<img src="images/' . $row['image'] . '" alt="' . $row['facilityname'] . '" class="figure-img img-fluid rounded">';
                echo '<figcaption class="figure-caption text-center">' . $row['facilityname'] . '</figcaption>';
                echo '</figure>';
                echo '</a>';
                echo '</div>';
            }        

            mysqli_close($conn);
            ?>
        </div>
    </div>
</div>

<?php include('includes/footer.inc'); ?>
