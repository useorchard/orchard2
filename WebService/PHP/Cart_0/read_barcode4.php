<?php

// SETUP FOR SCRIPT:

error_reporting(0);
include("db_config.php");

//TIMESTAMP 1
//$timestamp1 = microtime (true);
//mysql_query("REPLACE INTO Timing VALUES('1', 'Scan', '$timestamp1')");
//

$check = 0;
$count = 0;
$marker_counter = 4;


// MARK LOCATION ON REAL-TIME CART WEIGHT DATABASE:

$marker_query = mysql_query("SELECT Id FROM Weight ORDER BY Id DESC LIMIT 1");
//TIMESTAMP 2
//$timestamp2 = microtime (true);
//mysql_query("REPLACE INTO Timing VALUES('2', 'MinIdQuery', '$timestamp2')");
//
$marker_row = mysql_fetch_row($marker_query);
$marker = $marker_row[0];


// GET EXPECTED WEIGHT OF ITEM:

$response = array();

if( !(empty($_POST['barcode'])))

{

  $barcode=$_POST['barcode'];

  $result = mysql_query("SELECT Weight FROM Items WHERE (Barcode='$barcode')");
  //TIMESTAMP 3
  //$timestamp3 = microtime (true);
  //mysql_query("REPLACE INTO Timing VALUES('3', 'ExpWeightQuery', '$timestamp3')");
  //
  if($result>=0)

  {

    $response["success"] = 1;

  }

  else

  {

    $response["success"] = 0;

  }

  // echoing JSON response
  echo json_encode($response);
  $row = mysql_fetch_row($result);
  $data = $row[0];


  // CHECK CART WEIGHT DATABASE FOR EXPECTED WEIGHT:

  while ($check == 0)

  {

    $verify_query = mysql_query("SELECT Delta FROM Weight WHERE Id >= '$marker' AND ABS(Delta-'$data')<=60");
    //TIMESTAMP 4+x
    //$timestampx = microtime (true);
    //mysql_query("REPLACE INTO Timing VALUES('$marker_counter', 'VerifyAttempt', '$timestampx')");
    //
    $verify_row = mysql_fetch_row($verify_query);
    $real_weight = $verify_row[0];

    if (ABS($real_weight - $data)<=60)

    {

      // DETERMINE HOW TO NUMBER THIS VERIFIED COLUMN:

      $scan_query = mysql_query("SELECT Scan FROM Verified ORDER BY Scan DESC LIMIT 1;");
      //TIMESTAMP x+1
      //$marker_counter++;
      //$timestampx1 = microtime (true);
      //mysql_query("REPLACE INTO Timing VALUES('$marker_counter', 'NameIdQuery', '$timestampx1')");
      //
      $scan_row = mysql_fetch_row($scan_query);
      $scan = $scan_row[0];

      if (empty($scan))

      {

        $scan_number = 1;

      }

      else

      {

        $scan_number = $scan++;

      }


      // DETERMINE ITEM NAME:
      $name_query = mysql_query("SELECT Name FROM Items WHERE Barcode = '$barcode'");
      //TIMESTAMP x+2
      //$marker_counter++;
      //$timestampx2 = microtime (true);
      //mysql_query("REPLACE INTO Timing VALUES('$marker_counter', 'NameNameQuery', '$timestampx2')");
      //
      $name_row = mysql_fetch_row($name_query);
      $name = $name_row[0];


      // ENTER VERIFIED INFORMATION:

      $final_verify = mysql_query("REPLACE INTO Verified VALUES('$scan_number','$barcode','$data','$real_weight')");
      //TIMESTAMP x+3
      //$marker_counter++;
      //$timestampx3 = microtime (true);
      //mysql_query("REPLACE INTO Timing VALUES('$marker_counter', 'VerifyInsert', '$timestampx3')");
      //



      // EXIT WHILE LOOP:

      $check = 1;
      $success = mysql_query("INSERT INTO test VALUES('SUCCESS')");
      //TIMESTAMP x+4
      //$marker_counter++;
      //$timestampx4 = microtime (true);
      //mysql_query("REPLACE INTO Timing VALUES('$marker_counter', 'SuccessInsert', '$timestampx4')");
      //

    }


    // HOW TO GET OUT OF WHILE LOOP

    $count++;

    if ($count == 30)

    {

      $check = 1;
      $timeout = mysql_query("INSERT INTO test VALUES('TIMEOUT')");
      //TIMESTAMP x+1
      //$marker_counter++;
      //$timestampx5 = microtime (true);
      //mysql_query("REPLACE INTO Timing VALUES('$marker_counter', 'TimeoutInsert', '$timestampx5')");
      //

    }

    $marker_counter++;

    sleep(1);

  }

}


?>
