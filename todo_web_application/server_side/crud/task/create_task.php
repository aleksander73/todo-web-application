<?php

include('../../db_manager.php');
session_start();

// ------------------------------------------------------------------------------

$responseMessage = null;

// ------------------------------------------------------------------------------

// Read the posted data

$taskName = $_POST['task']['name'];

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "INSERT INTO $database.tasks(Name, Username) VALUES (:name, :username)";
$statement = $pdo->prepare($sql);
$statement->bindParam(':name', $taskName);
$statement->bindParam(':username', $_SESSION['username']);
$success = $statement->execute();

if($success) {
    $responseMessage = "info: Task '$taskName' stored in the database";
} else {
    $responseMessage = "error: Task '$taskName' was NOT stored in the database";
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