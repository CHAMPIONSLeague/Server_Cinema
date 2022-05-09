<?php
	class Connessione{
		private $server = "localhost";
		private $dbname = "cinema";
		private $username = "root";
		private $password = "";
		public $conn;
		
		public function getConnection(){
			try{
				$this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);
			}catch(PDOException $e){
				echo "Errore di connessione";
			}
			return $this->conn;
		}
	}
?>