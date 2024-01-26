<?php

// Dynamic Database Connection Details

// Check what server you are accessing

if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {

    $servername = "localhost"; 
    $port = 3306;
    $username = "root";
    $password = ""; 
    $dbname = "hotel"; 

}

else {

    $servername = "talsprddb02.int.its.rmit.edu.au"; 
    $port = 3306;
    $username = "s3952320";
    $password = "WEBprogramming101~zX3"; 
    $dbname = "s3952320"; 

}

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

function fetchFacilities($conn) {

    $query = "SELECT facilityname, description, caption, image FROM facilities";
    $result = $conn->query($query);

    $facilities = [];

    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            $facilities[] = $row;

        }

    }

    return $facilities;

}
