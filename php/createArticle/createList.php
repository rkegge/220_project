<?php
    // echo "DSXFGHJB";
    var_dump($_SERVER["REQUEST_METHOD"]);

    if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {

        $listName = $_POST["listName"];
        $listDescription = $_POST["listDescription"];

        // echo($listName);

        include '../../config.php';
        $instance = new Database();

        $instance->addList($listName, $listDescription);

    }
    else{
         echo "NOT POST";
    }

?>