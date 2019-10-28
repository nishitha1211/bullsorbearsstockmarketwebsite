<?php
/**
 * Created by PhpStorm.
 * User: dchha
 * Date: 3/20/2019
 * Time: 5:38 PM
 */

require('db_connection.php');
global $connection;

$sql = "Select * from company";

$result = $connection->query($sql);
$array_price = array();
$num_rows1 = $result->num_rows;
echo $num_rows1;

$cwd = getcwd();
$python_file = "".$cwd."\a.py";

$curl = curl_init();

$c=" ";

// output data of each row
while($row = $result->fetch_assoc() ) {
    //echo "id: " . $row["id"]. " - Name: " . $row["NAME"]. " " . $row["symbol"]. "<br>";
    if($num_rows1>0){

         $c=$c.$row["symbol"].",";
    }
    else{
        echo "no data in db";
    }

}

echo "python ".$python_file.$c;
$result1 = exec("python ".$python_file.$c);

//# format for csv   =>   date open    high      low    close   volume price  symbol
$filename = "data.csv";
$file = fopen($filename, "r");
while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {

    $sql = "select price from company where symbol='".$getData[7]."'";
    $r = mysqli_query($connection, $sql);

    while ($a = $r->fetch_assoc()){
        $prev_day_price = $a['price'];
    }


    $change = $getData[6] - $prev_day_price;
    #$time = strtotime($getData[0]);

    $newformat = date('Y-m-d');

    //echo $getData[1];
    $sql = "Update company set last_trade_day='".$newformat."', open=". $getData[1].", high= ".$getData[2].", low=".$getData[3].", previous_close=".$prev_day_price.",price=".$getData[6].",difference=".$change." where symbol = '".$getData[7]."'";
    $result = mysqli_query($connection, $sql);
}


?>

