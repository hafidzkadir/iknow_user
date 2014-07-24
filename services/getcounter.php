<?php
	include 'config.php';
	
	$tarikh = date ("Y-m-d");
	
	$sql = 	"SELECT 
				count(nokp) AS jumlah
				FROM kaunter
				WHERE tarikh = '".$tarikh."'	
				";
	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$counter = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"item":'. json_encode($counter) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>