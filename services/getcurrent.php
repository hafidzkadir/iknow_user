<?php
	include 'config.php';
	
	$sql = 	"SELECT 
				a.id,a.nama,	
				(   SELECT DATE_ADD(curdate(), INTERVAL(2-DAYOFWEEK(curdate())) DAY) ) AS mula,
				(   SELECT DATE_ADD(curdate(), INTERVAL(6-DAYOFWEEK(curdate())) DAY) ) AS tamat
				FROM aktiviti a
				WHERE a.tarikh_mula BETWEEN 
					DATE_ADD(curdate(), INTERVAL(2-DAYOFWEEK(curdate())) DAY) AND 
					DATE_ADD(curdate(), INTERVAL(6-DAYOFWEEK(curdate())) DAY)	
				";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$current = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"items":'. json_encode($current) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>