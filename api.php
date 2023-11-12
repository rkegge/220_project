<?php

    class Database{
        private $connection;

        private $servername = "localhost";
        private $username = "u20426586";
        private $password = "xvirfcyu";
        private $db = "u20426586";

        public function __construct() {
            session_start();

			// make connection
            
            $this->connection = new mysqli($this->servername, $this->username, $this->password, $this->db);

            if($this->connection->connect_error) {
                //echo "CALLIN my API.php"; 
                die("Connection failed: " . $this->connection->connect_error);
            }

			// Get the JSON POST data and save it into a var
			$jsonINPUT = file_get_contents('php://input');

			// Decode the JSON data into a PHP usable var/arr
			$data = json_decode($jsonINPUT, true);

			$this->sqlState($data);

        }

        
    }

    $obj = new Database();
?>