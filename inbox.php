<?php
$page = 'inbox';
require_once("./php/general/headerLoggedIn.php");

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

<main class="overflow-hidden">
<link rel="stylesheet" type="text/css" href="css/chat.css">
<script src="JS/inbox.js"></script>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/generalstyle.css">
<!-- for the icons -->
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<body>
<h2>Your inbox</h2>
<div class="container">
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card chat-app">
            <div id="plist" class="people-list">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search...">
                </div>
                <ul class="list-unstyled chat-list mt-2 mb-0">
                    
                    <?php
                        $servername = "localhost";
                        $username = "u20426586";
                        $password = "xvirfcyu";
                        $db = "u20426586";

                        $conn = new mysqli($servername, $username, $password, $db);

                        // Step 2: Retrieve data from the database
                        $sql = "SELECT * FROM `friends` WHERE `Api`='" .  $_SESSION["api_key"] . "'";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $sqls = "SELECT * FROM `users` WHERE `Api` = '" . $row['friendApi'] . "'";
                                $res = $conn->query($sqls);
                                if ($res) {
                                    $userData = $res->fetch_assoc(); // Fetch the user data
                                    if ($userData) {

                                        $photoDirectory = 'http://imy.up.ac.za/u20426586/img/';
                                        $photoUrl = $photoDirectory . $userData['photo'];
                                        
                                        echo '<li class="clearfix" onclick="loadChat(\'' . $userData['name'] . '\', \'' .  $userData['email'] . '\', \'' . $photoUrl . '\', \'' . $row['friendApi'] . '\', \'' . $_SESSION["api_key"] . '\')">

                                        <img src="http://imy.up.ac.za/u20426586/img/';
                                        
                                        echo ($userData["photo"] !== null) ? $userData["photo"] : "profile.jpg";
                                        echo '">';

                                        echo '<div class="about">
                                                <div class="name">' . $userData['name'] . '</div>
                                                <div class="status"> <i class="fa fa-circle offline"></i> left 7 mins ago </div>                                            
                                            </div>
                                        </li>';

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
                </ul>
            </div>
            <div class="chat">
                <div class="chat-header clearfix">
                    <div class="row">
                        <div class="col-lg-6">
                            <img class="chatOpenWith" src="img/profile.jpg" alt="avatar">
                            <div class="chat-about">
                                <h6 class="m-b-0">Open up a chat</h6>
                                <small>Last seen: 2 hours ago</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="chat-history-container" style="display: none;">
                <div class="chat-history">
                    <!-- <ul class="m-b-0">

                                <?php
                                    include 'config.php';
                                    $instance = new Database();
                                    
                                    //get users pfp
                                    $result = $instance->getUserPic($_SESSION["api_key"]);

                                    if (is_array($result) && isset($result['photo'])) {
                                        echo '<img src="http://imy.up.ac.za/u20426586/img/' . $result['photo'] . '" alt="avatar">';
                                    } else {
                                        echo '<img src="default-profile.jpg" alt="avatar">';
                                    }

                                    // get the messages
                                    $messages = $instance->getMessages($_SESSION["api_key"]);

                                    if (isset($_COOKIE['talkingTo'])) {
                                        $talkingToEmail = $_COOKIE['talkingTo'];
                                        echo '<h2>Talking to: '.$talkingToEmail.' </h2>';
                                    } else {
                                        echo '<h2>none </h2>';
                                    }

                                    $talkingToApi = $instance->getApiEmail($talkingToEmail);
                                    // echo '<h2>Talking to Api: '.$talkingToApi['Api'].' </h2>';

                                    if (!empty($messages)) {
                                        foreach ($messages as $message) {
                                            // $talkingTo = $userData['name'];
                                            // echo '<h2>in here </h2>';
                                            // echo '<h5>'.$message['toApi'].' === '.$talkingToApi['Api'].'</h5>';
                                            if($talkingToApi['Api'] === $message['toApi'] || $talkingToApi['Api'] === $message['fromApi']){
                                                // echo '<h2>in here </h2>';
                                                if ($message['toApi'] === $_SESSION["api_key"]) {
                                                    // This message was sent

                                                    echo '<li class="clearfix">
                                                        <div class="message-data">
                                                            <span class="message-data-time">'. $message['time'] .'</span>
                                                        </div>
                                                        <div class="message my-message">'. $message['message'] .'</div>                                    
                                                    </li>';
                                                } else {
                                                        // This message was received

                                                        echo '<li class="clearfix">
                                                                <div class="message-data text-right">
                                                                    <span class="message-data-time">'. $message['time'] .'</span>
                                                                </div>
                                                                <div class="message other-message float-right">'. $message['message'] .'</div>
                                                            </li>';
                                                }
                                            }
                                            
                                        }
                                    } else {
                                        echo 'No messages available.';
                                    }
                                    
                                ?>

                    </ul> -->
                </div>
                </div>
                <div class="chat-message clearfix">
                    <div class="input-group mb-0">

                        <input type="text" id="messageInput" class="form-control" placeholder="Enter text here...">

                        <div class="input-group-prepend">
                            <span class="input-group-text" onclick="messages()">
                                <i class="fa fa-send"></i>
                            </span>
                        </div>
                        
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</main>

<?php

require_once("./php/general/footer.php");
?>