<?php
session_start();
//var data = {
//    id: $val,
//            quantity : $quantity,
//            buy_sell : $buy_sell,
//            price: $total_price,
//            userId: $userId
//        };

require('db_connection.php');
global $connection;
$conn = $connection;


$userId = $_SESSION['userId'];
if(isset($_POST['id'])) {
    $id = $_POST['id'];
    $quantity = $_POST['quantity'];
    $buy_sell = $_POST['buy_sell'];
    $price = $_POST['price'];


    $query1 = "SELECT num_shares FROM user_stocks where userId=".$userId." and companyId=".$id." and delete_flag=0";
    $results = $connection->query($query1);

    if ($buy_sell == 's') {

        //if the user's cart exists in cart table
        if (mysqli_num_rows($results)>0){

            while($num_shares = $results->fetch_assoc()){

                if($num_shares['num_shares']<$quantity){

                    echo "You don't have ".$quantity." stocks to sold. Please select a quantity no more than ".$num_shares['num_shares'].".";
                }

                else{
                    $query = "Insert into cart(userId, companyId,total_price,buy_sell,quantity) values (".$userId.",".$id.",".$price.",'".$buy_sell."',".$quantity.")";
                    $conn->query($query);

                    //$query = "Update user_stocks set num_shares= num_shares-".$quantity." where userId=".$userId." and companyId=".$id." and delete_flag=0";
                    //$conn->query($query);
                    echo "Added items to sell in cart";
                }
            }

        }
        //if user entry not in table
        else {
            echo "You don't have any stocks to sell for this company.";

        }
    }

    //if the user is buying the stocks
    else{
        $query = "Insert into cart(userId, companyId,total_price,buy_sell,quantity) values (".$userId.",".$id.",".$price.",'".$buy_sell."',".$quantity.")";
        $conn->query($query);
/*
        if (mysqli_num_rows($results)>0){
            $query = "Update user_stocks set num_shares= num_shares+".$quantity." where userId=".$userId." and companyId=".$id." and delete_flag=0";
            $conn->query($query);
            echo "Added items to buy in cart";
        }

        else{
            $query = "Insert into user_stocks(userId, companyId,num_shares) values (".$userId.",".$id.",".$quantity.")";
            $conn->query($query);
            echo "Added items to buy in cart";
        }
*/
    echo "Added items to buy in cart";
    }


}

if(isset($_POST['company_id'])) {
    $id = $_POST['company_id'];
    $quantity = $_POST['quantity'];
    $buy_sell = $_POST['buy_sell'];
    $price = $_POST['price'];

    $query1 = "SELECT num_shares FROM user_stocks where userId=" . $userId . " and companyId=" . $id . " and delete_flag=0";
    $results = $connection->query($query1);

    if ($buy_sell == 's') {

        //if the user's cart exists in cart table
        if (mysqli_num_rows($results) > 0) {
            while($num_shares = $results->fetch_assoc()){
                if($num_shares['num_shares']<$quantity){

                   // echo "You don't have ".$quantity." stocks to sold. Please select a quantity no more than ".$num_shares['num_shares'].".";
                    echo "no";
                }
                else{
                    echo "yes";
                }

            }
        }
        else{
            echo "no";
        }
    }

    else{
        echo "yes";
    }
}
$conn->close();
?>