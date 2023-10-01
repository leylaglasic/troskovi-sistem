<?php
class Trosak
{

	private $vrsta_troska = ' vrsta_troska';
	private $Troskovi = ' troskovi';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function listaTroskova()
	{
		if ($_SESSION["userid"]) {
			$sqlQuery = "SELECT Trosak.id, Trosak.iznos, Trosak.datum, kategorija_troska.ime
				FROM " . $this->Troskovi . " AS Trosak 
				LEFT JOIN " . $this->vrsta_troska . " AS kategorija_troska ON Trosak.vrsta_troska_id = kategorija_troska.id
				WHERE Trosak.korisnik_id = '" . $_SESSION["userid"] . "' ";

			if (!empty($_POST["search"]["value"])) {
				$sqlQuery .= ' AND (Trosak.id LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR Trosak.iznos LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR Trosak.datum LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR kategorija_troska.ime LIKE "%' . $_POST["search"]["value"] . '%") ';
			}

			if (!empty($_POST["order"])) {
				$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$sqlQuery .= 'ORDER BY Trosak.datum DESC ';
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
			while ($Trosak = $result->fetch_assoc()) {
				$rows = array();
				$rows[] = $count;
				$rows[] = ucfirst($Trosak['iznos']);
				$rows[] = $Trosak['ime'];
				$rows[] = $Trosak['datum'];
				$rows[] = '<button type="button" name="uredi" id="' . $Trosak["id"] . '" class="btn btn-outline-warning btn-sm uredi" data-bs-toggle="modal"
				data-bs-target="#trosakModal">
                <span><i class="bi bi-pencil"></i> Uredi</span>
              </button>';
			  $rows[] = '<button type="button" name="brisi" id="' . $Trosak["id"] . '" class="btn btn-outline-danger btn-sm brisi">
			  <span><i class="bi bi-trash3"></i> Brisi</span>
			</button>';
			
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
	}

	public function insert()
	{

		if ($this->vrsta_troska_id && $this->datum && $this->iznos && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->Troskovi . "(`iznos`, `datum`, `vrsta_troska_id`, `korisnik_id`)
				VALUES(?, ?, ?, ?)");

			$this->iznos = htmlspecialchars(strip_tags($this->iznos));
			$this->datum = htmlspecialchars(strip_tags($this->datum));
			$this->vrsta_troska_id = htmlspecialchars(strip_tags($this->vrsta_troska_id));

			$stmt->bind_param("isii", $this->iznos, $this->datum, $this->vrsta_troska_id, $_SESSION["userid"]);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function update()
	{

		if ($this->id && $this->vrsta_troska_id && $this->iznos && $this->datum && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
			UPDATE " . $this->Troskovi . " 
			SET iznos = ?, datum = ?, vrsta_troska_id = ?
			WHERE id = ?");

			$this->iznos = htmlspecialchars(strip_tags($this->iznos));
			$this->datum = htmlspecialchars(strip_tags($this->datum));
			$this->vrsta_troska_id = htmlspecialchars(strip_tags($this->vrsta_troska_id));

			$stmt->bind_param("isii", $this->iznos, $this->datum, $this->vrsta_troska_id, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->id && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->Troskovi . " 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	function listaVrstaTroskova()
	{
		$stmt = $this->conn->prepare("
		SELECT id, ime, status FROM " . $this->vrsta_troska);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	public function detaljiTroska()
	{
		if ($this->trosak_id && $_SESSION["userid"]) {

			$sqlQuery = "
			SELECT Trosak.id, Trosak.iznos, Trosak.datum, Trosak.vrsta_troska_id
			FROM " . $this->Troskovi . " AS Trosak
			LEFT JOIN " . $this->vrsta_troska . " AS kategorija_troska ON Trosak.vrsta_troska_id = kategorija_troska.id
			WHERE Trosak.id = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->trosak_id);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($Trosak = $result->fetch_assoc()) {
				$rows = array();
				$rows['id'] = $Trosak['id'];
				$rows['iznos'] = $Trosak['iznos'];
				$rows['datum'] = $Trosak['datum'];
				$rows['vrsta_troska_id'] = $Trosak['vrsta_troska_id'];
				$records[] = $rows;
			}
			$output = array(
				"data" => $records
			);
			echo json_encode($output);
		}
	}

	public function listaVrstaTroskovaAction()
	{

		$sqlQuery = "SELECT id, ime, status
			FROM " . $this->vrsta_troska . " ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' AND (id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR ime LIKE "%' . $_POST["search"]["value"] . '%" ';

		}

		if (!empty($_POST["order"])) {
			$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
		} else {
			$sqlQuery .= 'ORDER BY id ';
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
		while ($vrsta_troska = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = ucfirst($vrsta_troska['ime']);
			$rows[] = $vrsta_troska['status'];
			$rows[] = '<button type="button" ime="update" id="' . $vrsta_troska["id"] . '" class="btn btn-warning btn-xs update"><span class="glyphicon glyphicon-edit" title="Uredi"></span></button>';
			$rows[] = '<button type="button" ime="delete" id="' . $vrsta_troska["id"] . '" class="btn btn-danger btn-xs delete" ><span class="glyphicon glyphicon-remove" title="Brisi"></span></button>';
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

	public function insert_vrsta_troska()
	{

		if ($this->vrsta_troska_ime && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->vrsta_troska . "(`ime`, `status`)
				VALUES(?, ?)");

			$this->vrsta_troska_ime = htmlspecialchars(strip_tags($this->vrsta_troska_ime));
			$this->status = htmlspecialchars(strip_tags($this->status));

			$stmt->bind_param("ss", $this->vrsta_troska_ime, $this->status);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function update_vrsta_troska()
	{

		if ($this->id && $this->vrsta_troska_ime && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
			UPDATE " . $this->vrsta_troska . " 
			SET ime = ?, status = ?
			WHERE id = ?");

			$this->vrsta_troska_ime = htmlspecialchars(strip_tags($this->vrsta_troska_ime));
			$this->status = htmlspecialchars(strip_tags($this->status));

			$stmt->bind_param("ssi", $this->vrsta_troska_ime, $this->status, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function detaljiVrstaTroskovaAction()
	{
		if ($this->id && $_SESSION["userid"]) {

			$sqlQuery = "
			SELECT id, ime, status
			FROM " . $this->vrsta_troska . " WHERE id = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($vrsta_troska = $result->fetch_assoc()) {
				$rows = array();
				$rows['id'] = $vrsta_troska['id'];
				$rows['ime'] = $vrsta_troska['ime'];
				$rows['status'] = $vrsta_troska['status'];
				$records[] = $rows;
			}
			$output = array(
				"data" => $records
			);
			echo json_encode($output);
		}
	}


	public function delete_vrsta_troska()
	{
		if ($this->id && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->vrsta_troska . " 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

}
?>