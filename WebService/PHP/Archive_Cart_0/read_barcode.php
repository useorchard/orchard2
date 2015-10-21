<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();
shell_exec('cd /home/orchard2/Orchard; touch evan.txt');

// get barcode from app
if( !(empty($_POST['barcode'])))
{
    $barcode = $_POST['barcode'];

    shell_exec('cd /home/orchard2/Orchard; touch evan.txt');

// get expected weight for $barcode
    $result = mysql_query("SELECT Weight FROM Items WHERE Barcode = '$barcode'") or die(mysql_error());
    //$result = mysql_query("SELECT Weight FROM Items") or die(mysql_error());

    if($result>=0){
           $response["success"] = 1;
         }    
     else{
           $response["success"] = 0;
     // echoing JSON response
     echo json_encode($response);
}



if (mysql_num_rows($result) > 0) {
  
    $response["orders"] = array();

    while ($row = mysql_fetch_array($result)) {
            // temp user array
            $item = array();
            $item["Weight"] = $row["Weight"];
        
            // push ordered items into response array 
            array_push($response["orders"], $item);
           }
      // success
     $response["success"] = 1;
}
else {
    // order is empty 
      $response["success"] = 0;
      $response["message"] = "No Items Found";
}
// echoing JSON response
echo json_encode($response);

?>
