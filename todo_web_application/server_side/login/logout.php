<?php

session_start();
$sessionStillActive = (isset($_SESSION['username']));
session_destroy();

$message = null;

if($sessionStillActive) {
    $message = 'You have logged out successfully.';
} else {
    $message = 'The session has expireed.';
}

$data = array(
    'message' => $message
);
$response = json_encode($data);

echo $response;

?>