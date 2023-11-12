<?php

    $Api = $email = $date = $genre = $hashtags = $articleName = $bookTitle = $Author = $blurb = $description = $img = "";

    // echo "CALLING addArticle";
    // echo("AIKDHJSFAOISFDBGAKPSFV");

    var_dump($_SERVER["REQUEST_METHOD"]);

    if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {

        echo "Geeitng studd";

        $email = $_POST["email"];
        echo $email;

        

        $date = date("Y-m-d");
        echo $email;


        $genre = $_POST["Genre"];
        echo $genre;
        $hashtags = $_POST["hashtags"];
        echo $hashtags;
        $articleName = $_POST["anf"];
        echo $articleName;
        $bookTitle = $_POST["bt"];
        echo $bookTitle;
        $Author = $_POST["Author"];
        echo $Author;
        $blurb = $_POST["Blurb"];
        echo $blurb;
        $description = $_POST["Description"];
        echo $description;

        // $img = $_POST["myFile"];
        $img = $_POST["filename"];
        echo $img;

        


        include '../../config.php';
        $instance = new Database();

        $Api = $instance->getApi($email);

        //hidden input to see if creating or updating
        if($_POST["update"]){
            $oldName = $_POST["oldname"];
            $userName = $_POST["userName"];
            $instance->updateArticle($userName, $email, $Api, $date, $genre, $hashtags, $articleName, $bookTitle, $Author, $blurb, $description, $img, $oldName);
        }
        else{
            $instance->addArticle($Api, $date, $genre, $hashtags, $articleName, $bookTitle, $Author, $blurb, $description, $img);

        }

        
    }
    else{
         echo "NOT POST";
    }

?>