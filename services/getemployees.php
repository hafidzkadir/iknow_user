<?php
	include 'config.php';

	$sql = 	"SELECT 	e.nokp, 
						e.nama, 
						s.perihal AS jawatan, 
						t.perihal AS gelaran, 
						e.fail_gambar, 
						count(r.nokp) reportCount " . 
			"FROM 		pegawai e " . 
			"LEFT JOIN 	pegawai r ON r.penyelia = e.nokp " .
			"LEFT JOIN 	_kod_jawatan s ON s.kod = e._kod_jawatan " .
			"LEFT JOIN 	_kod_gelaran t ON t.kod = e._kod_gelaran " .
			"GROUP BY e.nokp " .
			"ORDER BY s.kod";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$employees = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"items":'. json_encode($employees) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>