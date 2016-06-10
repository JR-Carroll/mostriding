<?php 

function getFingerprint($api_login_id, $transaction_key, $amount, $fp_sequence, $fp_timestamp)
{
    $api_login_id = ($api_login_id ? $api_login_id : (defined('AUTHORIZENET_API_LOGIN_ID') ? AUTHORIZENET_API_LOGIN_ID : ""));
    $transaction_key = ($transaction_key ? $transaction_key : (defined('AUTHORIZENET_TRANSACTION_KEY') ? AUTHORIZENET_TRANSACTION_KEY : ""));
    if (function_exists('hash_hmac')) {
        return hash_hmac("md5", $api_login_id . "^" . $fp_sequence . "^" . $fp_timestamp . "^" . $amount . "^", $transaction_key); 
    }
    return bin2hex(mhash(MHASH_MD5, $api_login_id . "^" . $fp_sequence . "^" . $fp_timestamp . "^" . $amount . "^", $transaction_key));
}

$protocol = '';
if(isset($_SERVER['HTTPS'])){
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
}
else{
    $protocol = 'http';
}
$applicationFormUrl = $protocol .'://'.$_SERVER['SERVER_NAME'].'/schedule.html';
$relay_response_url = $protocol .'://'.$_SERVER['SERVER_NAME'].'/application/order/paymentconfirm';

$api_login_id = AUTHORIZE_NET_ID;// '96tk7ZP2WY';
$transaction_key = AUTHORIZE_NET_KEY;
$authorizeUrl = AUTHORIZE_NET_URL;

$amount = $info['amount'];
$amount = number_format((float)$amount, 2, '.', '');


$date = date_create();

$fp_sequence = date_format($date, 'YmdHis'); // Any sequential number like an invoice number.
$testMode = false;

$fp_timestamp = time();
     
$fingerprint = getFingerprint($api_login_id, $transaction_key, 
$amount, $fp_sequence, $fp_timestamp);
$courseInfo = getCourseName($info['courseCode']);
$participant = $info['participant'];
$courseInfo = '';
$description = '';

if($courseSched !== false){
//     var_dump($courseSched['name']);
//     var_dump($courseSched['location_code']. ' - '.getLocationInfo($courseSched['location_code']));
//     var_dump(date('M d, Y', strtotime($courseSched['end_date'])) . ' to ' .date('M d, Y',strtotime($courseSched['end_date'])));
    
            
    $description = 'Purchase of '.$info['courseCode'].' in '.getLocationInfo($courseSched['location_code']).' for '.date('M d, Y', strtotime($courseSched['end_date'])) . ' to ' .date('M d, Y',strtotime($courseSched['end_date'])).'  - '.$participant['first_name'].' '.$participant['last_name'];
}else{
    $courseInfo = 'Gift Certificate';
    $description = '('.$courseInfo.') Purchase of '.$info['courseCode'].' - '.$participant['first_name'].' '.$participant['last_name'];
}


?>
<form id="payment-form" method='post' action="<?php echo $authorizeUrl?>">
  <input type='hidden' name="x_login" value="<?php echo $api_login_id?>" />
  <input type='hidden' name="x_fp_hash" value="<?php echo $fingerprint?>" />
  <input type='hidden' name="x_amount" value="<?php echo $amount?>" />
  <input type='hidden' name="x_fp_timestamp" value="<?php echo $fp_timestamp?>" />
  <input type='hidden' name="x_fp_sequence" value="<?php echo $fp_sequence?>" />
  <input type='hidden' name="x_version" value="3.1" />
  <input type='hidden' name="x_show_form" value="payment_form" />
  <input type='hidden' name="x_test_request" value="false" />
  <input type='hidden' name='x_description' value='<?php echo $description; ?>' />  
  <input type="hidden" name="x_relay_url" value="<?=$relay_response_url?>">   <!-- would be redirected to this page after payment -->
  <input type="hidden" name="x_cancel_url" value="<?=$applicationFormUrl?>"/>
  <input type='hidden' name="x_method" value="cc" />
  <input type="hidden" name="x_relay_response" value="true">  
  <input type='hidden' name='x_params' value='<?php echo json_encode($info)?>'/>  
</form>

<script>
$('#payment-form').submit();
</script>