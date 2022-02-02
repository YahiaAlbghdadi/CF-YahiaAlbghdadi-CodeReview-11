<?php
    class Database {
        public $hostName = "localhost";
        public $userName = "root";
        public $password = "";
        public $dbName = "cr11_yahiaalbghdadi_petadoption"; 
        public $conn;
        function __construct()
        {
            $this->conn = new mysqli($this->hostName, $this->userName,$this->password, $this->dbName);
        }
        function __destruct()
        {
            $this->conn->close();
        }}