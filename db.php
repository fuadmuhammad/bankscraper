<?php
function db_connect(){
  if(isset($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == 'localhost'){
    $_SERVER['DB1_HOST']='127.0.0.1';
    $_SERVER['DB1_PORT']="";
    $_SERVER['DB1_USER']="";
    $_SERVER['DB1_PASS']="";
    $_SERVER['DB1_NAME']="";
  }
  $link = mysql_connect($_SERVER["DB1_HOST"].":".$_SERVER["DB1_PORT"] ,$_SERVER["DB1_USER"] ,$_SERVER["DB1_PASS"] );
	if(!$link){
	  die("Could not connect");
	}
	mysql_select_db($_SERVER["DB1_NAME"]);
	return $link;
}
