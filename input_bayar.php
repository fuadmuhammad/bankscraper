<html>
<body>
<?php
  require "db_pdo.php";
  if(isset($_POST['bulan'])){
    $db = pdo_connect();
    $stmt = $db->prepare("INSERT INTO bayar values(:bulan,:tahun,:bayar)");
    $stmt->bindParam(':bulan',$bulan);
    $stmt->bindParam(':tahun',$tahun);
    $stmt->bindParam(':bayar',$bayar);
    
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $bayar = $_POST['bayar'];
    
    $stmt->execute();
    header("Location:index.php");
  }
?>
<h2>Input Manual Pembayaran</h2>
<form method="POST">
<label for="bulan">Bulan:</label>
<select name="bulan">
<?php for($i=1; $i<=12; $i++):?>
<option value="<?= $i ?>"><?= $i ?></option>
<?php endfor; ?>
</select>
<br/>
<label for="tahun">Tahun:</label>
<select name="tahun">
<?php for($i=2008; $i<=3112; $i++):?>
<option value="<?= $i ?>"><?= $i ?></option>
<?php endfor; ?>
</select>
<br/>
<label for="bunga">Pembayaran:</label>
<input type="text" name="bayar" />
<br/>
<input type="submit" value="Simpan">
</form>
</body>
</html>
