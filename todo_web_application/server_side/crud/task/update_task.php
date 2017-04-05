<?php

include('../../db_manager.php');

// ------------------------------------------------------------------------------

$responseMessage = null;

// ------------------------------------------------------------------------------

// Read the posted data

$taskID = $_POST['id'];
$taskName = $_POST['name'];

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "UPDATE $database.tasks SET Name=:name WHERE ID=:id";
$statement = $pdo->prepare($sql);
$statement->bindParam(':name', $taskName);
$statement->bindParam(':id', $taskID);
$success = $statement->execute();

if($success) {
    $responseMessage = "info: Task '$taskName' updated in the database";
} else {
    $responseMessage = "error: Task '$taskName' was NOT updated in the database";
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