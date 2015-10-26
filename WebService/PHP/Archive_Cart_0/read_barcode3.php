<?php

error_reporting(0);
include("db_config.php");


// MARK LOCATION ON REAL-TIME CART WEIGHT DATABASE

$marker_query = mysql_query("SELECT Id FROM Weight ORDER BY Id DESC LIMIT 1");
$marker_row = mysql_fetch_row($marker_query);
$marker = $marker_row[0];
//$marker = 1;
$end_marker = $marker + 25;

// GET EXPECTED WEIGHT OF ITEM

$response = array();

if( !(empty($_POST['barcode'])))
{
    $barcode=$_POST['barcode'];

    $result = mysql_query("SELECT Weight FROM Items WHERE (Barcode='$barcode')"); 

    if($result>=0){
           $response["success"] = 1;
         }    
    else{
           $response["success"] = 0;
         }
     // echoing JSON response
     echo json_encode($response);

     $row = mysql_fetch_row($result);
     $data = $row[0];
     

// CHECK CART WEIGHT DATABASE FOR EXPECTED WEIGHT

sleep(10);
$verify_query = mysql_query("SELECT Delta FROM Weight WHERE Id >= '$marker' AND Id <= '$end_marker' AND ABS(Delta-'$data')<10");
$verify_row = mysql_fetch_row($verify_query);
$verify = $verify_row[0];

if (empty($verify_row)) {

    mysql_query("REPLACE INTO Verify VALUES(1,1)");
}

if (!(empty($verify_row))) {

    mysql_query("REPLACE INTO Verify VALUES(1,2)");
}
}


?>
