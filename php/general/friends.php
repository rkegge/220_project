<?php

	session_start();

    // Access session variables
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        $name = $_SESSION["user_name"];
        $api = $_SESSION["api_key"];
        $email = $_SESSION["email"];
    }


require_once("headerForFriendSearch.php");
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include '../../config.php';
    $instance = new Database();
    
    if (isset($_POST["buttonValue"])) {
        $buttonValue = $_POST["buttonValue"];

        // error_reporting(E_ALL);
        // ini_set('display_errors', 1);


        if ($buttonValue === "Delete your account :(") {
            $instance->deleteAccount($api);
        }

        if ($buttonValue === "Edit") {

        }
        if ($buttonValue === "Add" || $buttonValue === "Go Back") {

            echo '<div id="searchArticles">';
            echo '<h2>Search for friends!</h2>';

            echo '<form id="searchArticles" action="findFriend.php" method="post">';

            echo '<label for="Search">Search </label>';
            echo '<input class="style" id="Search" type="text" name="Search"><br/>';
            echo '<input id="submit" type="submit" value="Search">';
            echo '</form>';
            echo '<br/>';
            echo '</div>';
        }

        if ($buttonValue === "Add friend") {

            $friendApi = $_POST["friendId"];

            // go back to profile and add


            $instance->addFriend($friendApi);

        }

        if ($buttonValue === "Remove Friend") {

            $friendApi = $_POST["removeFriend"];

            // go back to profile and add


            $instance->removeFriend($friendApi);

        }

        if ($buttonValue === "Remove List") {//list

            $whichList = $_POST["removeList"];
            // echo "<h2>Remove from list</h2>";

            // var_dump($whichList);

            // go back to profile and add

            $instance->removeList($whichList);

        }

        if ($buttonValue === "Edit List" || $buttonValue === "Go Back To Editing") {

            $whichList = $_POST["whichList"];

            echo '<h2>Edit list, "'.$whichList.'"</h2>';

            $servername = "localhost";
            $username = "u20426586";
            $password = "xvirfcyu";
            $db = "u20426586";

            $conn = new mysqli($servername, $username, $password, $db);

            $sql = "SELECT * FROM `articlelist` WHERE `listName`='" . $whichList . "'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                echo '<div class="aroundAll"></div>';

                echo'
                        <script src="http://imy.up.ac.za/u20426586/JS/article.js"></script>
                        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
                        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
                        <link rel="stylesheet" type="text/css" href="http://imy.up.ac.za/u20426586/css/article.css">
                        <link rel="stylesheet" type="text/css" href="http://imy.up.ac.za/u20426586/css/generalstyle.css">
                        ';
                        echo '<section class="wrapper" style="text-align: center;">';
                        echo '<div class="container" style="
                        margin: 20px;
                        width:1500px;
                        padding-left:70px;
                        ">';
                        
                        echo '<div class="row" style="width: 1800px; padding-left:90px;">';

                while($rowx = $result->fetch_assoc()) {
                    // var_dump($row);
                    // echo '<h3>'.$rowx["ArticleName"].'</h3>';

                

                    // get the articles
                    $sqls = "SELECT * FROM `articles` WHERE `articleName`='" . $rowx["ArticleName"] . "'";

                    // echo($sqls);

                    $results = $conn->query($sqls);
            
                    if ($results->num_rows > 0) {

                        
                        
                        while($row = $results->fetch_assoc()) {
                            // var_dump($row);
                            // var_dump($row['bookTitle']);
                            echo '
                            <div class="col-sm-12 col-md-6 col-lg-4 mb-4">';

                            // Get the user info
                                $userQuery = "SELECT * FROM `users` WHERE `Api`='" . $row["Api"] . "'";
                                $userDetails = $conn->query($userQuery);

                                if ($userDetails->num_rows > 0) {
                                    while ($rowd = $userDetails->fetch_assoc()) {
                                        $photo = $rowd['photo'];
                                        $name = $rowd['name'];
                                        $email = $rowd['email'];
                                        $api = $rowd['Api'];
                                        $name = $rowd['name'];
                                    }
                                }
            
                            
                            echo '
                            <a onclick="loadArticle(\'' . $email . '\', \'' . $api . '\', \'' . $photo . '\', \'' . $_SESSION["api_key"] . '\',\'' . $row["img"] . '\',\'' . $row["articleName"] . '\',\'' . $row["date"] . '\',\'' . $row["Author"] . '\',\'' . $name . '\',\'' . $row["bookTitle"] . '\',\'' . $row["description"] . '\',\'' . $row["genre"] . '\',\'' . $row["hashtags"] . '\')">

                            
                            <div class="card text-dark card-has-bg click-col" style="background-image: url(\'http://imy.up.ac.za/u20426586/img/bk/' . $row["img"] . '\');">
                                <img class="card-img d-none" src="./img/bk/'. $row["img"] . '">
                                <div class="card-img-overlay d-flex flex-column">
                                <div class="card-body">
                                    <small class="card-meta mb-2">' . $row["bookTitle"] . '</small>
                                    <h4 class="card-title mt-0 " style="color: #c98928; font-size:1.2em;">' . $row["articleName"] . '</h4>
                                    <small><i class="far fa-clock"></i>#' . $row["genre"] . '</small>
                                    </div>
                                    <div class="card-footer">
                                <div class="media">';

                                

                                echo' <img class="mr-3 rounded-circle" src="http://imy.up.ac.za/u20426586/img/'. $photo . '" alt="Generic">
                                <div class="media-body">
                                    <h2 class="my-0 text-dark d-block" style="font-size:1.4em; font-weight:bold;">'. $name . '</h2>
                                    <small>' . $row["date"] . '</small>


                                    <form id="editArt" method="post" action="friends.php">
                                        <input type="hidden" name="articleName" value="' . $row["articleName"] . '">
                                        <input type="hidden" name="whichList" value="' . $whichList . '">
                                        <input id="editArt" type="submit" name="buttonValue" value="Remove from List">
                                    </form>


                                </div></div></div></div></div>
            
                                </a>
                                
                            </div>';
                            
                        }
                        
                        
                    } else {
                        echo '<p style="text-align:center">You have not published any articles yet.</p>';
                    }

                }

                echo '</div>';
                        echo '</div>';
                        echo '</section>';


            } else {
                echo "You have no articles in your list yet. See below to get started on adding some :)";
            }


            // display current articles in list

            echo '<form id="searchArticles" action="editList.php" method="post">';
            echo '<label for="Search">Search For articles to add! </label>';
            echo '<input type="hidden" name="whichList" value="' . $whichList . '">';
            echo '<input class="style" id="Search" type="text" name="Search"><br/>';
            echo '<input id="submit" type="submit" value="Search">';
            echo '</form>';
            echo '<br/>';

        }

        if ($buttonValue === "Add To List") {

            $whichList = $_POST["whichList"];
            $articleName = $_POST["articleName"];


            $instance->addToList($whichList, $articleName);

            echo '<h2>Added, "'.$articleName.'" to your list!</h2>';

            echo '<form id="searchArticles" action="friends.php" method="post">';
            echo '<input type="hidden" name="whichList" value="' . $whichList . '">';
            echo '<input id="submit" type="submit" name="buttonValue" value="Go Back To Editing">';
            echo '</form>';

        }

        if ($buttonValue === "Remove from List") {


            $whichList = $_POST["whichList"];
            $articleName = $_POST["articleName"];


            $instance->removeFromList($whichList, $articleName);

            echo '<h2>Removed, "'.$articleName.'" from your list!</h2>';

            echo '<form id="searchArticles" action="friends.php" method="post">';
            echo '<input type="hidden" name="whichList" value="' . $whichList . '">';
            echo '<input id="submit" type="submit" name="buttonValue" value="Go Back To Editing">';
            echo '</form>';

        }
    }


   
    
}

require_once("footer.php");

?>

