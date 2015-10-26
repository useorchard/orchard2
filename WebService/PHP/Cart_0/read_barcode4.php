<?php


// SETUP FOR SCRIPT

error_reporting(0);
include("db_config.php");

$count = 0;
$test = 1;


// MARK LOCATION ON REAL-TIME CART WEIGHT DATABASE

$marker_query = mysql_query("SELECT Id FROM Weight ORDER BY Id DESC LIMIT 1");
$marker_row = mysql_fetch_row($marker_query);
$marker = $marker_row[0];


// GET EXPECTED WEIGHT OF ITEM

$response = array();

if( !(empty($_POST['barcode'])))

{

  $barcode=$_POST['barcode'];

  $result = mysql_query("SELECT Weight FROM Items WHERE (Barcode='$barcode')");

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


  // CHECK CART WEIGHT DATABASE FOR EXPECTED WEIGHT

  while ($count < 60)

  {

    mysql_query("INSERT INTO myorder VALUES('$count','evan')");
    $verify_query = mysql_query("SELECT Delta FROM Weight WHERE Id >= '$marker' AND ABS(Delta-'$data')<=20");
    $verify_row = mysql_fetch_row($verify_query);
    $real_weight = $verify_row[0];

    if (!(empty($data)))

    {

      mysql_query("INSERT INTO myorder VALUES(2,'coulstring')");
      $scan_query = mysql_query("SELECT Scan FROM Verified ORDER BY Scan DESC LIMIT 1;");
      $scan_row = mysql_fetch_row($scan_query);
      $scan = $scan_row[0];

      if (empty($scan))

      {

        $scan_number = 1;
        mysql_query("INSERT INTO myorder VALUES(21,'captain')");

      }

      else

      {

        $scan_number = $scan + 1;
        mysql_query("INSERT INTO myorder VALUES(22,'leader')");

      }

      $name_query = mysql_query("SELECT Name FROM Items WHERE Barcode = '$barcode'");
      $name_row = mysql_fetch_row($name_query);
      $name = $name_row[0];
      $weight_query = mysql_query("SELECT Weight FROM Items WHERE Barcode = '$barcode'");
      $weight_row = mysql_fetch_row($weight_query);
      $exp_weight = $weight_row[0];

      if($test = 1)

      {

        mysql_query("INSERT INTO test VALUES('START')");
        mysql_query("INSERT INTO test VALUES('$scan_number')");
        mysql_query("INSERT INTO test VALUES('$name')");
        mysql_query("INSERT INTO test VALUES('$barcode')");
        mysql_query("INSERT INTO test VALUES('$exp_weight')");
        mysql_query("INSERT INTO test VALUES('$real_weight')");
        mysql_query("INSERT INTO test VALUES('$marker')");
        mysql_query("INSERT INTO test VALUES('STOP')");
        mysql_query("INSERT INTO Verified VALUES('$scan_number','$name','$barcode','$exp_weight','$real_weight'");
        $test = 0;

      }

      $count = 11;

    }

    else

    {

      $count = $count + 1;

    }

    sleep(1);

  }

}


?>
