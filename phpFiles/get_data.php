<?php
/**
 * Created by PhpStorm.
 * User: dchha
 * Date: 4/3/2019
 * Time: 8:48 PM
 */

class get_data
{
    function get_price($symbol,$api_key)
    {
        $symbol = strval($symbol);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=".$symbol."&apikey=".$api_key,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 80,
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