<?PHP

// code to load config file into store

  $configTxt = '/var/www/config.txt';
 
  // Check the file exists
  clearstatcache();
  if (!file_exists($configTxt)) {
  	$json = array('status' => (int) ["0"]);
  }
  
$Read = file("$configTxt");

//set pump runtime
if (isset($_POST['pumpRun'])){
	$runTime = $_POST['pumpRun'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "runTime" ) { // if the first column is 2
			$lineParts[1] = $runTime."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set first pump run
if (isset($_POST['firstRun'])){
	$firstRun = $_POST['firstRun'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "firstRun" ) { // if the first column is 2
			$lineParts[1] = $firstRun."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set second pump run
if (isset($_POST['secondRun'])){
	$secondRun = $_POST['secondRun'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "secondRun" ) { // if the first column is 2
			$lineParts[1] = $secondRun."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set remote enabled check flag
if (isset($_POST['remoteEnable'])){
	$remoteEnable = $_POST['remoteEnable'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "remoteEnable" ) { // if the first column is 2
			$lineParts[1] = $remoteEnable."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set remote db host
if (isset($_POST['db_host'])){
	$db_host = $_POST['db_host'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "host" ) { // if the first column is 2
			$lineParts[1] = $db_host."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set remote db name
if (isset($_POST['db_name'])){
	$db_name = $_POST['db_name'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "db" ) { // if the first column is 2
			$lineParts[1] = $db_name."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set remote db user
if (isset($_POST['db_user'])){
	$db_user = $_POST['db_user'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "user" ) { // if the first column is 2
			$lineParts[1] = $db_user."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set remote db pass
if (isset($_POST['db_pass'])){
	$db_pass = $_POST['db_pass'];
	foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
		$lineParts = explode('=',$Lines); // expand the line into pieces to work with
		if ( $lineParts[0] == "pass" ) { // if the first column is 2
			$lineParts[1] = $db_pass."\n"; // increment the second column
			$Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variable $News
			break; // we're done so exit the loop, saving cycles
		}
	}
};

//set email enable
if (isset($_POST['emailEnable'])){
        $emailEnable = $_POST['emailEnable'];
        foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
                $lineParts = explode('=',$Lines); // expand the line into pieces to work with
                if ( $lineParts[0] == "emailEnable" ) { // if the first column is 2
                        $lineParts[1] = $emailEnable."\n"; // increment the second column
                        $Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variab$
                        break; // we're done so exit the loop, saving cycles
                }
        }
};

//set email server
if (isset($_POST['emailServer'])){
        $emailServer = $_POST['emailServer'];
        foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
                $lineParts = explode('=',$Lines); // expand the line into pieces to work with
                if ( $lineParts[0] == "emailServer" ) { // if the first column is 2
                        $lineParts[1] = $emailServer."\n"; // increment the second column
                        $Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variab$
                        break; // we're done so exit the loop, saving cycles
                }
        }
};

//set email user
if (isset($_POST['emailUser'])){
        $emailUser = $_POST['emailUser'];
        foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
                $lineParts = explode('=',$Lines); // expand the line into pieces to work with
                if ( $lineParts[0] == "emailUser" ) { // if the first column is 2
                        $lineParts[1] = $emailUser."\n"; // increment the second column
                        $Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variab$
                        break; // we're done so exit the loop, saving cycles
                }
        }
};

//set email pass
if (isset($_POST['emailPass'])){
        $emailPass = $_POST['emailPass'];
        foreach ( $Read as $LineNum => $Lines ) { // iterate through each line
                $lineParts = explode('=',$Lines); // expand the line into pieces to work with
                if ( $lineParts[0] == "emailPass" ) { // if the first column is 2
                        $lineParts[1] = $emailPass."\n"; // increment the second column
                        $Read[$LineNum] = implode("=",$lineParts); // glue the line back together, we're updating the Read array directly, rather than the copied variab$
                        break; // we're done so exit the loop, saving cycles
                }
        }
};

$UpdatedContents = implode($Read); // put the read lines back together (remember $Read as been updated) using "\n" or "\r\n" whichever is best for the OS you're running on
file_put_contents($configTxt,$UpdatedContents); // overwrite the file

//modify the crontab if timings have changed

if (isset($_POST['firstRun']) && isset($_POST['secondRun'])){

$cronfile = "/var/www/plantrbot_desktop/crontab.txt";
$newCron = "0 $firstRun,$secondRun * * * /usr/bin/python /var/www/datalogger_relay.py > /dev/null 2>&1\n";
$fileContent = file_get_contents($cronfile);
$stringToBeFound = 'datalogger_relay';
$lines = explode("\n", $fileContent);
$result = array();
foreach($lines as $k => $line){
  if(strpos($line, $stringToBeFound) === false){
    $result[] = $line;
  }
}
$oldCron = implode("\n", $result);
$updatedCron = $oldCron.$newCron;
file_put_contents($cronfile, $updatedCron);
exec("sudo -u root -S crontab $cronfile");

};

//send a response back to confirm status  	
$json = array('status' => (int) ["1"]);

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
