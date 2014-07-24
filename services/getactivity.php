<?php
	include 'config.php';
	
	$year = date("Y");
	
	$sql = 	"SELECT 	a.kod,
						a.perihal,
						b.id,
						count(b.id) jumlah " . 
			"FROM 		_kod_aktiviti a " .
			"LEFT JOIN 	aktiviti b ON b._kod_aktiviti = a.kod " .
			"WHERE b.tahun = $year " .
			"GROUP BY 	a.kod " .	
			"ORDER BY 	a.kod";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$activities = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"items":'. json_encode($activities) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>