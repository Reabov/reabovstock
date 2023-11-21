<?
	$db =  mysqli_connect($SERVER_NAME, $DB_LOGIN, $DB_PASS, $DB_NAME, $DB_PORT);


    if (!$db) {
        echo "ERROR: Unable to connect to MySQL." . PHP_EOL . '<br>';
        echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL . '<br>';
        echo "Debugging error: " . mysqli_connect_error() . PHP_EOL . '<br>';
        exit;
    }

//mysqli_close($db);
?>