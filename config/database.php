<?php
session_start();
class Database
{

	private $host = 'localhost';
	private $user = 'root';
	private $password = '';
	private $database = 'baza-troskova';

	public function getConnection()
	{
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		if ($conn->connect_error) {
			die("Greska povezivanja na bazu podataka." . $conn->connect_error);
		} else {
			return $conn;
		}
	}
}
?>