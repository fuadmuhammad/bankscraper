<?php
require_once('bootstrap.php');
require_once "db_pdo.php";

$list = array (
    array('bulan', 'tahun', 'bunga'),
);
  
$db = pdo_connect();
$index = 1;
foreach($db->query("Select * from bunga order by tahun,bulan") as $row){
    $list[$index] = array($row['bulan'],$row['tahun'],$row['bunga']);
    $index++;
}

$fp = fopen("/tmp/dfasdf","w");
foreach($list as $field){
  fputcsv($fp,$field);
}

// Upload the file with an alternative filename
$put = $dropbox->putFile("/tmp/dfasdf", 'bunga.csv');
fclose($fp);
unlink("/tmp/dfasdf");

//Pengeluaran

$list1 = array (
    array('bulan', 'tahun', 'bayar'),
);
  
$index1 = 1;
foreach($db->query("Select * from bayar order by tahun,bulan") as $row1){
    $list1[$index1] = array($row1['bulan'],$row1['tahun'],$row1['bayar']);
    $index++;
}

$fp1 = fopen("/tmp/bayar","w");
foreach($list1 as $field1){
  fputcsv($fp1,$field1);
}

// Upload the file with an alternative filename
$dropbox->putFile("/tmp/bayar", 'bayar.csv');
fclose($fp1);
unlink("/tmp/bayar");
