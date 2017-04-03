<?php

include('../db_manager.php');
session_start();

// ------------------------------------------------------------------------------

$responsePermission = false;

// ------------------------------------------------------------------------------

// Read the included data

$receivedUsername = $_GET['username'];
$receivedPassword = $_GET['password'];

// ------------------------------------------------------------------------------

$pdo = DB_Manager::getInstance()->openConnection();
$database = parse_ini_file('../config.ini')['dbname'];

$sql = "SELECT * FROM $database.users WHERE Username=:username";
$parameters = array('username' => $receivedUsername);

$statement = $pdo->prepare($sql);
$statement->execute($parameters);
$statement->setFetchMode(PDO::FETCH_ASSOC);

// Fetch the only row in result set
$userFound = $statement->fetch();

if($userFound != null) {
    $dbPassword = $userFound['Password'];
    if($receivedPassword == $dbPassword) {
        $responsePermission = true;
    }
}

DB_Manager::getInstance()->closeConnection();

// ------------------------------------------------------------------------------

// After confirming that the user is valid, store their information in a session variable

if($responsePermission) {
    $_SESSION['username'] = $receivedUsername;
} else {
    session_destroy();
}

// ------------------------------------------------------------------------------

// Send the response to the client

$data = array(
    'permission' => $responsePermission
);
$response = json_encode($data);

echo $response;

?>