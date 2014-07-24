<?php
	include 'config.php';
	
	$bulan = date("m", strtotime("-1 months"));
	$tahun = date ("Y");
	
	$sql = 	"SELECT 
				count(nokp) AS jumlah
				FROM contoh
				WHERE bulan = '".$bulan."' AND tahun = '".$tahun."'	
				";
	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$worker = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"item":'. json_encode($worker) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>