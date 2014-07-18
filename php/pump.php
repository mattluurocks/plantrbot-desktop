<?PHP

// main code to execute manually running the pump

  $pumpScript = '/var/www/plantrbot_desktop/php/runPump.sh';

  // Path to python executable  - either FULL path or relative to PHP script
  //$pythonExec = '/usr/bin/python';
  $pumpExec = '/bin/sh';
 

  // Check the file exists and PHP has permission to execute it
  clearstatcache();
  if (!file_exists($pumpExec)) {
    exit("The executable '$pumpExec' does not exist!");
  }
  if (!is_executable($pumpExec)) {
    exit(("The executable '$pumpExec' is not executable!"));
  }
  if (!file_exists($pumpScript)) {
    exit("The script file '$pumpScript' does not exist!");
  }

  // Execute it, and redirect STDERR to STDOUT so we can see error messages as well
  exec("$pumpExec \"$pumpScript\" 2>&1", $output);

  // Show the output of the script
  //print_r($output);
  if ($output = 1) {
  	$stat = 1;
  	} else {
  	echo json_encode($output);
  	}

// populate the table with rows of data
$table['status'] = $stat;

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
