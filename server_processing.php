<?php
loadEnv(__DIR__ . '/.env');

// DB table to use
$table = 'pkmnjourney_users';

// Table's primary key
$primaryKey = 'user_id';

//db -> Database Column Name (Back-end)
//dt -> DataTables Column Name (Front-end)
/*$columns = array(
    array('db' => 'user_id', 'dt' => 'user_id'),
    array('db' => 'username', 'dt' => 'username'),
    array('db' => 'password', 'dt' => 'password'),
    array('db' => 'registration_date', 'dt' => 'registration_date')
);*/
$columns = "*"; //get all columns

// SQL server connection information


$sql_details = array(
    'user' => $_ENV['DB_USER'],
    'pass' => $_ENV['DB_PASSWORD'],
    'db' => $_ENV['DB_NAME'],
    'host' => $_ENV['DB_HOST']
    // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);

require('connectors/ssp.class.php');

//Changed to POST cause of URL GET Limits on bigger tables.
echo json_encode(SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns));


function loadEnv($filePath) {
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }
    }
}

