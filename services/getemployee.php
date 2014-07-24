<?php
	include 'config.php';
	
	$sql = "SELECT 	e.nokp, 
					e.nama, 
					e.penyelia,
					q.kelayakan,	
					q.tugas,	
					n.perihal AS jawatan, 
					o.perihal AS sektor, 
					p.perihal AS gelaran, 
					e.telefon_rasmi, 
					e.telefon_bimbit, 
					e.emel, 
					e.fail_gambar, 
					m.nama AS nama_penyelia, 
					count(r.nokp) reportCount " . 
			"FROM 	pegawai e " .
			"LEFT JOIN diskripsi q ON q.nokp = e.nokp " .
			"LEFT JOIN pegawai r ON r.penyelia = e.nokp " .
			"LEFT JOIN pegawai m ON e.penyelia = m.nokp " .
			"LEFT JOIN _kod_jawatan n ON n.kod = e._kod_jawatan " .
			"LEFT JOIN _kod_sektor o ON o.kod = e._kod_sektor " .
			"LEFT JOIN _kod_gelaran p ON p.kod = e._kod_gelaran " .
			"WHERE e.nokp=:nokp " .
			"GROUP BY e.nama " .
			"ORDER BY e.nama";
	
	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->prepare($sql);  
		//$stmt->bindParam("id", $_GET[id]);
		$stmt->bindParam("nokp", $_GET[nokp]);
		$stmt->execute();
		$employee = $stmt->fetchObject();  
		$dbh = null;
		echo '{"item":'. json_encode($employee) .'}'; 
	} catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>