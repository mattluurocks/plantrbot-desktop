<?php

/* Get values from login form */

$db_host = $_POST['db_host'];
$db_name = $_POST['db_name'];
$db_user = $_POST['db_user'];
$db_pass = $_POST['db_pass'];

$localhost = "localhost";
$localname = "plantrbot_local";
$localuser = "root";
$localpass = "PlantRbot168!";

exec("mysqldump --user=$localuser --password=$localpass --host=$localhost $localname DATA > /var/www/output/sqldump.sql");

exec("mysql --user=$db_user --password=$db_pass --host=$db_host $db_name < /var/www/output/sqldump.sql");

	
$status = ok;

// encode the table as JSON
$jsonTable = json_encode($status);

$data = $jsonTable; // json string

if(array_key_exists('callback', $_GET)){

    header('Content-Type: text/javascript; charset=utf8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Max-Age: 3628800');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    $callback = $_GET['callback'];
    echo $callback.'('.$data.');';

}else{
    // normal JSON string
    header('Content-Type: application/json; charset=utf8');
	header('Access-Control-Allow-Origin: *');

    echo $data;
}

?>