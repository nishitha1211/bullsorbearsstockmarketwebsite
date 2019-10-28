<?php
/**
 * Created by PhpStorm.
 * User: dchha
 * Date: 3/20/2019
 * Time: 5:32 PM
 */

class get_stock_data
{
    function get_price($symbol)
    {
        $symbol = strval($symbol);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=".$symbol."&apikey=LHL7BAKBCBZEPR61",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_POSTFIELDS => "",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
           // echo $response;
            $json_a = json_decode($response, true);
            $a = $json_a['Global Quote']['05. price'];
            return $a;
        }
    }
}
?>