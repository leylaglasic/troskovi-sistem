<?php
class Korisnik
{

	private $korisnici = 'korisnici';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function listaKorisnika()
	{

		$sqlQuery = "SELECT id, ime, prezime, email, password, rola
			FROM " . $this->korisnici . " ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' WHERE (id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR ime LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR email LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR password LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR rola LIKE "%' . $_POST["search"]["value"] . '%" ';
		}

		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY id DESC ';
		}

		if ($_POST["length"] != -1) {
			$sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
		}

		$stmt = $this->conn->prepare($sqlQuery);
		$stmt->execute();
		$result = $stmt->get_result();

		$stmtTotal = $this->conn->prepare($sqlQuery);
		$stmtTotal->execute();
		$allResult = $stmtTotal->get_result();
		$allRecords = $allResult->num_rows;

		$displayRecords = $result->num_rows;
		$records = array();
		$count = 1;
		while ($Korisnik = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = ucfirst($Korisnik['ime']) . " " . ucfirst($Korisnik['prezime']);
			$rows[] = $Korisnik['email'];
			$rows[] = $Korisnik['rola'];
			$rows[] = '<button type="button" name="update" id="' . $Korisnik["id"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Edit"></span></button>';
			$rows[] = '<button type="button" name="delete" id="' . $Korisnik["id"] . '" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Delete"></span></button>';
			$records[] = $rows;
			$count++;
		}

		$output = array(
			"draw" => intval($_POST["draw"]),
			"iTotalRecords" => $displayRecords,
			"iTotalDisplayRecords" => $allRecords,
			"data" => $records
		);

		echo json_encode($output);
	}

	public function insert()
	{

		if ($this->rola && $this->email && $this->password && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->korisnici . "(`ime`, `prezime`, `email`, `password`, `rola`)
				VALUES(?, ?, ?, ?, ?)");

			$this->rola = htmlspecialchars(strip_tags($this->rola));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->ime = htmlspecialchars(strip_tags($this->ime));
			$this->prezime = htmlspecialchars(strip_tags($this->prezime));
			$this->password = md5($this->password);
			$stmt->bind_param("sssss", $this->ime, $this->prezime, $this->email, $this->password, $this->rola);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function update()
	{

		if ($this->rola && $this->email && $_SESSION["userid"]) {

			$updatePass = '';
			if ($this->password) {
				$this->password = md5($this->password);
				$updatePass = ", password = '" . $this->password . "'";
			}

			$stmt = $this->conn->prepare("
				UPDATE " . $this->korisnici . " 
				SET ime = ?, prezime = ?, email = ?, rola = ? $updatePass
				WHERE id = ?");

			$this->rola = htmlspecialchars(strip_tags($this->rola));
			$this->email = htmlspecialchars(strip_tags($this->email));
			$this->ime = htmlspecialchars(strip_tags($this->ime));
			$this->prezime = htmlspecialchars(strip_tags($this->prezime));

			$stmt->bind_param("ssssi", $this->ime, $this->prezime, $this->email, $this->rola, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->id && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->korisnici . " 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function detaljiKorisnika()
	{
		if ($this->Korisnik_id && $_SESSION["userid"]) {

			$sqlQuery = "
				SELECT id, ime, prezime, email, password, rola
				FROM " . $this->korisnici . "			
				WHERE id = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->Korisnik_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($Korisnik = $result->fetch_assoc()) {
				$rows = array();
				$rows['id'] = $Korisnik['id'];
				$rows['ime'] = $Korisnik['ime'];
				$rows['prezime'] = $Korisnik['prezime'];
				$rows['email'] = $Korisnik['email'];
				$rows['rola'] = $Korisnik['rola'];
				$records[] = $rows;
			}
			$output = array(
				"data" => $records
			);
			echo json_encode($output);
		}
	}

	public function login()
	{
		if ($this->email && $this->password) {
			$sqlQuery = "
				SELECT * FROM " . $this->korisnici . " 
				WHERE email = ? AND password = ?";
			$stmt = $this->conn->prepare($sqlQuery);
			$password = md5($this->password);
			$stmt->bind_param("ss", $this->email, $password);
			$stmt->execute();
			$result = $stmt->get_result();
			if ($result->num_rows > 0) {
				$Korisnik = $result->fetch_assoc();
				$_SESSION["userid"] = $Korisnik['id'];
				$_SESSION["rola"] = $Korisnik['rola'];
				$_SESSION["name"] = $Korisnik['email'];
				return 1;
			} else {
				return 0;
			}
		} else {
			return 0;
		}
	}

	public function loggedIn()
	{
		if (!empty($_SESSION["userid"])) {
			return 1;
		} else {
			return 0;
		}
	}
}
?>