<?php
require_once __DIR__ . '/meekrodb.2.3.class.php';
require_once __DIR__ . '/sqlite.php';

        set_time_limit(0);
        ini_set('memory_limit', '-1');

$caddb = new MeekroDB('127.0.0.1', 'root', '', 'hub_cad', '3306');
$db = new MyDB();
$result = $db->query("SELECT * FROM ms_streets where st_nm_base = 'OAKMONT' AND  l_postcode = '38632'");
while($row = $result->fetchArray(SQLITE3_ASSOC) ) {
	$left_from = $row['l_refaddr'];
	$left_to = $row['l_nrefaddr'];
	$right_from = $row['r_refaddr'];
	$right_to = $row['r_nrefaddr'];
	$street_direction = $row['st_nm_pref'];
	$street_name = $row['st_nm_base'];
	$street_type = $row['st_typ_aft'];
	$left_city = $row['city_l'];
	$right_city = $row['city_r'];

}





//var_dump($result->fetchArray());

/* for reference
	if ($numrows==0){
		$sql = "insert into site_stats (s_site_code, s_date, s_cad_calls, s_rms_reports, s_jms_reports, s_crt_reports) VALUES ('$site', '$curr_date', '$cad_calls', '$rms_reports', '$jms_reports', '$crt_reports')";
	}  else {
		$id = $site_results[0]['s_id'];
		$sql = "update site_stats set s_cad_calls='$cad_calls', s_rms_reports='$rms_reports', s_jms_reports='$jms_reports', s_crt_reports='$crt_reports' where s_id='$id'";
	}
	echo "SQL: $sql\n";
	$site_update = $db->query("$sql");
*/
exit;



