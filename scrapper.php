<?php 
require "db.php";

function scrap_bank($month,$year){
	$agent = "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:10.0.2) Gecko/20100101 Firefox/10.0.2";
	$url = 'https://ib.bankmandiri.co.id/retail/Login.do';
	$url1 = 'https://ib.bankmandiri.co.id/retail/Login.do?action=form&lang=in_ID';
	
	$link = db_connect();
	$result = mysql_query("select user,password from pengguna");
	$user = mysql_fetch_object($result);
	$fields = array(
            'action'=>urlencode("result"),
            'password'=>urlencode($user->password),
            'userID'=>urlencode($user->user),
            'image.x'=>urlencode("0"),
            'image.y'=>urlencode("0"),
        );

	//url-ify the data for the POST
	$fields_string = '';
	foreach($fields as $key=>$value) { 
		$fields_string .= $key.'='.$value.'&'; 
	}
	rtrim($fields_string,'&');
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

  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,$url);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch,CURLOPT_POST,count($fields));
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);

  //execute post
  $result = curl_exec($ch);

  $url2 = 'https://ib.bankmandiri.co.id/retail/TrxHistoryInq.do';
  $month_31 = array(1,3,5,7,8,10,12);
  $month_30 = array(4,6,9,11);
  if(in_array($month,$month_31)){
    $max_day = 31;
  }else if(in_array($month,$month_30)){
    $max_day = 30;
  }else{
    if($year%4 == 0){
      $max_day = 29;
    }else{
      $max_day = 28;
    }
  }
  $fields = array(
              'action'=>urlencode("result"),
              'fromAccountID'=>urlencode("20100531019956"),
              'fromDay'=>urlencode("1"),
	            'fromMonth'=>urlencode($month),
      	      'fromYear'=>urlencode($year),
      	      'orderBy'=>urlencode("ASC"),
	            'searchType'=>urlencode("R"),
      	      'sortType'=>urlencode("Date"),
   	          'toDay'=>urlencode($max_day),
              'toMonth'=>urlencode($month),
              'toYear'=>urlencode($year),
          );

  //url-ify the data for the POST
  $fields_string = '';
  foreach($fields as $key=>$value) {
          $fields_string .= $key.'='.$value.'&';
  }
  trim($fields_string,'&');

  //open connection
  $ch = curl_init();
  //set the url, number of POST vars, POST data
  curl_setopt($ch,CURLOPT_URL,$url2);
  curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);
  curl_setopt($ch,CURLOPT_POST,count($fields));
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
  curl_setopt($ch, CURLOPT_USERAGENT, $agent);


  //execute post
  $result = curl_exec($ch);
  
  $oldSetting = libxml_use_internal_errors( true );
  libxml_clear_errors();
  $html = new DOMDocument();

  $result = trim($result);
  $html->loadHTML($result);
  $xpath = new DOMXPath($html);
  $bunga_nodes = $xpath->query('//tr[td="Bunga Rekening"]/td[4]');
  $bunga_node = $bunga_nodes->item(0);
  $bunga = $bunga_node->nodeValue;
  $bunga = str_replace(".","",$bunga);
  $bunga = str_replace(",",".",$bunga);
  
  if($bunga > 0){
    mysql_query(sprintf("INSERT INTO bunga (bulan,tahun,bunga) values('%s','%s',%f)",mysql_real_escape_string   ($month),mysql_real_escape_string($year),$bunga));
  }
  
  //$ch = curl_init();
  curl_setopt($ch,CURLOPT_URL,"https://ib.bankmandiri.co.id/retail/Logout.do?action=result");
  curl_setopt($ch,CURLOPT_HTTPGET, TRUE);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,TRUE);
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);
  $result = curl_exec($ch);
  curl_close($ch);
  
  return $bunga;
}

function scrap_cron(){
  $year = date("Y");
  $month = date("n");
  if($month == 1){
    $month = 12;
    $year--;
  }else{
    $month--;
  }
  echo scrap_bank($month,$year);
}
