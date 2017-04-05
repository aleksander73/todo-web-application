<?php

include('../../db_manager.php');
session_start();

// ------------------------------------------------------------------------------

$responseMessage = null;

// ------------------------------------------------------------------------------

// Read the posted data

$userPassword = $_POST['password'];

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "UPDATE $database.users SET Password=:password WHERE Username=:username";
$parameters = array('password' => $userPassword, 'username' => $_SESSION['username']);

$statement = $pdo->prepare($sql);
$statement->bindParam(':password', $userPassword);
$statement->bindParam(':username', $_SESSION['username']);
$success = $statement->execute();

if($success) {
    $responseMessage = "info: User '$userUsername' updated in the database";
} else {
    $responseMessage = "error: User '$userUsername' was NOT updated in the database";
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