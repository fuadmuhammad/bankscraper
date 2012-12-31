<?php
function encode($value){
	return str_replace('%7E', '~', rawurlencode($value));
}

$url = 'https://api.dropbox.com/1/oauth/request_token';
$consumer_secret = "";
 
$nonce = md5(microtime(true) . uniqid('', true));
$param['oauth_consumer_key'] = '';
$param['oauth_signature_method']='HMAC-SHA1';
$param['oauth_version'] = '1.0';
$param['oauth_timestamp'] = time();
$param['oauth_nonce'] = $nonce;
ksort($param);

$encoded = array();
foreach($param as $key=>$value){
	$encoded[] = encode($key).'='.encode($value);
}

$base = "POST&".encode($url)."&";
$base.= encode(implode('&',$encoded));
$key = $consumer_secret."&";
$signature = base64_encode(hash_hmac('sha1', $base, $key, true));
$param['oauth_signature'] = $signature;
$query = '?' . http_build_query($param, '', '&');
$request_url = $url.$query;
//print($request_url);

$ch = curl_init($request_url);
curl_setopt($ch, CURLOPT_POST,true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
curl_setopt($ch,CURLOPT_VERBOSE,true);
curl_setopt($ch,CURLOPT_HEADER ,true);
curl_setopt($ch,CURLINFO_HEADER_OUT ,false);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_FOLLOWLOCATION,true);
$response = curl_exec($ch);
curl_close($ch);
//print $response;
var_dump($response);
//print_r($response);
//echo $response;
//header('Location: ' . "https://www.dropbox.com/0/oauth/authorize?".$response);

if(is_string($response)){
  print "is_string";
}
