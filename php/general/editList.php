<?php

require_once("headerForFriendSearch.php");
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["Search"];

    // echo("SEARCH");
    // echo( $search );

    include '../../config.php';
    $instance = new Database();

    $article = $instance->retrieveArticle($search);

    $whichList = $_POST["whichList"];

    // echo("USER ");
    // var_dump( $user );

    if($article){
        echo '<h2>';
        echo ($article['articleName']);
        echo '</h2>';

        echo '
        <style>
            .profile-container {
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .profile-image {
                width: 250px;
                height: 250px;
                border-radius: 50%;
                overflow: hidden;
            }

            .profile-image img {
                width: 100%;
                height: auto;
            }
        </style>

        <!-- DISPLAY PERSONAL INFO -->

        <div class="profile-container">
            <div class="profile-image">
                <img src="http://imy.up.ac.za/u20426586/img/bk/';
        
        echo ($article["img"] !== null) ? $article["img"] : "profile.jpg";
        
        echo '">
            </div>
        </div>';

        // Add friend button
        echo '<form method="POST" action="friends.php">';
        echo '<input type="hidden" name="whichList" value="' . $whichList . '">';
        echo '<input type="hidden" name="articleName" value="' . $article['articleName'] . '">';
        echo '<input id="submit" type="submit" name="buttonValue" value="Add To List">';
        echo '</form>';

        // Go back button
        echo '<form method="POST" action="friends.php">';
        echo '<input id="submit" type="submit" name="buttonValue" value="Go Back">';
        echo '</form>';
    }
    else{
        echo '<h2>No Article found :(</h2>';

        // Go back button
        echo '<form method="POST" action="friends.php">';
        echo '<input id="submit" type="submit" name="buttonValue" value="Go Back">';
        echo '</form>';
    }
}

require_once("footer.php");

?>
