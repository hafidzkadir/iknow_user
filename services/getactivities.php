<?php
	include 'config.php';
	
	$year = date("Y");
	
	$sql = 	"SELECT 	a.id,
						a.nama " . 
			"FROM 		aktiviti a " .
			"WHERE 		a._kod_aktiviti=:kod AND a.tahun = $year " . 
			"GROUP BY 	a.id " .	
			"ORDER BY 	a.id";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->prepare($sql);  
		$stmt->bindParam("kod", $_GET[kod]);
		$stmt->execute();
		$activities = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"items":'. json_encode($activities) .'}'; 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>