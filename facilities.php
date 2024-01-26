<?php 
include('includes/header.inc'); 
?>

<div class="container my-5">
    <div class="text-center mb-4">
        <h1>Discover Melbourne your own way!</h1>
        <p>We know everybody has their own style and favourite way to spend their leisure time. Melbourne International Hotel has facilities that will satisfy your personal or business needs.</p>
    </div>

    <div class="row">
        <!-- Image on the left -->
        <div class="col-lg-6 mb-5 mb-lg-0">
            <!-- Added class 'image-frame' to the image -->
            <img src="images/southgatetowilliamstownferry.jpeg" alt="Hotel Image" class="img-fluid w-100 image-frame">
        </div>
        
        <!-- Table on the right -->
        <div class="col-lg-6">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">FACILITY TYPE</th>
                        <th scope="col">CAPACITY</th>
                        <th scope="col">BED CONFIGURATION</th>
                        <th scope="col">PRICE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    
                    include('includes/db_connect.inc'); 

                    $sql = "SELECT facilityid, facilityname, capacity, configuration, price FROM facilities";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td><a href='details.php?id=".$row['facilityid']."'>" . $row['facilityname'] . "</a></td>";
                            echo "<td>" . $row['capacity'] . "</td>";
                            echo "<td>" . $row['configuration'] . "</td>";
                            echo "<td>" . (is_null($row['price']) ? 'N/A' : "$" . number_format($row['price'], 2)) . "</td>";
                            echo "</tr>";
                        }
                        
                    } else {
                        echo "<tr><td colspan='4'>No facilities found.</td></tr>";
                    }

                    mysqli_close($conn);
                    
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php 
include('includes/footer.inc'); 
?>
