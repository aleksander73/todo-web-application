<?php

include('../../db_manager.php');

// ------------------------------------------------------------------------------

$responseMessage = null;

// ------------------------------------------------------------------------------

// Read the posted data

$userUsername = $_POST['username'];
$userPassword = $_POST['password'];

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "INSERT INTO $database.users(Username, Password) VALUES (:username, :password)";
$statement = $pdo->prepare($sql);
$statement->bindParam(':username', $userUsername);
$statement->bindParam(':password', $userPassword);
$success = $statement->execute();

if($success) {
    $responseMessage = "info: New user '$userUsername' stored in the database";
} else {
    $responseMessage = "error: New user '$userUsername' was NOT stored in the database";
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