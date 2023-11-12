<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


    if(!isset($_SESSION)){
        session_start();
        if(!isset($_SESSION["api_key"])){
            $_SESSION["api_key"] = "10154fdb85b7f768f591d675ce9cd0b2b2d051a6d70c2d65";
        }
        if(!isset($_SESSION["logged_in"])){
            $_SESSION["logged_in"] = false;
        }
        if(!isset($_SESSION["user_name"])){
            $_SESSION["user_name"] = "";
        }
        if(!isset($_SESSION["email"])){
            $_SESSION["email"] = "";
        }
    }

    class Database{
        private $connection;

        private $servername = "localhost";
        private $username = "u20426586";
        private $password = "xvirfcyu";
        private $db = "u20426586";


        private static $instance = null;

        public function __construct() {
            
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->db);
            if($this->connection->connect_error) {
                die("Connection failed: " . $this->connection->connect_error);
            }
        }

        public static function getInstance(){
            if(!self::$instance){
                self::$instance = new Database();
            }

            return self::$instance;
        }

        

        public function sendMessage($toApi, $fromApi, $time, $messageContent) {
            echo("IN CONFIG send MESSGAE");
            $sql = "INSERT INTO `messaged`(`toApi`, `fromApi`, `message`, `time`) VALUES ('".$toApi."','".$fromApi."','".$messageContent."','".$time."')";
            
            
            echo("SQL " . $sql);
    
            $result = mysqli_query($this->connection, $sql);

            header('Location: inbox.php');

        }

        public function editProfile($newUsername, $newBirthday, $newOcc, $newCell, $newRelation, $uploadedImage){
            echo("IN CONFIG edit profile");


            $sql = "UPDATE `users` SET `Birthday`='$newBirthday',
            `Occupation`='$newOcc',`cell`='$newCell',`relationship`='$newRelation',`photo`='$uploadedImage' WHERE `name` = '$newUsername'";
        
            if($uploadedImage == ""){
                $uploadedImage = "profile.jpg";
            }

            echo("SQL " . $sql);
    
             // Execute the query
            $result = mysqli_query($this->connection, $sql);

            $_SESSION["logged_in"] = true;


            header('Location: ../../profile.php');
        }

        public function addsignupUser($name, $surname, $email, $password, $salt){
            //echo "adding the user";

            //first check if email already exists
            $sql = "SELECT * FROM `users` WHERE `email` = '$email'";

            // Execute the query
            $result = mysqli_query($this->connection, $sql);

            if ($result === false) {
                echo "Query execution failed: " . mysqli_error($this->connection);
            } else {
                // Check if the query returned any rows
                if (mysqli_num_rows($result) > 0) {
                    echo "Error: Email already exists in the database";
                } else {
                    //echo "Email does not exist in the database";
                    //generate api
                    $api_key = bin2hex(random_bytes(24));

                    $_SESSION["logged_in"] = true;
                    $_SESSION["user_name"] = $name;
                    $_SESSION["api_key"] = $api_key;
                    $_SESSION["email"] = $email;


                    $sql = "INSERT INTO `users`(`Api`, `name`, `surname`, `email`, `password`, `salt`) VALUES ('".$api_key."', '".$name."', '".$surname."', '".$email."', '".$password."', '".$salt."')";
                    if (mysqli_query($this->connection, $sql)) {
                        //echo "New user record created successfully";

                        header('Location: ../../home.php');

                    } else {
                        echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
                    }
                }
            }

        }

        public function retrieveUser($email){ 
            $query = "SELECT * FROM  `users` WHERE `email` = '$email'";
            $result = $this->connection->query($query);
    
            if($result){
                if($result->num_rows == 0) {
                    return "";
                }
                else{
                    $_SESSION["logged_in"] = true;
                    return $result->fetch_assoc();
                }
            }
            else{
                return "";
            }
        }

        
        public function getUserPic($api){ 
            $query = "SELECT photo FROM  `users` WHERE `Api` = '$api'";
            $result = $this->connection->query($query);
    
            if($result){
                if($result->num_rows == 0) {
                    return "";
                }
                else{
                    $_SESSION["logged_in"] = true;
                    return $result->fetch_assoc();
                }
            }
            else{
                return "";
            }
        }

        public function getMessages($api){
            $query = "SELECT * FROM  `messaged` WHERE `toApi` = '$api' OR `fromApi` = '$api'";
            $result = $this->connection->query($query);

            // echo ($query);
    
            if ($result) {
                $messages = array();
        
                while ($row = $result->fetch_assoc()) {
                    $messages[] = $row;
                }
        
                return $messages;
            } else {
                return array();
            }
        }

        public function getComments($articleName){
            $query = "SELECT * FROM `reviews` WHERE `articleName` = '$articleName'";
            $result = $this->connection->query($query);

            // echo ($query);
    
            if ($result) {
                $data = array();
        
                while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
                }
        
                return $data;
            } else {
                return array();
            }
        }

        public function retrieveUserName($name){ 
            $query = "SELECT * FROM  `users` WHERE `name` = '$name'";
            $result = $this->connection->query($query);
    
            if($result){
                if($result->num_rows == 0) {
                    return "";
                }
                else{
                    return $result->fetch_assoc();
                }
            }
            else{
                return "";
            }
        }

        // CHANGED
        public function retrieveArticle($search){ 
            $query = "SELECT * FROM  `articles` WHERE `articleName` = '$search' ORDER BY `date` DESC";
            $result = $this->connection->query($query);
    
            if($result){
                if($result->num_rows == 0) {
                    return "";
                }
                else{
                    return $result->fetch_assoc();
                }
            }
            else{
                return "";
            }
        }

        // CHANGED

        public function addToList($whichList, $articleName){
            $query = "INSERT INTO `articlelist`(`listName`, `ArticleName`) VALUES ('".$whichList."','".$articleName."')";
            $result = $this->connection->query($query);
        
            if (!$result) {
                // Log the error or throw an exception
                die("Query error: " . $this->connection->error);
            }
        
            // Return the result (if needed)
            return $result;
        }

        // CHANGED

        public function removeFromList($whichList, $articleName){
            $query = "DELETE FROM `articlelist` WHERE `listName` = '$whichList' AND `ArticleName` = '$articleName'";
            $result = $this->connection->query($query);

        
            if (!$result) {
                // Log the error or throw an exception
                die("Query error: " . $this->connection->error);
            }
        
            // Return the result (if needed)
            return $result;
        }
        

        public function getUserSalt($id){
            $return = "";
            $query = "SELECT * FROM  `users` WHERE `email` = '$id'";
            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc()["salt"];
            }
            return $return;
        }

        public function getUserPass($id){
            $return = "";
            $query = "SELECT * FROM  `users` WHERE `email` = '$id'";
            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc()["password"];
            }
            return $return;
        }

        public function getName($id){
            $return = "";
            $query = "SELECT * FROM  `users` WHERE `email` = '$id'";
            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc()["name"];
            }
            return $return;
        }

        public function getApi($id){
            $return = "";
            $query = "SELECT * FROM  `users` WHERE `email` = '$id'";

            echo("API FETVH ". $query);
            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc()["Api"];
            }
            return $return;
        }

        public function getUser($id){
            $return = "";
            $query = "SELECT * FROM  `users` WHERE `name` = '$id'";

            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc();
            }
            return $return;
        }

        public function getUserFromApi($id){
            $return = "";
            $query = "SELECT * FROM  `users` WHERE `Api` = '$id'";

            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc();
            }
            return $return;
        }

        public function getApiEmail($id){
            $return = "";
            $query = "SELECT `Api` FROM  `users` WHERE `email` = '$id'";
            // echo $query;
            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc();
            }
            return $return;
        }


        public function addList($listName, $listDescription){
            // echo("IN CONFIUG");
            $userApi = $_SESSION["api_key"];

            $sql = "INSERT INTO `lists`(`ListName`, `Api`, `desc`) VALUES ('".$listName."','".$userApi."','".$listDescription."')";

            if (mysqli_query($this->connection, $sql)) {

                // echo("IN CONFIUG");

                header('Location: ../../profile.php');

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }

        public function removeList($listName){
            $userApi = $_SESSION["api_key"];

            $sql = "DELETE FROM `lists` WHERE `ListName`='$listName'";

            if (mysqli_query($this->connection, $sql)) {

                header('Location: ../../profile.php');

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }


        public function addFriend($friendApi){
            $userApi = $_SESSION["api_key"];

            $sql = "INSERT INTO `friends`(`Api`, `friendApi`) VALUES  ('".$userApi."', '".$friendApi."')";

            if (mysqli_query($this->connection, $sql)) {

                header('Location: ../../home.php');

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }

        public function removeFriend($friendApi){
            $userApi = $_SESSION["api_key"];
            
        
            $sql = "DELETE FROM `friends` WHERE `friendApi`='$friendApi' AND `Api`='$userApi'";

            // echo($sql);
        
            if (mysqli_query($this->connection, $sql)) {
                header('Location: ../../profile.php');
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }

        public function deleteArticle($articleName){
            $userApi = $_SESSION["api_key"];
        
            $sql = "DELETE FROM `articles` WHERE `articleName`='$articleName'";

            echo($sql);
        
            if (mysqli_query($this->connection, $sql)) {
                header('Location: ../../home.php');
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }

        public function deleteAccount($api){
            $userApi = $_SESSION["api_key"];

            // deleting from the below tables
            $tables = array("users", "articles", "lists");

            foreach ($tables as $table) {
                $sql = "DELETE FROM $table WHERE `Api` = '$userApi'";
                mysqli_query($this->connection, $sql);
            }

            // delete the users reviews and ratings
            $sqls = "DELETE FROM `reviews` WHERE `userApi`='$userApi'";

            if (mysqli_query($this->connection, $sqls)) {
                $sqlx = "DELETE FROM `friends` WHERE `Api`='$userApi' OR `friendApi`='$userApi'";

                if (mysqli_query($this->connection, $sqlx)) {
                    $sqlr = "DELETE FROM `messaged` WHERE `toApi`='$userApi' OR `fromApi`='$userApi'";
                    
                    if (mysqli_query($this->connection, $sqlr)) {
                        
                        header('Location: ../../index.php');
                    } else {
                        echo "Error: " . $sqlr . "<br>" . mysqli_error($this->connection);
                    }
                } else {
                    echo "Error: " . $sqlx . "<br>" . mysqli_error($this->connection);
                }
            } else {
                echo "Error: " . $sqls . "<br>" . mysqli_error($this->connection);
            }

            // echo($sql);
        
            // if (mysqli_query($this->connection, $sql)) {
            //     //now delete all their articles
            //     $sqls = "DELETE FROM `articles` WHERE `Api`='$userApi'";

            //     echo($sqls);
            
            //     if (mysqli_query($this->connection, $sqls)) {
            //         // now delete all their comments and ratings



            //         header('Location: ../../splash.php');
            //     } else {
            //         echo "Error: " . $sqls . "<br>" . mysqli_error($this->connection);
            //     }

            // } else {
            //     echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            // }
        }
        


        public function addComment($articleName, $comment, $rate){
            // get the img
            $userApi = $_SESSION["api_key"];

            // var_dump($userApi);
            // $user = $instance->getUserFromApi($userApi);

            // $img = $user['photo'];

            // var_dump($user);

            $return = "";
            $query = "SELECT * FROM  `users` WHERE `Api` = '$userApi'";

            $result = $this->connection->query($query);
            if($result){
                $return = $result->fetch_assoc();
            }

            // var_dump($return);
            $img = $return['photo'];



            $sql = "INSERT INTO `reviews`(`userApi`, `articleName`, `review`, `rate`, `photo`) VALUES ('$userApi','$articleName','$comment','$rate','$img')";

            if (mysqli_query($this->connection, $sql)) {


                header('Location: ../../home.php');

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }



        public function addArticle($Api, $date, $genre, $hashtags, $articleName, $bookTitle, $Author, $blurb, $description, $img){
            //echo "adding the user";


                $sql = "INSERT INTO `articles`(`Api`, `date`, `genre`, `hashtags`, `articleName`, `bookTitle`, `Author`, `blurb`, `description`, `img`) VALUES ('".$Api."', '".$date."', '".$genre."', '".$hashtags."', '".$articleName."', '".$bookTitle."', '".$Author."', '".$blurb."', '".$description."', '".$img."')";

                    echo "<p>SQL: ".$sql."</p>";


                if (mysqli_query($this->connection, $sql)) {


                        $_SESSION["logged_in"] = true;
                        $_SESSION["user_name"] = $name;
                        $_SESSION["api_key"] = $Api;
                        $_SESSION["email"] = $email;



                    header('Location: ../../home.php');

                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
                }
                
            

        }

        public function updateArticle($userName, $email, $Api, $date, $genre, $hashtags, $articleName, $bookTitle, $Author, $blurb, $description, $img, $oldName){
            
            $sql = "UPDATE `articles` SET 
            `Api` = '$Api',
            `date` = '$date',
            `genre` = '$genre',
            `hashtags` = '$hashtags',
            `articleName` = '$articleName',
            `bookTitle` = '$bookTitle',
            `Author` = '$Author',
            `blurb` = '$blurb',
            `description` = '$description',
            `img` = '$img'
            WHERE `articleName` = '$oldName'";

            if (mysqli_query($this->connection, $sql)) {

                $_SESSION["logged_in"] = true;

                $_SESSION["user_name"] = $userName;

                $_SESSION["api_key"] = $Api;
                $_SESSION["email"] = $email;

                header('Location: ../../home.php');

            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->connection);
            }
        }





        

        public function searchArticle($searchValInput, $hashtags, $user){

            //first get user api
            if($user != ""){
                $query = "SELECT * FROM `users` WHERE `name` = '$user'";
                $userResult = $this->connection->query($query);

                // $api=$userReturned['Api'];
                if ($userResult->num_rows > 0) {
                    // Fetch the user data
                    $userData = $userResult->fetch_assoc();
                    $api = $userData['Api'];
                }
            }
            else{
                $api = NULL;
            }

            // if all
            if($hashtags != null && $searchValInput != null && $api != null){
                $query = "SELECT * FROM `articles` WHERE `articleName` = '$searchValInput' AND `hashtags` = '$hashtags'AND `Api` = '$api'";
            }

            // search only
            if($hashtags == null && $searchValInput != null && $api == null){
                $query = "SELECT * FROM `articles` WHERE `articleName` = '$searchValInput'";
            }
            // hash only
            else if($hashtags != null && $searchValInput == null && $api == null){
                $query = "SELECT * FROM `articles` WHERE `hashtags` = '$hashtags'";
            }
            // user only
            else if($hashtags == null && $searchValInput == null && $api != null){
                $query = "SELECT * FROM `users` WHERE `api` = '$api'";
            }
            // hash and search
            else if($hashtags != null && $searchValInput != null && $api == null){
                $query = "SELECT * FROM `articles` WHERE `articleName` = '$searchValInput' AND `hashtags` = '$hashtags'";
            }
            // hash and user
            else if($hashtags != null && $searchValInput == null && $api != null){
                $query = "SELECT * FROM `articles` WHERE `articleName` = '$searchValInput' AND `Api` = '$api'";
            }
            // user and search
            else if($hashtags == null && $searchValInput != null && $api != null){
                $query = "SELECT * FROM `articles` WHERE `hashtags` = '$hashtags' AND `Api` = '$api'";
            }

            $result = $this->connection->query($query);
            $return = array(); // Initialize an empty array
        
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $return[] = $row; // Append each row to the array
                }
            }
        
            return $return;
        }

        public function isFriend($otherApi){
            $userApi = $_SESSION["api_key"];
        
            $sql = "SELECT * FROM `friends` WHERE `friendApi`='$otherApi' AND `Api`='$userApi'";

            $result = $this->connection->query($sql);

            // var_dump($sql);
            // var_dump($result);

            if ($result && $result->num_rows > 0) {
                return true;
            } else {
                return false;
            }
        }








        
        
    }

    //$obj = new Database();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // if($data != NULL){
            // echo("coming from inbox.js");
            $data = json_decode(file_get_contents("php://input"));
            if($data != NULL){
                if($data->receiver != NULL){
                    $toApi = $data->receiver;
                    $fromApi = $data->sender;
                    $time = $data->time;
                    $messageContent = $data->message;
                
                    $db = new Database();
                    if($toApi != ""){
                        $db->sendMessage($toApi, $fromApi, $time, $messageContent);
    
                    }
                }
            }
            
            
        // }

        
    }

?>