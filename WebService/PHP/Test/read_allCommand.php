<?php
error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();

// get all items from myorder table
$result = mysql_query("SELECT *FROM Command") or die(mysql_error());

if (mysql_num_rows($result) > 0) {
  
    $response["orders"] = array();

    while ($row = mysql_fetch_array($result)) {
            // temp user array
            $item = array();
            $item["Id"] = $row["Id"];
            $item["Start"] = $row["Start"];
	    $item["Stop"] = $row["Stop"];
            $item["Push"] = $row["Push"];
            $item["Retrieve"] = $row["Retrieve"];
        
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
