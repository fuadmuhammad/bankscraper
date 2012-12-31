<?php
  function pdo_connect(){
    if($_SERVER['HTTP_HOST'] && $_SERVER['HTTP_HOST'] == 'localhost'){
      $_SERVER['DB1_HOST']='127.0.0.1';
      $_SERVER['DB1_PORT']="";
      $_SERVER['DB1_USER']="";
      $_SERVER['DB1_PASS']="";
      $_SERVER['DB1_NAME']=""
    }
    try{
      $dbh = new PDO("mysql:host=".$_SERVER['DB1_HOST'].";port=".$_SERVER['DB1_PORT'].";dbname=".$_SERVER['DB1_NAME'], 
            $_SERVER['DB1_USER'], $_SERVER['DB1_PASS']);
      return $dbh;
    }catch (PDOException $e){
      print "Error ".$e->getMessage()."</br>";
      die();
    }
  }
