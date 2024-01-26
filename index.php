<?php 
$isIndexPage = true; 
?>

<?php include('includes/header.inc'); ?>

<div class="container my-5">
    <div class="row">
        <!-- Bootstrap 5 Carousel -->
        <div class="col-lg-6">
            <div class="carousel-frame">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    
                    <!-- Carousel indicators -->
                    <ol class="carousel-indicators">
                        <?php
                        include('includes/db_connect.inc');
                        $query = "SELECT facilityid FROM facilities ORDER BY facilityid DESC LIMIT 4";
                        $resultIndicators = mysqli_query($conn, $query);
                        $slideNumber = 0;
                        while ($rowIndicator = mysqli_fetch_assoc($resultIndicators)) {
                            echo '<li data-bs-target="#carouselExampleControls" data-bs-slide-to="' . $slideNumber . '" ' . ($slideNumber == 0 ? 'class="active"' : '') . '></li>';
                            $slideNumber++;
                        }
                        ?>
                    </ol>

                    <div class="carousel-inner">
                        <?php
                        $query = "SELECT facilityid, facilityname, description, caption, image FROM facilities ORDER BY facilityid DESC LIMIT 4";
                        $result = mysqli_query($conn, $query);

                        $isActive = true;  // To set the first item as active

                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="carousel-item ' . ($isActive ? 'active' : '') . '">';
                            echo '<img src="images/' . $row['image'] . '" class="d-block w-100" alt="' . $row['facilityname'] . '">';
                            echo '<div class="carousel-caption d-none d-md-block">';
                            echo '<h5>' . $row['facilityname'] . '</h5>';
                            echo '<p>' . $row['description'] . '</p>';
                            echo '</div>';
                            echo '</div>';

                            $isActive = false;  // Only the first item should be active
                        }
                        ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>

                    <?php mysqli_close($conn); ?>
                </div>
            </div>
        </div>
        <!-- End of Bootstrap 5 Carousel -->

        <!-- Text Container -->
        <div class="col-lg-6">
            <div class="text-container">
                <h1><b>INTERNATIONAL MELBOURNE HOTEL</b></h1>
                <h2>WELCOME TO MELBOURNE</h2>
            </div>
        </div>
    </div>
</div>

<!-- Discover Melbourne Section -->
<div class="container-fluid my-5 bg-white">
    <div class="row justify-content-center">
        <div class="col-lg-10"> <!-- Using a centered column for content. Adjust width as per your needs. -->
            <h2 class="text-center">Discover Melbourne your own way!</h2>
            <p class="text-center mb-4">We know everybody has their own style, and favorite way to spend their leisure time. The Melbourne International Hotel has facilities that will satisfy your personal or business needs. Are you ready to explore?</p>
            
            <form action="search_results.php" method="post" class="d-flex flex-column flex-md-row justify-content-between"> 
                <!-- Assuming you want to POST the data to a 'search_results.php' page -->
                
                <div class="mb-3 mb-md-0 flex-fill mr-md-2"> <!-- Flexbox classes to make layout responsive -->
                    <input type="text" class="form-control" name="looking_for" placeholder="I AM LOOKING FOR ...">
                </div>
                
                <div class="mb-3 mb-md-0 flex-fill ml-md-2"> 
                    <select class="form-control" name="favorite_way">
                        <!-- You can add options here for ways -->
                        <option value="" disabled selected>SELECT YOUR FAVOURITE WAY!</option>
                        <option value="way1">FUN</option>
                        <option value="way2">BUSINESS</option>
                        <option value="way3">EXPLORE</option>
                        <option value="way4">ARTISTIC</option>
                        <option value="way5">NIGHTLIFE</option>
                        <option value="way6">FOOD</option>
                        <!-- ... add more ways/options ... -->
                    </select>
                </div>
                
                <div class="mt-3 mt-md-0 ml-md-2">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.inc'); ?>
