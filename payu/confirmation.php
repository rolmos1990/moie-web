<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
////
//$log_content=json_encode($_REQUEST);
//$myfile = fopen("payu/response".date("Ymd").".log", "a") or die("Unable to open file!");
//fwrite($myfile, $log_content);
//fclose($myfile);
/////

$reference_sale = explode("-",$_POST['reference_sale']); // get the order ID.

//data for payment
$post = array(
    'order'=> $reference_sale[0], // Order ID
    'email'=>$_POST['email_buyer'], // Email
    'phone'=>$_POST['phone'],
    'transaction_id'=>$_POST['transaction_id'],
    'value'=>$_POST['value'],
    'date'=>$_POST['transaction_date'],
    'cc_holder'=>$_POST['cc_holder'],
    'cc_number' => $_POST['cc_number'],
    'authorization_code' => $_POST['authorization_code'],
    'description' => $_POST['description'],
    'error_code_bank' => $_POST['error_code_bank']
);

//state_pol -> 4 (Aprobado), 6 -> Denegado.
if($_POST['state_pol'] == '4' || $_POST['state_pol'] == 4){

    $url = 'https://moie2.lucymodas.com/payment/gateway/payu/register';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
    curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING,"");

    $data = curl_exec($ch);

    echo $data;
}

?>
