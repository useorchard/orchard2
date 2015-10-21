<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
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
     mysql_query("REPLACE INTO Queue VALUES('1','$data')");

}


?>
