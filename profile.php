<?php
$page = 'profile';
$stylesheet = "http://imy.up.ac.za/u20426586/css/profile-style.css";
require_once("./php/general/headerLoggedIn.php");

// Suppress PHP warnings
error_reporting(E_ERROR | E_PARSE);
ini_set("display_errors", 0);


?>



<?php
	session_start();
	// var_dump($_SESSION); // Debugging: Output session data

	if(isset($_SESSION["user_name"])) {
	    $userName = $_SESSION["user_name"];
        
	    // echo('user_name' . $userName);
	}
    if(isset($_SESSION["email"])) {

        $email = $_SESSION["email"];

        include 'config.php';
        $instance = new Database();
        
	    $userDeets = $instance->retrieveUser($email);

        // var_dump($userDeets);
	}

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
    <link rel="stylesheet" type="text/css" href="./css/form-style.css">
    <link rel="stylesheet" type="text/css" href="./css/profile-style.css">


    <!-- DISPLAY PERSONAL INFO -->


    <div class="profile-container">
        <div class="profile-image">
            <img src="http://imy.up.ac.za/u20426586/img/<?php echo ($userDeets["photo"] !== null) ? $userDeets["photo"] : "profile.jpg"; ?>">
            
        </div>

    </div>



    <div id="personalInfo">
    
        <h2 id="welcome"><?php echo $_SESSION["user_name"]; ?>'s Profile</h2>

        <div>
            Username: <?php echo ($userDeets["name"] !== null) ? $userDeets["name"] : "not set yet"; ?>
        </div>

        <div>
            Birthday: <?php echo ($userDeets["Birthday"] !== null) ? $userDeets["Birthday"] : "not set yet"; ?>
        </div>

        <div>
            Occupation: <?php echo ($userDeets["Occupation"] !== "") ? $userDeets["Occupation"] : "not set yet"; ?>
        </div>

        <div>
            Cell number: <?php echo ($userDeets["cell"] !== null && $userDeets["cell"] != 0) ? "0" . $userDeets["cell"] : "not set yet"; ?>
        </div>

        <div>
            Email: <?php echo ($userDeets["email"] !== null) ? $userDeets["email"] : "not set yet"; ?>
        </div>

        <div>
            Relationship Status: <?php echo ($userDeets["relationship"] !== "") ? $userDeets["relationship"] : "not set yet"; ?>
        </div>

        

        <button id="editButton" onclick="toggleForm()">Edit your personal information</button>


         <!-- EDIT PERSONAL INFO -->

        <div id="editPersonalInfo">
            <form id="editForm" class="edit-form" action="php/general/editProfile.php" method="post">

                <h3>Make some changes to your personal information</h3>

                <small>Please enter your name as it is:</small><br/>
                <label for="Username">Name </label> <br/> <input class="style" type="text" name="newUsername" placeholder="<?php echo $_SESSION["user_name"]; ?>"><br/>

                <label for="Birthday">Birthday </label> <br/> <input class="style" type="date" name="newBirthday"><br/>


                <label for="Occupation">Occupation </label> <br/> <input class="style" type="text" name="newOccupation"><br/>

                <label for="Cell">Cell number </label> <br/> <input class="style" type="text" name="newCell"><br/>

                <!-- <label for="Email">Email </label> <br/> <input class="style" type="text" name="newEmail"><br/> -->

                <label for="Relationship">Relationship Status </label> <br/> <input class="style" type="text" name="newRelationship"><br/>

                <div class="profilePic">
                    <label for="filename">Profile picture</label>
                    <input type="file" id="filename" name="filename">
                </div>


                <button type="button" onclick="saveDetails()">Save</button>
                <button type="button" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>


    </div>

   

    <!-- DISPLAYING AND EDITING FRIENDS LIST -->

    
    <div id="friendList">

        <h2>Your friends</h2>

        <?php

            $servername = "localhost";
            $username = "u20426586";
            $password = "xvirfcyu";
            $db = "u20426586";

            $conn = new mysqli($servername, $username, $password, $db);

            // Step 2: Retrieve data from the database
            $sql = "SELECT * FROM `friends` WHERE `Api`='" . $userDeets['Api'] . "'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {

                while($row = $result->fetch_assoc()) {

                    // echo($row['Api']);
                    // get user
                    $sqls = "SELECT * FROM `users` WHERE `Api` = '" . $row['friendApi'] . "'";
                    $res = $conn->query($sqls);
                    if ($res) {
                        $userData = $res->fetch_assoc(); // Fetch the user data
                        if ($userData) {
                            echo '<h3>' . $userData['name'] . '</h3>';

                            echo '
                            <style>
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
                            </style>

                            <!-- DISPLAY PERSONAL INFO -->

                            

                            <div class="profile-container">
                                <div class="profile-image">
                                    <img src="http://imy.up.ac.za/u20426586/img/';
                            
                            echo ($userData["photo"] !== null) ? $userData["photo"] : "profile.jpg";
                            
                            echo '">
                                </div>
                                
                            </div>
                            <form method="post" action="http://imy.up.ac.za/u20426586/php/general/friends.php">
                                <input type="hidden" name="removeFriend" value="' . $userData['Api'] . '">
                                <input type="submit" name="buttonValue" value="Remove Friend">
                            </form>';

                        } else {
                            echo '<h3>No user found</h3>';
                        }
                    }

                }

            } else {
                echo "You have no Friends yet.";
            }

            $conn->close();

        ?>




        <form method="post" action="http://imy.up.ac.za/u20426586/php/general/friends.php">
            <input type="submit" name="buttonValue" value="Add">
        </form>

        <br/>

    </div>

    <br/>


    <!-- DISPLAYING AND EDITING LISTS -->
    
    <div id="Lists">

        <h2>Your Lists</h2>

        <?php

            $servername = "localhost";
            $username = "u20426586";
            $password = "xvirfcyu";
            $db = "u20426586";

            $conn = new mysqli($servername, $username, $password, $db);

            $sql = "SELECT * FROM `lists` WHERE `Api`='" . $userDeets['Api'] . "'";

            $result = $conn->query($sql);

            

            if ($result->num_rows > 0) {
                echo '<div id="listsWrap">';

                while($row = $result->fetch_assoc()) {
                    // var_dump($row);
                    echo '<div id="lists">';
                    echo '<h3>'.$row["ListName"].'</h3>';
                    echo '<p>'.$row["desc"].'</p>';
                    

                    echo '<form method="post" action="php/general/friends.php">
                                <input type="hidden" name="removeList" value="' . $row['ListName'] . '">
                                <input type="submit" name="buttonValue" value="Remove List">
                            </form>';

                    // CHNAGED

                    echo '<form method="post" action="php/general/friends.php">
                            <input type="hidden" name="whichList" value="' . $row["ListName"] . '">
                            <input id="editList" type="submit" name="buttonValue" value="Edit List">
                        </form>';

                    echo '</div>';
                }

                echo '</div>';

            } else {
                echo "You have no Lists yet. See below to get started on making some :)";
            }

            $conn->close();

        ?>

        <br/>

    </div>


    <!-- LIST CREATION -->

    <div id="listCreation">

        <h2>Create a new list</h2>

        <form id="listCreationForm" action="./php/createArticle/createList.php" method="POST">
            
            <label for="listName">List Name </label> <br/> <input class="style" type="text" name="listName"><br/>
        
            <label for="ListDesc">List Description </label> <br/> <input class="style" id="ListDescInput" type="text" name="listDescription"><br/>
        
            <input type="submit" name="buttonValue" value="Add">
            
        </form>

        <br/>

    </div>

    <form method="post" action="php/general/friends.php">
        <input id="delete" type="submit" name="buttonValue" value="Delete your account :(" style="width:400px; background-color:#a84c45;">
    </form>
    <style>
        input#delete:hover {
            background-color: #8a3d37;
        }
    </style>




    <script>
        // initially hides the edit form 
        document.addEventListener("DOMContentLoaded", function() {
            var editForm = document.getElementById('editForm');
            var editButton = document.getElementById('editButton');
            var userDetails = document.querySelectorAll('span');

            editForm.style.display = 'none';
            editButton.style.display = 'inline';

            userDetails.forEach(function (element) {
                element.style.display = 'inline';
            });
        });

    </script>

    <!-- link the js file -->
    <script src="JS/profile.js"></script>

</main>

<?php
require 'php/general/footer.php';
?>