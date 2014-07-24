<?php
	include 'config.php';
	
	$bulan = date("m", strtotime("-1 months"));
	$tahun = date ("Y");
	
	$sql = 	"SELECT 
				a.nokp,
				a.bulan,
				a.tahun,
				c.perihal AS kumpulan,
				b.nama,
				b.fail_gambar	
				FROM contoh a
				LEFT JOIN pegawai AS b ON b.nokp = a.nokp
				LEFT JOIN _kod_kumpulan AS c ON c.kod = a._kod_kumpulan
				WHERE a.bulan = '".$bulan."' AND tahun = '".$tahun."'
				ORDER BY a._kod_kumpulan						
				";

	try {
		$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);	
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $dbh->query($sql);  
		$worker = $stmt->fetchAll(PDO::FETCH_OBJ);
		$dbh = null;
		echo '{"item":'. json_encode($worker) .'}'; 
	} 
	catch(PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}'; 
	}
?>