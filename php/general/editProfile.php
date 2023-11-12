<?php
    // echo("IN FORM EDIT VALIDATE");
    $newUsername = $newBirthday = $newOcc = $newCell = $newRelation = $uploadedImage = "";
    // = $newEmail

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get values from the form
        $newUsername = $_POST["newUsername"];
        $newBirthday = $_POST["newBirthday"];
        $newOcc = $_POST["newOccupation"];
        $newCell = $_POST["newCell"];
        // $newEmail = $_POST["newEmail"];
        $newRelation = $_POST["newRelationship"];

        $uploadedImage = $_POST["filename"];

        

        // echo("!!!!uploadedImage: " . $uploadedImage . '!!!!!');

        // Include your database configuration and perform database operations here
        include '../../config.php';
        $instance = new Database();
        $instance->editProfile($newUsername, $newBirthday, $newOcc, $newCell, $newRelation, $uploadedImage);
    }
?>
