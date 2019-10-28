<?php
/**
 * Created by PhpStorm.
 * User: dchha
 * Date: 3/31/2019
 * Time: 1:15 PM
 */

require('db_connection.php');
global $connection;
$conn = $connection;

session_start();
$userId = $_SESSION['userId'];

if(isset($_POST['cc_submit'])|| isset($_POST['pp_submit'])){
    if(isset($_POST['id'])){
        $cart;

        if (isset($_POST['cc_submit'])) {
            $payment_mode = 'Card';
            $_POST['cc_submit'] = null;
        } else {
            $payment_mode = 'PayPal';
            $_POST['pp_submit'] = null;
        }

        $curr_date = date("Y-m-d");
        //make a new transaction when user clicks the submit button
        $ut_query = "INSERT INTO user_transaction(userId, amount, transactionDate, paymentMode, delete_flag) 
                        VALUES ({$userId},{$_POST['price']},'{$curr_date}','{$payment_mode}',0)";
        $ut_results = $conn->query($ut_query);


        // Insert into transaction_details table
        $ut_rows;
        $ut_rows_query = "SELECT id FROM user_transaction ORDER BY id DESC LIMIT 1";
        $ut_rows_results = $conn->query($ut_rows_query);
        while ($ut_rows_result = $ut_rows_results->fetch_assoc()) {
            $ut_rows = $ut_rows_result['id'];
        }

            $td_query = "INSERT INTO transaction_details(transactionId, companyId, price, buy_sell, quantity, delete_flag) 
                        VALUES ({$ut_rows},{$_POST['id']},{$_POST['price']},'{$_POST['buy_sell']}',{$_POST['quantity']},0)";

            $td_results = $conn->query($td_query);

            //when the user is selling
            if ($_POST['buy_sell'] == 's') {
                $query = "Update user_stocks set num_shares= num_shares-" . $_POST['quantity'] . " where userId=" . $userId . " and companyId=" . $_POST['id'] . " and delete_flag=0";
                $conn->query($query);
                echo "payment done";


            } // when the user is buying
            else {
                $query1 = "SELECT num_shares FROM user_stocks where userId=" . $userId . " and companyId=" . $_POST['id'] . " and delete_flag=0";
                $userStocks = $conn->query($query1);

                //if an entry exits in  userStocks for the stocks of the given user
                if (mysqli_num_rows($userStocks) > 0) {
                    $query = "Update user_stocks set num_shares= num_shares+" . $_POST['quantity'] . " where userId=" . $userId . " and companyId=" . $_POST['id'] . " and delete_flag=0";
                    $conn->query($query);
                    // echo "Added items to buy in cart";
                } else {
                    $query = "Insert into user_stocks(userId, companyId,num_shares) values (" . $userId . "," . $_POST['id'] . "," . $_POST['quantity'] . ")";
                    $conn->query($query);
                    //echo "Added items to buy in cart";
                }

            }

        // Remove items from cart table
        $cart_rm_query = "UPDATE cart SET delete_flag = 1 where cart.delete_flag=0 AND cart.userId=" . $userId;
        $cart_remove = $conn->query($cart_rm_query);

        //redirect to index page after successful updation
        echo "Payment done";
        header('Location: index.php');
        $conn->close();

    }

    else {
        $cart;
        // Insert into user_transaction table
        $total_amount = 0;
        $buy_query = "SELECT SUM(total_price) AS buy_sum FROM cart WHERE userid={$userId} AND buy_sell='b' AND delete_flag=0 UNION
                              SELECT SUM(total_price) AS sell_sum FROM cart WHERE userid={$userId} AND buy_sell='s' AND delete_flag=0";
        $buy_results = $conn->query($buy_query);
        while ($buy_result = $buy_results->fetch_assoc()) {
            $total_amount = $buy_result['sell_sum'] - $buy_result['buy_sum'];
        }
        if (isset($_POST['cc_submit'])) {
            $payment_mode = 'Card';
            $_POST['cc_submit'] = null;
        } else {
            $payment_mode = 'PayPal';
            $_POST['pp_submit'] = null;
        }
        $curr_date = date("Y-m-d");
        //make a new transaction when user clicks the submit button
        $ut_query = "INSERT INTO user_transaction(userId, amount, transactionDate, paymentMode, delete_flag) 
                        VALUES ({$userId},{$total_amount},'{$curr_date}','{$payment_mode}',0)";
        $ut_results = $conn->query($ut_query);


        // Insert into transaction_details table
        $ut_rows;
        $ut_rows_query = "SELECT id FROM user_transaction ORDER BY id DESC LIMIT 1";
        $ut_rows_results = $conn->query($ut_rows_query);
        while ($ut_rows_result = $ut_rows_results->fetch_assoc()) {
            $ut_rows = $ut_rows_result['id'];
        }
        $cart_query = "SELECT cart.id AS id, cart.companyId as companyId, cart.total_price as total_price, cart.quantity as quantity, cart.buy_sell as buy_sell,cart.delete_flag as delete_flag, company.name as companyName 
                          FROM cart join company ON cart.companyId=company.id 
                          where cart.delete_flag=0 AND company.delete_flag=0 AND cart.userId=" . $userId;
        $cart_results = $conn->query($cart_query);

        while ($cart_result = $cart_results->fetch_assoc()) {

            $td_query = "INSERT INTO transaction_details(transactionId, companyId, price, buy_sell, quantity, delete_flag) 
                        VALUES ({$ut_rows},{$cart_result['companyId']},{$cart_result['total_price']},'{$cart_result['buy_sell']}',{$cart_result['quantity']},0)";

            $td_results = $conn->query($td_query);

            //when the user is selling
            if ($cart_result['buy_sell'] == 's') {


                $query = "Update user_stocks set num_shares= num_shares-" . $cart_result['quantity'] . " where userId=" . $userId . " and companyId=" . $cart_result['companyId'] . " and delete_flag=0";
                $conn->query($query);
                echo "payment done";


            } // when the user is buying
            else {
                $query1 = "SELECT num_shares FROM user_stocks where userId=" . $userId . " and companyId=" . $cart_result['companyId'] . " and delete_flag=0";
                $userStocks = $conn->query($query1);

                //if an entry exits in  userStocks for the stocks of the given user
                if (mysqli_num_rows($userStocks) > 0) {
                    $query = "Update user_stocks set num_shares= num_shares+" . $cart_result['quantity'] . " where userId=" . $userId . " and companyId=" . $cart_result['companyId'] . " and delete_flag=0";
                    $conn->query($query);
                } else {
                    $query = "Insert into user_stocks(userId, companyId,num_shares) values (" . $userId . "," . $cart_result['companyId'] . "," . $cart_result['quantity'] . ")";
                    $conn->query($query);
                }

            }
        }

        // Remove items from cart table
        $cart_rm_query = "UPDATE cart SET delete_flag = 1 where cart.delete_flag=0 AND cart.userId=" . $userId;
        $cart_remove = $conn->query($cart_rm_query);

        //redirect to index page after successful updation
        echo "Payment done";
        header('Location: index.php');
        $conn->close();
    }
}
?>