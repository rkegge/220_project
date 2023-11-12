<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    require_once("headerLoggedIn.php");
    // echo "DSXFGHJB";
    // var_dump($_SERVER["REQUEST_METHOD"]);

    include '../../config.php';
    $instance = new Database();

    echo '
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
	
    <link rel="stylesheet" type="text/css" href="../../css/article.css">
    <link rel="stylesheet" type="text/css" href="../../css/home-style.css">
    <link rel="stylesheet" type="text/css" href="../../css/form-style.css">
    <link rel="stylesheet" type="text/css" href="../../css/generalstyle.css">
    <script src="../../JS/article.js"></script>';

    if (isset($_GET["hashtags"])) {
        $searchInput = "";
        $user = "";
        $hashtags = urldecode($_GET["hashtags"]);
        echo '<h2>'.$hashtags.'</h2>';

        $results = $instance->searchArticle($searchInput, $hashtags, $user);
    
            if(empty($results)){
                echo '<h1 style="text-align:center;">Sorry, it seems like we were unable to find what you were searching for :( </h1>';
                echo "<h2>Don't worry though, you can always try <a href='../../home.php'>again :)</a> </h2>";
            }
            else{
                echo "<h2>Not what you were looking for? <a href='../../home.php'>Feel free to try again :)</a> </h2>";
    
            }
    
            // var_dump($results);
    
            // echo '<h1 style="text-align:center;">Your results!</h1>';
            
            echo '
            <section class="wrapper" style="text-align: center;">
            <div class="container" style="
                margin: 20px;
                width: 1500px;
                padding-left: 0px;
                ">
            <div class="row" style="width: 1800px; padding-left: 90px;">';
    
            if (is_array($results) && !empty($results)) {
                // Output data in cards
                foreach ($results as $row) {
            
                    $api = $row["Api"];
                    $img = $row["img"];
                    $articleName = $row["articleName"];
                    $date = $row["date"];
                    $author = $row["Author"];
            
                    $userData = $instance->getUserFromApi($api);
                    $photo = '';
    
    
                    $photo = $userData['photo'];
            
                    echo '
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <a onclick="loadArticle(\'' . $userData['email'] . '\', \'' . $userData['Api'] . '\', \'' . $photo . '\', \'' . $_SESSION["api_key"] . '\',\'' . $img . '\',\'' . $articleName . '\',\'' . $date . '\',\'' . $author . '\',\'' . $userData['name'] . '\',\'' . $row["bookTitle"] . '\',\'' . $row["description"] . '\',\'' . $row["genre"] . '\',\'' . $row["hashtags"] . '\')">
                        <!-- Rest of your card generation code here -->
                    
                        <div class="card text-dark card-has-bg click-col" style="background-image: url(\'http://imy.up.ac.za/u20426586/img/bk/' . $row["img"] . '\');">
                        <img class="card-img d-none" src="http://imy.up.ac.za/u20426586/img/bk/'. $row["img"] . ' style="width:400px;"">
                                <div class="card-img-overlay d-flex flex-column">
                                <div class="card-body">
                                    <small class="card-meta mb-2">' . $row["bookTitle"] . '</small>
                                    <h4 class="card-title mt-0 " style="color: #c98928; font-size:1.2em;">' . $row["articleName"] . '</h4>
                                    <small><i class="far fa-clock"></i>' . $row["genre"] . '</small>
                                    </div>
                                    <div class="card-footer">
                                <div class="media">
                                <img class="mr-3 rounded-circle" src="http://imy.up.ac.za/u20426586/img/'. $photo . '" alt="Generic">
                                <div class="media-body">
                                    <h2 class="my-0 text-dark d-block" style="font-size:1.4em; font-weight:bold;">'. $userData['name'] . '</h2>
                                    <small>' . $row["date"] . '</small>
                                </div></div></div></div></div>
                
                                </a>
                                                            
                        </div>';
                
                
            }
            
            
    
            echo '</div>';
            echo '</div>';
            echo '</section>';
            }
    }
    else{
        if ($_SERVER["REQUEST_METHOD"] == "GET" || $_SERVER["REQUEST_METHOD"] == "POST") {

            $searchInput = $_POST["name"];
            $hashtags = $_POST["hashtags"];
            $user = $_POST["user"];
    
            // echo($searchInput);
            // echo($hashtags);
    
            echo '<div class="aroundAll"></div>';
    
            
            if($searchInput != "" && $hashtags != "" && $user != ""){
                echo '<h2>Searching for "'.$user.'", "'.$searchInput.'", and "'.$hashtags.'"</h2>';
            }
            else{
                echo '<h2>Searching for ';
    
                if($user != ""){
                    echo '"'.$user.' "';
                }
                if($searchInput != ""){
                    echo '"'.$searchInput.' "';
                }
                if($hashtags != ""){
                    echo '"'.$hashtags.' "';
                }
    
                echo '</h2>';
            }
    
    
            // if only searching for a user
            if($user != "" && $searchInput == "" && $hashtags == ""){
                $results = $instance->searchArticle($searchInput, $hashtags, $user);
                // var_dump($results);
    
                if (!empty($results) && isset($results[0]['Api'])) {
                    $user = $results[0]['Api'];
                    header("Location: userView.php?user=" . urlencode($user));
                    exit();
                }
                else{
                    echo '<h2>Unfortunately we could not find who you were looking for :(</h2>';
                    
                }
                // header("Location: userView.php?user=" . urlencode($user));
                // exit();
            }
            else{
                $results = $instance->searchArticle($searchInput, $hashtags, $user);
    
            if(empty($results)){
                echo '<h1 style="text-align:center;">Sorry, it seems like we were unable to find what you were searching for :( </h1>';
                echo "<h2>Don't worry though, you can always try <a href='../../home.php'>again :)</a> </h2>";
            }
            else{
                echo "<h2>Not what you were looking for? <a href='../../home.php'>Feel free to try again :)</a> </h2>";
    
            }
    
            // var_dump($results);
    
            // echo '<h1 style="text-align:center;">Your results!</h1>';
            
            echo '
            <section class="wrapper" style="text-align: center;">
            <div class="container" style="
                margin: 20px;
                width: 1500px;
                padding-left: 0px;
                ">
            <div class="row" style="width: 1800px; padding-left: 90px;">';
    
            if (is_array($results) && !empty($results)) {
                // Output data in cards
                foreach ($results as $row) {
            
                    $api = $row["Api"];
                    $img = $row["img"];
                    $articleName = $row["articleName"];
                    $date = $row["date"];
                    $author = $row["Author"];
            
                    $userData = $instance->getUserFromApi($api);
                    $photo = '';
    
    
                    $photo = $userData['photo'];
            
                    echo '
                        <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <a onclick="loadArticle(\'' . $userData['email'] . '\', \'' . $userData['Api'] . '\', \'' . $photo . '\', \'' . $_SESSION["api_key"] . '\',\'' . $img . '\',\'' . $articleName . '\',\'' . $date . '\',\'' . $author . '\',\'' . $userData['name'] . '\',\'' . $row["bookTitle"] . '\',\'' . $row["description"] . '\',\'' . $row["genre"] . '\',\'' . $row["hashtags"] . '\')">
                        <!-- Rest of your card generation code here -->
                    
                        <div class="card text-dark card-has-bg click-col" style="background-image: url(\'http://imy.up.ac.za/u20426586/img/bk/' . $row["img"] . '\');">
                        <img class="card-img d-none" src="http://imy.up.ac.za/u20426586/img/bk/'. $row["img"] . ' style="width:400px;"">
                                <div class="card-img-overlay d-flex flex-column">
                                <div class="card-body">
                                    <small class="card-meta mb-2">' . $row["bookTitle"] . '</small>
                                    <h4 class="card-title mt-0 " style="color: #c98928; font-size:1.2em;">' . $row["articleName"] . '</h4>
                                    <small><i class="far fa-clock"></i>' . $row["genre"] . '</small>
                                    </div>
                                    <div class="card-footer">
                                <div class="media">
                                <img class="mr-3 rounded-circle" src="http://imy.up.ac.za/u20426586/img/'. $photo . '" alt="Generic">
                                <div class="media-body">
                                    <h2 class="my-0 text-dark d-block" style="font-size:1.4em; font-weight:bold;">'. $userData['name'] . '</h2>
                                    <small>' . $row["date"] . '</small>
                                </div></div></div></div></div>
                
                                </a>
                                                            
                        </div>';
                
                }
            }
            
            
    
            echo '</div>';
            echo '</div>';
            echo '</section>';
            }
    
            
    
        }
        else{
             echo "NOT POST";
        }
    }

    

    require_once("footer.php");

?>