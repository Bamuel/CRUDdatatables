<?php
loadEnv(__DIR__ . '/.env');
require('connectors/ssp.class.php');

$sql_details = array(
    'user' => $_ENV['DB_USER'],
    'pass' => $_ENV['DB_PASSWORD'],
    'db' => $_ENV['DB_NAME'],
    'host' => $_ENV['DB_HOST']// ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
);

if (isset($_GET['getTables'])) {
    echo json_encode(SSP::getAllTables($sql_details));
    exit();
}
if (isset($_GET['getColoumns']) && isset($_POST['table'])) {
    echo json_encode(SSP::getAllColumns($sql_details, $_POST['table']));
    exit();
}
if (isset($_GET['getTable'])) {
    $table = $_POST['table'];
    $primaryKey = null;
    /*
    $columns = array(
    array('db' => 'user_id', 'dt' => 'user_id'),
    array('db' => 'username', 'dt' => 'username'),
    array('db' => 'password', 'dt' => 'password'),
    array('db' => 'registration_date', 'dt' => 'registration_date')
    );
    */
    $columns = array("*"); //get all columns
    echo json_encode(SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns));
    exit();
}

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

