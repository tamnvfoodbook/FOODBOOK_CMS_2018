<?php
$data = array('submission' => array('api_key' => 'f0d8d81e','api_secret' => 'f074636c'));
$data_string = json_encode($data);

$ch = curl_init('https://api-test.ccall.vn/cdrs/json');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);

echo print_r($result, true);
echo '<pre>';
var_dump($result);
echo '</pre>';
?>