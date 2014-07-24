<?php
	include 'config.php';
	
	$year = date("Y");
	
	$sql = 	"SELECT 	
						a.nama,
						a.tempat,
						a.tarikh,
						a.masa " . 
			"FROM 		aktiviti a " .
			"WHERE 		a.id=:id AND a.tahun = $year " . 
			"GROUP BY 	a.id " .	
			"ORDER BY 	a.id";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->prepare($sql);  
		$stmt->bindParam("id", $_GET[id]);
		$stmt->execute();
		$activity = $stmt->fetchObject();  
		$dbh = null;
		echo '{"item":'. json_encode($activity) .'}'; 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>