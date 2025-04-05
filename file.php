<?php 
define('DB_HOST','localhost'); // Host name
define('DB_USER','root'); // db user name
define('DB_PASS',''); // db user password name
define('DB_NAME','minisystem'); // db name


try
{
$conn = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER,DB_PASS);
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}

$dateTimeNow = date('Y-m-d H:i:s');
$dateNow = date('Y-m-d');
?>