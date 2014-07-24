<?php
	include 'config.php';
	
	$bulan = date("m");
	
	$sql = 	"SELECT 
				a.nama,
				a.fail_gambar,
				( SELECT DATE_FORMAT(FROM_DAYS(TO_DAYS(now()) - TO_DAYS(a.tarikh_lahir)), '%Y') + 0  ) AS umur,
				EXTRACT(DAY FROM a.tarikh_lahir) AS hari,
				( SELECT date_format(now(),'%m') ) as bulan,
				( SELECT date_format(now(),'%Y') ) as tahun
				FROM pegawai a
				WHERE a.tarikh_lahir LIKE '%-".$bulan."-%' 
				ORDER BY EXTRACT(DAY FROM a.tarikh_lahir)						
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