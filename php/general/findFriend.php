<?php

require_once("headerForFriendSearch.php");
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST["Search"];

    // echo("SEARCH");
    // echo( $search );

    include '../../config.php';
    $instance = new Database();

    $user = $instance->retrieveUserName($search);

    // echo("USER ");
    // var_dump( $user );

    if($user){
        echo '<h2>';
        echo ($user['name']);
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
                <img src="http://imy.up.ac.za/u20426586/img/';
        
        echo ($user["photo"] !== null) ? $user["photo"] : "profile.jpg";
        
        echo '">
            </div>
        </div>';

        // Add friend button
        echo '<form method="POST" action="friends.php">';
        echo '<input type="hidden" name="friendId" value="' . $user['Api'] . '">';
        echo '<input id="submit" type="submit" name="buttonValue" value="Add friend">';
        echo '</form>';

        // Go back button
        echo '<form method="POST" action="friends.php">';
        echo '<input id="submit" type="submit" name="buttonValue" value="Go Back">';
        echo '</form>';
    }
    else{
        echo '<h2>No User found :(</h2>';
    }
}

require_once("footer.php");

?>
