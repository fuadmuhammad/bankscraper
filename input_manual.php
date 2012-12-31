<html>
<body>
<?php
  require "db_pdo.php";
  if(isset($_POST['bulan'])){
    $db = pdo_connect();
    $stmt = $db->prepare("INSERT INTO bunga values(:bulan,:tahun,:bunga)");
    $stmt->bindParam(':bulan',$bulan);
    $stmt->bindParam(':tahun',$tahun);
    $stmt->bindParam(':bunga',$bunga);
    
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $bunga = $_POST['bunga'];
    
    $stmt->execute();
    header("Location:index.php");
  }
?>
<h2>Input Manual</h2>
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
<label for="bunga">Bunga:</label>
<input type="text" name="bunga" />
<br/>
<input type="submit" value="Simpan">
</form>
</body>
</html>
