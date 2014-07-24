<?php
	include 'config.php';
	
	$tarikh = date ("Y-m-d");
	
	$sql = 	"SELECT 
				EXTRACT(DAY FROM a.tarikh) AS hari,
				( SELECT date_format(now(),'%m') ) as bulan,
				( SELECT date_format(now(),'%Y') ) as tahun,
				a.nokp,
				b.nama,
				b.fail_gambar,
				c.perihal AS jawatan	
				FROM kaunter a
				LEFT JOIN pegawai AS b ON b.nokp = a.nokp
				LEFT JOIN _kod_jawatan AS c ON c.kod = b._kod_jawatan
				WHERE a.tarikh = '".$tarikh."'
				ORDER BY a.id						
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