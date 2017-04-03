<?php

include('../../db_manager.php');
session_start();

// ------------------------------------------------------------------------------

$responseTasks = null;

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../../config.ini')['dbname'];

$sql = "SELECT ID, Name FROM $database.tasks WHERE Username=:_username";
$parameters = array('_username' => $_SESSION['username']);

$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$statement->setFetchMode(PDO::FETCH_ASSOC);

$responseTasks = $statement->fetchAll();

DB_Manager::getInstance()->closeConnection();

// ------------------------------------------------------------------------------

// Send the response to the client

$data = array (
    'tasks' => $responseTasks
);
$response = json_encode($data);

echo $response;

?>