<?php
include 'config.php';

if (isset($_GET['articleName'])) {
    $articleName = $_GET['articleName'];

    $instance = new Database();
    $messages = $instance->getComments($articleName);

    header('Content-Type: application/json');
    echo json_encode(['comments' => $messages]);
} else {
    echo json_encode(['comments' => []]);
}
?>
