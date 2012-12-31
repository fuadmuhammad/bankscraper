<?php 
function crawl_bank(){
	$cookie_file_path = "cookie.txt";
	$agent = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2";
	$url = 'https://ib.bankmandiri.co.id/retail/Login.do';
	$url1 = 'https://ib.bankmandiri.co.id/retail/Login.do?action=form&lang=in_ID';
	$ini_arr = parse_ini_file("account.ini");
	$fields = array(
            'action'=>urlencode("result"),
            'password'=>urlencode($ini_arr['password']),
            'userID'=>urlencode($ini_arr['user']),
            'image.x'=>urlencode("0"),
            'image.y'=>urlencode("0"),
        );

	//url-ify the data for the POST
	$fields_string = '';
	foreach($fields as $key=>$value) { 
		$fields_string .= $key.'='.$value.'&'; 
	}
	rtrim($fields_string,'&');
	//print $fields_string;
	$cookie = tempnam ("/tmp", "CURLCOOKIE");
	//open connection
	$ch = curl_init();
	//set the url, number of POST vars, POST data
	curl_setopt($ch,CURLOPT_URL,$url1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
$result = curl_exec($ch);
//print_r($result);
print "\n\n\n";

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_POSTFIELDS,"action=result&userID=****&password=***&image.x=0&image.y=0");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
//curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch,CURLOPT_POST,count($fields));
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
//curl_setopt($ch, CURLOPT_ENCODING, "");
//curl_setopt($ch, CURLOPT_AUTOREFERER, true );
//curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15000);
//curl_setopt($ch, CURLOPT_TIMEOUT, 15000);
//curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
//curl_setopt($ch,CURLOPT_REFERER,"https://ib.bankmandiri.co.id/retail/Login.do?action=form&lang=in_ID");
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
curl_setopt($ch, CURLOPT_VERBOSE, true);

//curl_setopt($ch, CURLOPT_COOKIE, '__utma=76832774.1580280207.1304230784.1304230784.1304230784.1; JSESSIONID=0000Nr8Ngzv3lMAZJ9Z3NFm68n0:-1; BIGipServerPool_ib=559458496.47873.0000; SCOOKIE=""');
/*



*/

//execute post
$result = curl_exec($ch);
//print_r($result);
//var_dump(curl_getinfo($ch));
//var_dump(curl_error($ch)  );


$url2 = 'https://ib.bankmandiri.co.id/retail/TrxHistoryInq.do';
$fields = array(
            'action'=>urlencode("result"),
            'fromAccountID'=>urlencode("20100531019956"),
            'fromDay'=>urlencode("1"),
	    'fromMonth'=>urlencode("3"),
	    'fromYear'=>urlencode("2012"),
	    'orderBy'=>urlencode("ASC"),
	    'searchType'=>urlencode("R"),
	    'sortType'=>urlencode("Date"),
 	    'toDay'=>urlencode("4"),
            'toMonth'=>urlencode("3"),
            'toYear'=>urlencode("2012"),
        );

//url-ify the data for the POST
$fields_string = '';
foreach($fields as $key=>$value) {
        $fields_string .= $key.'='.$value.'&';
}
trim($fields_string,'&');
print $fields_string;

//open connection
$ch = curl_init();
//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL,$url2);
curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
curl_setopt($ch,CURLOPT_POST,count($fields));
//curl_setopt($ch, CURLOPT_HEADER, 0);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
//curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_VERBOSE, true);


//execute post
$result = curl_exec($ch);
print_r($result);
var_dump(curl_getinfo($ch));
var_dump(curl_error($ch)  );


print "\n\n\n";
//$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,"https://ib.bankmandiri.co.id/retail/Logout.do?action=result");
curl_setopt($ch,CURLOPT_HTTPGET, TRUE);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$result = curl_exec($ch);
//print_r($result);
var_dump(curl_getinfo($ch));
var_dump(curl_error($ch)  );
curl_close($ch);
