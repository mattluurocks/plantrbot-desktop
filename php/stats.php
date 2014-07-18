<?PHP

// Code to connect to the DB.
function db_connect() {
$host = $_POST['db_host'];
$db = $_POST['db_name'];
$user = $_POST['db_user'];
$pass = $_POST['db_pass'];
$con = mysql_connect($host, $user, $pass) or die('Error connecting to server');

mysql_select_db($db, $con); 

  if (!$con) {
    echo( "Unable to connect to the database server." );
    exit();
  }

  mysql_select_db($db,$con) or die( "Error selecting database.");

  return $con;
}

function CloseDbConnection($con) {
  mysql_close($con);
}

if (function_exists("db_connect")) {
    if (db_connect() === TRUE) {
        // continue
		echo( "The server was unable to perform your request in a timely manner." );
     } else {
        // failed to connect (this is a different error than the "can't include" one and 
        // actually **way** more important to handle gracefully under great load
     }
 } else {
     // couldn't load database code
	 echo( "Unable to connect to the database server." );
 }
 
// Get posted data from ajax enabled form (old code from website)
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

// Escape User Input to help prevent SQL Injection
$startDate = mysql_real_escape_string($startDate);
$endDate = mysql_real_escape_string($endDate);

$query = mysql_query("SELECT id,UNIX_TIMESTAMP(CREATED_ON) * 1000 AS DATE, TEMP, HUMIDITY, LIGHT, PUMPSTATE FROM DATA WHERE CREATED_ON BETWEEN '$startDate' AND '$endDate'");

$rows = array();
while($r = mysql_fetch_assoc($query)) {
	$temp = array('id' => (int) $r['id'],'date' => $r['DATE'],'temp' => (int) $r['TEMP'],'humidity' => (int) $r['HUMIDITY'],'light' => (int) $r['LIGHT'],'pump' => (int) $r['PUMPSTATE']);
	
	// insert the temp array into $rows
    $rows[] = $temp;
}

// populate the table with rows of data
$table['rows'] = $rows;

// encode the table as JSON
$jsonTable = json_encode($table);

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
