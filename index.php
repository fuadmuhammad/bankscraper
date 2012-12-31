<html>
<body>
Bunga
<table>
<tr>
<th>bulan</th>
<th>tahun</th>
<th>bunga</th>
</tr>
<?php
  require "db_pdo.php";
  
  $db = pdo_connect();
  $total = 0;
  foreach($db->query("Select * from bunga order by tahun,bulan") as $row){
    echo "<tr>";
    echo "<td>".$row['bulan']."</td>";
    echo "<td>".$row['tahun']."</td>";
    echo "<td>".number_format($row['bunga'],3,".",",")."</td>";
    echo "</tr>";
    $total+=$row['bunga'];
  }
?>
</table>
<b>Total Bunga = <?= number_format($total,3,".",","); ?></b>
<br/>
<br/>
<br/>
Bunga yang telah disumbangkan
<table>
<tr>
<th>bulan</th>
<th>tahun</th>
<th>bunga</th>
</tr>
<?php
  $total_bayar = 0;
  foreach($db->query("Select * from bayar order by tahun,bulan") as $row){
    echo "<tr>";
    echo "<td>".$row['bulan']."</td>";
    echo "<td>".$row['tahun']."</td>";
    echo "<td>".number_format($row['bayar'],3,".",",")."</td>";
    echo "</tr>";
    $total_bayar+=$row['bayar'];
  }
?>
</table>
<b>Total Bunga yang telah disumbangkan= <?= number_format($total_bayar,3,".",","); ?></b>

<h2>Total Bunga tersisa= <?= number_format($total-$total_bayar,3,".",","); ?></h2>
</body>
</html>
