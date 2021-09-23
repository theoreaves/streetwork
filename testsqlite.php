<?php

class MyDB extends SQLite3
{
    function __construct()
    {
        $this->open('../mapping/ms_streets.sqlite');
    }
}

$db = new MyDB();

//$db->exec('CREATE TABLE foo (bar STRING)');
//$db->exec("INSERT INTO foo (bar) VALUES ('This is a test')");

$result = $db->query("SELECT * FROM ms_streets where st_nm_base = 'OAKMONT' AND  l_postcode = '38632'");
while($row = $result->fetchArray(SQLITE3_ASSOC) ) {
	echo $row['l_refaddr'] . " " . $row['fullname'] . "\n";
}
//var_dump($result->fetchArray());
