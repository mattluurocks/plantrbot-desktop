<?PHP

// code to load config file into store

  $configTxt = '/var/www/config.txt';
 
  // Check the file exists
  clearstatcache();
  if (!file_exists($configTxt)) {
  	$json = array('status' => (int) ["0"]);
  }
  
  
$Read = file("$configTxt");

//first get keyValue for device
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
	$lineParts = explode('=',$Lines); // expand the line into pieces to work with
	if ( $lineParts[0] == "keyValue" ) { // if the first column is 2
		$keyValue = str_replace("\n", "", $lineParts[1]); // increment the second column
		break; // we're done so exit the loop, saving cycles
	}
};

//get pump runtime
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
	$lineParts = explode('=',$Lines); // expand the line into pieces to work with
	if ( $lineParts[0] == "runTime" ) { // if the first column is 2
		$runTime = str_replace("\n", "", $lineParts[1]); // increment the second column
		break; // we're done so exit the loop, saving cycles
	}
};

//get first pump run
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
	$lineParts = explode('=',$Lines); // expand the line into pieces to work with
	if ( $lineParts[0] == "firstRun" ) { // if the first column is 2
		$firstRun = str_replace("\n", "", $lineParts[1]); // increment the second column
		break; // we're done so exit the loop, saving cycles
	}
};

//get second pump run
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
	$lineParts = explode('=',$Lines); // expand the line into pieces to work with
	if ( $lineParts[0] == "secondRun" ) { // if the first column is 2
		$secondRun = str_replace("\n", "", $lineParts[1]); // increment the second column
		break; // we're done so exit the loop, saving cycles
	}
};

//get email enabled status
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
        $lineParts = explode('=',$Lines); // expand the line into pieces to work with
        if ( $lineParts[0] == "emailEnable" ) { // if the first column is 2
                $emailEnable = str_replace("\n", "", $lineParts[1]); // increment the second column
                break; // we're done so exit the loop, saving cycles
        }
};

//get email server
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
        $lineParts = explode('=',$Lines); // expand the line into pieces to work with
        if ( $lineParts[0] == "emailServer" ) { // if the first column is 2
                $emailServer = str_replace("\n", "", $lineParts[1]); // increment the second column
                break; // we're done so exit the loop, saving cycles
        }
};

//get email user
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
        $lineParts = explode('=',$Lines); // expand the line into pieces to work with
        if ( $lineParts[0] == "emailUser" ) { // if the first column is 2
                $emailUser = str_replace("\n", "", $lineParts[1]); // increment the second column
                break; // we're done so exit the loop, saving cycles
        }
};

//get email pass
foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
        $lineParts = explode('=',$Lines); // expand the line into pieces to work with
        if ( $lineParts[0] == "emailPass" ) { // if the first column is 2
                $emailPass = str_replace("\n", "", $lineParts[1]); // increment the second column
                break; // we're done so exit the loop, saving cycles
        }
};

$json = array('status' => (int) ["1"],'key' => ["$keyValue"],'runTime' => ["$runTime"],'firstRun' => ["$firstRun"],'secondRun' => ["$secondRun"],'emailEnable' => ["$emailEnable"],'emailServer' => ["$emailServer"],'emailUser' => ["$emailUser"],'emailPass' => ["$emailPass"]);

// populate the table with rows of data
$table['config'] = $json;

// encode the table as JSON
$jsonTable = json_encode($json);

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
