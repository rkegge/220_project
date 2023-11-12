<?php

require_once("../general/headerLoggedIn.php");

private $servername = "localhost";
private $username = "u20426586";
private $password = "xvirfcyu";
private $db = "u20426586";

$conn = new mysqli($servername, $username, $password, $db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buttonValue"])) {
        $buttonValue = $_POST["buttonValue"];

        // hidden input vals
        $name = $_POST["articleName"];
        $api = $_POST["api"];


        if ($buttonValue === "View Article") {

            echo '<h2>View the full article below.</h2>';
            echo '<a id="link" href="../../home.php">Go back to your articles!</a>';

            
            $sqls = "SELECT * FROM articles WHERE `articleName`='" . $name . "' && `Api`='" . $api . "'";
            
            
            $result = $conn->query($sqls);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    

                    echo '<div class="desc">';
                    echo '<p>' . $row["description"] . " " . $row["hashtags"] .  '</p>';
                    echo '</div>';


                    echo '<div id="revs">';
                    echo '<p>Comments</p>';
                    $sqlx = "SELECT * FROM `reviews` WHERE `articleName` ='" . $row["articleName"] . "'";
                    $revs = $GLOBALS['conn']->query($sqlx);

                    if ($revs->num_rows > 0) {
                        // Output data in cards
                        while($reviewRow = $revs->fetch_assoc()) {
                            echo '<p>' . $reviewRow["review"] .  '</p>';
                            getUser($reviewRow["userApi"]);
                        }
                    }
                    echo '</div>';


                    echo '<form id="rateAndReview" method="post" action="./php/createArticle/home.php">


                            <input type="hidden" name="api" value="' . $row['Api'] . '">
                            <input type="hidden" name="articleName" value="' . $row["articleName"] . '">

                            
                            <p><label for="rate">Leave a comment </label></p>

                            <input class="style" type="text" id="comment" name="comment" required>

                            <p><input id="rateAndReviewsub" type="submit" name="buttonValue" value="Rate and Review"></p>

                        </form>';


                }
            }

        }
    }
}

function getUser($api){
    // Get user name from user's API
    $sqls = "SELECT `name` FROM `users` WHERE `Api` = '" . $api . "'";
    $res = $GLOBALS['conn']->query($sqls);

    if ($res && $userData = $res->fetch_assoc()) {
        echo '<h3>-' . $userData['name'] . '-</h3>';
    } else {
        echo '<h3>-No user found-</h3>';
    }
}

require_once("../general/footer.php");

?>
