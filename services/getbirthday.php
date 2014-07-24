<?php
	include 'config.php';
	
	$bulan = date("m");
	
	$sql = 	"SELECT 
				count(nokp) AS jumlah
				FROM pegawai
				WHERE tarikh_lahir LIKE '%-".$bulan."-%' 	
				";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$birthday = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"item":'. json_encode($birthday) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>