<?php
$page = 'home';
?>

<?php require_once("php/general/headerLoggedIn.php"); ?>

<?php
	session_start();

    // Access session variables
    if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] === true) {
        $name = $_SESSION["user_name"];
        $api = $_SESSION["api_key"];
        $email = $_SESSION["email"];
        
    } else {
        // Redirect or handle the case when the user is not logged in
        header('Location: login.php'); // Redirect to login page, for example
    }

?>


<main id="home">

<!-- http://imy.up.ac.za/u20426586/home.php -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	

			
<h1 id="welcome">Welcome back, <?php echo $name; ?></h1>
			


<link rel="stylesheet" type="text/css" href="http://imy.up.ac.za/u20426586/css/article.css">
<link rel="stylesheet" type="text/css" href="css/home-style.css">
<link rel="stylesheet" type="text/css" href="css/form-style.css">
<link rel="stylesheet" type="text/css" href="css/generalstyle.css">

<script src="JS/article.js"></script>



<!-- search feature -->

<div id="searchArticles">

<h2>Search for an article, user, or hashtag</h2>

<form id="searchArticles" action="php/general/search.php" method="post">

    <!-- user -->
    <label for="user">User </label> 

	<input class="style" type="text" id="user" name="user" style="width:250px;">
    
    <!-- article name -->
    <label for="name"> | Article </label> 

	<input class="style" type="text" id="name" name="name" style="width:250px;">

    <!-- hashtags -->
    <label for="hashtags"> | Hashtag/s </label>  <input class="style" id="hashtags" type="text" name="hashtags">

    <input id="submit" type="submit" value="Search">

</form>

<br/>

</div>

<!-- view local or global -->
<div id="localOrGlobal">
<h2>What would you like to see?</h2>
    <form method="post" action="home.php">
        <input type="submit" name="buttonValue" value="My Articles"> <!-- user can edit from here -->
        <input type="submit" name="buttonValue" value="My Feed">
        <input type="submit" name="buttonValue" value="Explore">
    </form>
</div>

<div class="aroundAll">


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["buttonValue"])) {
        $buttonValue = $_POST["buttonValue"];

        $servername = "localhost";
            $username = "u20426586";
            $password = "xvirfcyu";
            $db = "u20426586";

        $conn = new mysqli($servername, $username, $password, $db);
        
        if ($buttonValue === "My Articles") {
            echo '<h2>Your Articles!</h2>';
        
            // Get the user's API by fetching it from the result of the first query
            $sqls = "SELECT * FROM users WHERE `name`='" . $_SESSION["user_name"] . "'";
            $resultApi = $conn->query($sqls);
        
            if ($resultApi->num_rows > 0) {
                // Assuming there's only one result, you can fetch it
                $userApiRow = $resultApi->fetch_assoc();
                $userApi = $userApiRow["Api"];

                $userEmail = $userApiRow["email"];
                $userName = $userApiRow["name"];
        
                // Get specific articles using the user's API
                $sql = "SELECT * FROM articles WHERE `api`='$userApi' ORDER BY `date` DESC";
        
                $result = $conn->query($sql);
        
                if ($result->num_rows > 0) {


                    echo '
                    <section class="wrapper" style="text-align: center;">
                    <div class="container" style="
                    margin: 20px;
                    width:1500px;
                    padding-left:70px;
                    ">
                    <div class="row" style="width: 1800px; padding-left:30px;">';
                    while($row = $result->fetch_assoc()) {
                        // Step 2: Retrieve data from the database
                        $sql = "SELECT * FROM articles WHERE `Api` = '$userApi' ORDER BY `date` DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Output data in cards
                            while($row = $result->fetch_assoc()) {
                                // echo "<h2>calling generateArticleCard</h2>";
                                generateArticleCard($row);
                            }
                        }
                    }

                    echo'</div>';
                    echo'</div>';
                    echo'</section>';

                } else {
                    echo '<p style="text-align:center">You have not published any articles yet.</p>';
                }
                echo '</div>';
            } else {
                echo "User not found.";
            }
        
            // $conn->close();
        }
        
        if ($buttonValue === "My Feed") {

            echo '<h2>Your Feed!</h2>';

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // find only articles posted by friends
            // Step 2: Retrieve data from the database
            $sql = "SELECT * FROM friends WHERE `Api` = '" .$api. "'";
            $resultFriend = $conn->query($sql);

            if ($resultFriend->num_rows > 0) {
                // Output data in cards
                echo '
                <section class="wrapper" style="text-align: center;">
                <div class="container" style="
                    margin: 20px;
                    width:1500px;
                    padding-left:70px;
                    ">
                <div class="row" style="width: 1800px; padding-left:30px;">';
                while($row = $resultFriend->fetch_assoc()) {
                    // Step 2: Retrieve data from the database
                    $sql = "SELECT * FROM articles WHERE `Api` = '".$row["friendApi"]."' ORDER BY `date` DESC";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Output data in cards
                        while($row = $result->fetch_assoc()) {
                            // echo "<h2>calling generateArticleCard</h2>";
                            generateArticleCard($row);
                        }
                    }
                }

                echo'</div>';
                echo'</div>';
                echo'</section>';
                
            }else {
                echo '<p style="text-align:center">You have not made any friends yet, make some friends to see your
                most recent activity.</p>';
            }

            // Step 3: Close the database connection
            // $conn->close();

        } elseif ($buttonValue === "Explore") {

            echo '<h2>Explore!</h2>';

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Step 2: Retrieve data from the database
            $sql = "SELECT * FROM articles ORDER BY `date` DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<section class="wrapper" style="text-align: center;">';
                echo '<div class="container" style="
                margin: 20px;
                width:1500px;
                padding-left:70px;
                ">';
                echo '<div class="row" style="width: 1800px; padding-left:30px;">';
                
                while($row = $result->fetch_assoc()) {
                    // echo "Entering the loop for row: " . print_r($row, true); // Debug statement
                    
                    // Call the generateArticleCard function
                    generateArticleCard($row);
                    
                    // echo "Exiting the loop for row: " . print_r($row, true); // Debug statement
                }
                
                echo '</div>';
                echo '</div>';
                echo '</section>';
            } else {
                echo "No articles found.";
            }

            // Step 3: Close the database connection
            // $conn->close();

        }
    }
}








