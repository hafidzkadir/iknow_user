<?php
	include 'config.php';
	
	$sql = 	"SELECT 
				count(ayat) AS jumlah,
				ayat,
				nama
				FROM pernyataan
				WHERE tarikh BETWEEN 
					DATE_ADD(curdate(), INTERVAL(2-DAYOFWEEK(curdate())) DAY) AND 
					DATE_ADD(curdate(), INTERVAL(6-DAYOFWEEK(curdate())) DAY)	
				";
	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$moto = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"item":'. json_encode($moto) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>