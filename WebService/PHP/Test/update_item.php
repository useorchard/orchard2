<?php
  error_reporting(0);
  include("db_config.php");

  // array for JSON response
  $response = array();

if( isset($_GET['id'] ) && isset($_GET['item']) ) {
    $id=$_GET['id'];
    $item=$_GET['item'];

    $result = mysql_query("update myorder set item='$item' where id='$id' ") or die(mysql_error());

    $row_count = mysql_affected_rows();

    if($row_count>0){
         $response["success"] = 1;
         $response["message"] = "Updated Sucessfully.";
     }
    else{
        $response["success"] = 0;
        $response["message"] = "Failed To Update.";  
     }  
  // echoing JSON response
  echo json_encode($response);
}
?>