// Function to generate article card HTML
function generateArticleCard($row) {

    // Get user name from user's API
    $sqls = "SELECT * FROM `users` WHERE `Api` = '" . $row['Api'] . "'";
    $res = $GLOBALS['conn']->query($sqls);
    $photo;

    if ($res->num_rows > 0) {
        $userData = $res->fetch_assoc();
        
        if (isset($userData['photo'])) {
            $photo = $userData['photo'];
        }
    }
    // echo' 
    //    echo' <section class="wrapper">';
    //         <div class="container">';
    // echo'<div class="container">';

            echo '
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4" style="width: 540px;">


                <a onclick="loadArticle(\'' . $userData['email'] . '\', \'' . $userData['Api'] . '\', \'' . $photo . '\', \'' . $_SESSION["api_key"] . '\',\'' . $row["img"] . '\',\'' . $row["articleName"] . '\',\'' . $row["date"] . '\',\'' . $row["Author"] . '\',\'' . $userData['name'] . '\',\'' . $row["bookTitle"] . '\',\'' . $row["description"] . '\',\'' . $row["genre"] . '\',\'' . $row["hashtags"] . '\')">

                <div class="card text-dark card-has-bg click-col" style="background-image: url(\'./img/bk/' . $row["img"] . '\');">
                    <img class="card-img d-none" src="./img/bk/'. $row["img"] . '">
                    <div class="card-img-overlay d-flex flex-column">
                    <div class="card-body">
                        <small class="card-meta mb-2">' . $row["bookTitle"] . '</small>
                        <h4 class="card-title mt-0 " style="color: #c98928; font-size:1.2em;">' . $row["articleName"] . '</h4>
                        <small><i class="far fa-clock"></i>' . $row["genre"] . '</small>
                        </div>
                        <div class="card-footer">
                    <div class="media">
                    <img class="mr-3 rounded-circle" src="./img/'. $photo . '" alt="Generic">
                    <div class="media-body">
                        <h2 class="my-0 text-dark d-block" style="font-size:1.4em; font-weight:bold;">'. $userData['name'] . '</h2>
                        <small>' . $row["date"] . '</small>
                    </div></div></div></div></div>

                    </a>
                    
                </div>';
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

?>

</div>


<?php require_once("php/general/footer.php"); ?>


</main>