<?php
include 'config.php';

if (isset($_GET['api'])) {
    $api = $_GET['api'];

    $instance = new Database();
    $messages = $instance->getMessages($api);

    header('Content-Type: application/json');
    echo json_encode($messages);
} else {
    // Handle the case when the 'api' parameter is not set
    echo json_encode([]);
}
?>
