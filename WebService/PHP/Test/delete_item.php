<?php
 error_reporting(0);
 include("db_config.php");

// array for JSON response
$response = array();
if( isset($_GET['id'] ) ) {

    $id=$_GET['id'];
    $item=$_GET['item'];
   
    $result = mysql_query("delete from myorder where id='$id' ");
   
    $row_count = mysql_affected_rows();

    if($row_count>0){
        $response["success"] = 1;
        $response["message"] = "Deleted Sucessfully.";
       }
    else{
        $response["success"] = 0;
        $response["message"] = "Failed To Delete"; 
     } 
  // echoing JSON response
  echo json_encode($response);

 }
?>

