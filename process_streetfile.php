<?php
require_once __DIR__ . '/meekrodb.2.3.class.php';
require_once __DIR__ . '/sqlite.php';

        set_time_limit(0);
        ini_set('memory_limit', '-1');

$caddb = new MeekroDB('127.0.0.1', 'root', '', 'hub_cad', '3306');
$db = new MyDB();
//$result = $db->query("SELECT * FROM ms_streets where st_nm_base = 'OAKMONT' AND  l_postcode = '38632'");
$result = $db->query("SELECT * FROM ms_streets where l_postcode = '38632' or l_postcode='38671' or l_postcode='38654' or l_postcode='38680'");
while($row = $result->fetchArray(SQLITE3_ASSOC) ) {
	$left_from = $row['l_refaddr'];
	$left_to = $row['l_nrefaddr'];
	if ($left_from > $left_to){
		$left_to = $row['l_refaddr'];
		$left_from = $row['l_nrefaddr'];
	}

	$right_from = $row['r_refaddr'];
	$right_to = $row['r_nrefaddr'];
	if ($right_from > $right_to){
		$right_to = $row['r_refaddr'];
		$right_from = $row['r_nrefaddr'];
	}

	$street_direction = $row['st_nm_pref'];
	$street_name = str_replace("'", "''", $row['st_nm_base']);
	$street_type = $row['st_typ_aft'];
	$left_city = $row['city_l'];
	$right_city = $row['city_r'];

	switch($left_city){
		case "Hernando":
			$left_street_jurisdiction_id = 1;
			break;
		case "Horn Lake":
			$left_street_jurisdiction_id = 2;
			break;
		case "Southaven":
			$left_street_jurisdiction_id = 3;
			break;
		case "Olive Branch":
			$left_street_jurisdiction_id = 4;
			break;
		default:
			$left_street_jurisdiction_id = 5;
	}

        switch($right_city){
                case "Hernando":
                        $right_street_jurisdiction_id = 1;
                        break;
                case "Horn Lake":
                        $right_street_jurisdiction_id = 2;
                        break;
                case "Southaven":
                        $right_street_jurisdiction_id = 3;
                        break;
                case "Olive Branch":
                        $right_street_jurisdiction_id = 4;
                        break;
                default:
                        $right_street_jurisdiction_id = 5;
        }




	if ((trim($street_name) !="") and (trim($left_from) != "" or trim($right_from) != "")){
		echo "$left_from - $left_to $street_direction $street_name $street_type $left_city\n";
		echo "$right_from - $right_to $street_direction $street_name $street_type $right_city\n";
		echo "==-=-=-=-=-=-=-=-=-=-=-=-\n";

		$data = [
			'left_from' => $left_from,
			'left_to' => $left_to,
			'right_from' => $right_from,
			'right_to' => $right_to,
			'street_direction' => $street_direction,
			'street_name' => $street_name,
			'street_type' => $street_type,
			'left_street_jurisdiction_id' => $left_street_jurisdiction_id,
			'right_street_jurisdiction_id' => $right_street_jurisdiction_id
		];
	
		if (!is_numeric($left_from)){
			$left_from = 0;
		}
		if (!is_numeric($right_from)){
			$right_from = 0;
		}
		if (!is_numeric($left_to)){
			$left_to = 0;
		}
		if (!is_numeric($right_to)){
			$right_to = 0;
		}
			
		$sql = "insert into streets 
			(
				left_from,
				left_to,
				right_from,
				right_to,
				street_direction,
				street_name,
				street_type,
				left_street_jurisdiction_id,
				right_street_jurisdiction_id
			) VALUES (
				$left_from,
				$left_to,
				$right_from,
				$right_to,
				'$street_direction',
				'$street_name',
				'$street_type',
				$left_street_jurisdiction_id,
				$right_street_jurisdiction_id
			)";
		$street_insert = $caddb->query("$sql");
	}
			
	
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



