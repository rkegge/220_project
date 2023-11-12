<?php

require_once("headerLoggedIn.php");
$stylesheet = "http://imy.up.ac.za/u20426586/css/profile-style.css";

if (isset($_GET['user'])) {
    $userName = $_GET['user'];

    // echo "User's name: " . $userName;
} else {
    // echo "User's name is not provided in the query parameter.";
}

error_reporting(E_ALL);
ini_set('display_errors', 1);


include '../../config.php';
$instance = new Database();

$userDeets = $instance->getUserFromApi($userName);

if($userDeets == ""){
    echo '<h2>Unfortunately we could not find who you were looking for :(</h2>';
}

$boolFriend = $instance->isFriend($userDeets["Api"]);

if($boolFriend == true){
    echo '<h2>'.$userDeets["name"].' is your friend</h2>';
}
else{
    echo '<h2>'.$userDeets["name"].' is not your friend</h2>';

    // Add friend button
    echo '<form method="POST" action="friends.php" style="padding-left:880px;">';
    echo '<input type="hidden" name="friendId" value="' . $userDeets['Api'] . '">';
    echo '<input id="submit" type="submit" name="buttonValue" value="Add friend">';
    echo '</form>';

}



require_once("footer.php");



?>



<main class="overflow-hidden">

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

    <!-- css link -->
    <link rel="stylesheet" type="text/css" href="http://imy.up.ac.za/u20426586/css/form-style.css">
    <link rel="stylesheet" type="text/css" href="http://imy.up.ac.za/u20426586/css/profile-style.css">


    <!-- DISPLAY PERSONAL INFO -->


    <div class="profile-container">
        <div class="profile-image">
            <img src="http://imy.up.ac.za/u20426586/img/<?php echo ($userDeets["photo"] !== null) ? $userDeets["photo"] : "profile.jpg"; ?>">
            
        </div>

    </div>


    <?php


        if ($boolFriend == false) {
            echo "
            <div id='personalInfo'>
                <h2 id='welcome'>" . $userDeets['name'] . "'s Profile</h2>
                <div>
                    Username: " . (($userDeets["name"] !== null) ? $userDeets["name"] : "not set yet") . "
                </div>
            </div>
            ";
        }
        else{
            echo "
            <div id='personalInfo'>
                <h2 id='welcome'>" . $userDeets['name'] . "'s Profile</h2>
                <div>
                    Username: " . (($userDeets["name"] !== null) ? $userDeets["name"] : "not set yet") . "
                </div>
                <div>
                    Birthday: " . (($userDeets["Birthday"] !== null) ? $userDeets["Birthday"] : "not set yet") . "
                </div>
                <div>
                    Occupation: " . (($userDeets["Occupation"] !== "") ? $userDeets["Occupation"] : "not set yet") . "
                </div>
                <div>
                    Cell number: " . (($userDeets["cell"] !== null && $userDeets["cell"] != 0) ? "0" . $userDeets["cell"] : "not set yet") . "
                </div>
                <div>
                    Email: " . (($userDeets["email"] !== null) ? $userDeets["email"] : "not set yet") . "
                </div>
                <div>
                    Relationship Status: " . (($userDeets["relationship"] !== "") ? $userDeets["relationship"] : "not set yet") . "
                </div>
            </div>
            ";


            // view their friends

            echo "<div id='friendList'>
            <h2>" . $userDeets['name'] . "'s friends</h2>";
            
            $servername = "localhost";
            $username = "u20426586";
            $password = "xvirfcyu";
            $db = "u20426586";
            
            $conn = new mysqli($servername, $username, $password, $db);
            
            // Step 2: Retrieve data from the database
            $sql = "SELECT * FROM `friends` WHERE `Api`='" . $userDeets['Api'] . "'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
            
                while ($row = $result->fetch_assoc()) {
            
                    // get user
                    $sqls = "SELECT * FROM `users` WHERE `Api` = '" . $row['friendApi'] . "'";
                    $res = $conn->query($sqls);
            
                    if ($res) {
                        $userData = $res->fetch_assoc(); // Fetch the user data
            
                        if ($userData) {
                            echo '<h3>' . $userData['name'] . '</h3>';
                            echo '<style>
                                    .profile-container {
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;
                                    }
                                    .profile-image {
                                        width: 150px;
                                        height: 150px;
                                        border-radius: 50%;
                                        overflow: hidden;
                                    }
                                    .profile-image img {
                                        width: 100%;
                                        height: auto;
                                    }
                                </style>';
                            echo '<div class="profile-container">
                                    <div class="profile-image">
                                        <img src="http://imy.up.ac.za/u20426586/img/' . ($userData["photo"] !== null ? $userData["photo"] : "profile.jpg") . '">
                                    </div>
                                </div>';
                        } else {
                            echo '<h3>No user found</h3>';
                        }
                    }
                }
            
            } else {
                echo "This user has no Friends yet.";
            }
            
            $conn->close();

        };


    
