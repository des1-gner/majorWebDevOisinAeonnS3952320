<footer>
    &copy; 2023 s3952320 Oisin Aeonn. All rights reserved. | Designed for International Melbourne Hotel

    <!-- Display links to user profiles who have added posts -->
    <?php
    if(isset($_SESSION['user_facilities']) && !empty($_SESSION['user_facilities'])) {
        echo '<div class="user-links">';
        echo '<h4>Users who added posts:</h4>';
        
        foreach ($_SESSION['user_facilities'] as $username => $facilityIds) {
            // Only show users with facilities
            if (!empty($facilityIds)) {
                echo '<a href="user.php?username=' . $username . '">' . $username . '</a><br>';
            }
        }
        
        echo '</div>';
    }
    ?>
</footer>
