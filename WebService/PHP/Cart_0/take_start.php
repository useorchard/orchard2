<?php
error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();

if( !(empty($_POST['start_command'])))
{
    $start_command=$_POST['start_command'];

    $result = mysql_query("REPLACE INTO Command(Id,Start,Stop,Push,Retrieve) VALUES('1','$start_command','1','$start_command','$start_command')");    

    if($result>=0){
           $response["success"] = 1;
         }    
     else{
           $response["success"] = 0;
         }
     // echoing JSON response
     echo json_encode($response);
}

if( !(empty($_POST['stop_command'])))
{
    $stop_command=$_POST['stop_command'];

    $result = mysql_query("REPLACE INTO Command(Id,Start,Stop,Push,Retrieve) VALUES('1','2','$stop_command','2','2')");    

    if($result>0){
           $response["success"] = 1;
         }    
     else{
           $response["success"] = 0;
         }
     // echoing JSON response
     echo json_encode($response);
}

if( !(empty($_POST['wipe_command'])))
{
    $wipe_command=$_POST['wipe_command'];

    $result = mysql_query("REPLACE INTO Command(Id,Start,Stop,Push,Retrieve) VALUES('1','$wipe_command','$wipe_command','$wipe_command','$wipe_command')"); 
    
    if($result>0){
           $response["success"] = 1;
         }    
     else{
           $response["success"] = 0;
         }
     // echoing JSON response
     echo json_encode($response);
}

?>

