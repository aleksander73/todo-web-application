<?php

include('../../db_manager.php');

// ------------------------------------------------------------------------------

$responseMessage = null;

// ------------------------------------------------------------------------------

// Read the posted data

$taskID = $_POST['id'];

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "DELETE FROM $database.tasks WHERE ID=:id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':id', $taskID);
$success = $statement->execute();

if($success) {
    $responseMessage = "info: Task with ID = '$taskID' deleted from the database";
} else {
    $responseMessage = "error: Task with ID = '$taskID' was NOT deleted from the database";
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