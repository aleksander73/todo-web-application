<?php

include('../../db_manager.php');
session_start();

// ------------------------------------------------------------------------------

$responseMessage = null;

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "DELETE FROM $database.users WHERE Username=:username";
$statement = $pdo->prepare($sql);
$statement->bindParam(':username', $_SESSION['username']);
$success = $statement.execute();

if($success) {
    $responseMessage = "info: User $userUsername deleted from the database";
} else {
    $responseMessage = "error: User $userUsername was NOT deleted from the database";
}

DB_Manager::getInstance()->closeConnection();

// ------------------------------------------------------------------------------

// Send the response to the client

$data = array(
    'message' => $responseMessage
);
$response = json_encode($data);

echo $response;

?>