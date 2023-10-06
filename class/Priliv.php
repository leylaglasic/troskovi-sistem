<?php
class Priliv
{

	private $PriliviTabela = 'prilivi';
	private $VrstaPrilivaTabela = 'vrsta_priliva';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function listaPriliva()
	{

		if ($_SESSION["userid"]) {
			$sqlQuery = "SELECT priliv.id, priliv.iznos, priliv.datum, vrsta_priliva.ime
				FROM " . $this->PriliviTabela . " AS priliv 
				LEFT JOIN " . $this->VrstaPrilivaTabela . " AS vrsta_priliva ON priliv	.vrsta_priliva_id = vrsta_priliva.id 
				WHERE priliv.korisnik_id = '" . $_SESSION["userid"] . "' ";

			if (!empty($_POST["search"]["value"])) {
				$sqlQuery .= ' AND (priliv.id LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR priliv.iznos LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR priliv.datum LIKE "%' . $_POST["search"]["value"] . '%" ';
				$sqlQuery .= ' OR vrsta_priliva.ime LIKE "%' . $_POST["search"]["value"] . '%" ';
			}

			if (!empty($_POST["order"])) {
				$sqlQuery .= 'ORDER BY ' . $_POST['order']['0']['column'] . ' ' . $_POST['order']['0']['dir'] . ' ';
			} else {
				$sqlQuery .= 'ORDER BY priliv.id ';
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
			while ($Priliv = $result->fetch_assoc()) {
				$rows = array();
				$rows[] = $count;
				$rows[] = ucfirst($Priliv['iznos']);
				$rows[] = $Priliv['ime'];
				$rows[] = $Priliv['datum'];
				$rows[] = '<button type="button" name="uredi" id="' . $Priliv["id"] . '" class="btn btn-outline-warning btn-sm uredi" data-bs-toggle="modal"
				data-bs-target="#prilivModal">
                <span><i class="bi bi-pencil"></i> Uredi</span>
              </button>';
				$rows[] = '<button type="button" name="brisi" id="' . $Priliv["id"] . '" class="btn btn-outline-danger btn-sm brisi">
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

		if ($this->vrsta_priliva_id && $this->datum && $this->iznos && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->PriliviTabela . "(`iznos`, `datum`, `vrsta_priliva_id`, `korisnik_id`)
				VALUES(?, ?, ?,?)");

			$this->iznos = htmlspecialchars(strip_tags($this->iznos));
			$this->datum = htmlspecialchars(strip_tags($this->datum));
			$this->vrsta_priliva_id = htmlspecialchars(strip_tags($this->vrsta_priliva_id));

			$stmt->bind_param("isii", $this->iznos, $this->datum, $this->vrsta_priliva_id, $_SESSION["userid"]);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function update()
	{

		if ($this->id && $this->vrsta_priliva_id && $this->datum && $this->iznos && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
			UPDATE " . $this->PriliviTabela . " 
			SET iznos = ?, datum = ?, vrsta_priliva_id = ?
			WHERE id = ?");

			$this->iznos = htmlspecialchars(strip_tags($this->iznos));
			$this->datum = htmlspecialchars(strip_tags($this->datum));
			$this->vrsta_priliva_id = htmlspecialchars(strip_tags($this->vrsta_priliva_id));

			$stmt->bind_param("isii", $this->iznos, $this->datum, $this->vrsta_priliva_id, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function delete()
	{
		if ($this->id && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->PriliviTabela . " 
				WHERE id = ?");

			$this->id = htmlspecialchars(strip_tags($this->id));

			$stmt->bind_param("i", $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function detaljiPriliva()
	{
		if ($this->id && $_SESSION["userid"]) {

			$sqlQuery = "
			SELECT Priliv.id, Priliv.iznos, Priliv.datum, Priliv.vrsta_priliva_id
			FROM " . $this->PriliviTabela . " AS Priliv
			LEFT JOIN " . $this->VrstaPrilivaTabela . " AS vrsta_priliva ON Priliv.vrsta_priliva_id = vrsta_priliva.id
			WHERE Priliv.id = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($Priliv = $result->fetch_assoc()) {
				$rows = array();
				$rows['id'] = $Priliv['id'];
				$rows['iznos'] = $Priliv['iznos'];
				$rows['datum'] = $Priliv['datum'];
				$rows['vrsta_priliva_id'] = $Priliv['vrsta_priliva_id'];
				$records[] = $rows;
			}
			$output = array(
				"data" => $records
			);
			echo json_encode($output);
		}
	}

	function listaVrstaPriliva()
	{
		$stmt = $this->conn->prepare("
		SELECT id, ime, status FROM " . $this->VrstaPrilivaTabela);
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	public function listaVrstaPrilivaAction()
	{

		$sqlQuery = "SELECT id, ime, status
			FROM " . $this->VrstaPrilivaTabela . " ";

		if (!empty($_POST["search"]["value"])) {
			$sqlQuery .= ' AND (id LIKE "%' . $_POST["search"]["value"] . '%" ';
			$sqlQuery .= ' OR ime LIKE "%' . $_POST["search"]["value"] . '%" ';

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
		while ($vrsta_priliva = $result->fetch_assoc()) {
			$rows = array();
			$rows[] = $count;
			$rows[] = ucfirst($vrsta_priliva['ime']);
			$rows[] = $vrsta_priliva['status'];
			$rows[] = '<button type="button" name="uredi" id="' . $vrsta_priliva["id"] . '" class="btn btn-outline-warning btn-sm uredi" data-bs-toggle="modal"
				data-bs-target="#vrstaPrilivaModal">
                <span><i class="bi bi-pencil"></i> Uredi</span>
              </button>';
			$rows[] = '<button type="button" name="brisi" id="' . $vrsta_priliva["id"] . '" class="btn btn-outline-danger btn-sm brisi">
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

	public function insertVrstaPriliva()
	{

		if ($this->ime && $this->status && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				INSERT INTO " . $this->VrstaPrilivaTabela . "(`ime`, `status`)
				VALUES(?, ?)");

			$this->ime = htmlspecialchars(strip_tags($this->ime));
			$this->status = htmlspecialchars(strip_tags($this->status));

			$stmt->bind_param("ss", $this->ime, $this->status);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function updateVrstaPriliva()
	{

		if ($this->id && $this->ime && $this->status && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
			UPDATE " . $this->VrstaPrilivaTabela . " 
			SET ime = ?, status = ?
			WHERE id = ?");

			$this->ime = htmlspecialchars(strip_tags($this->ime));
			$this->status = htmlspecialchars(strip_tags($this->status));

			$stmt->bind_param("ssi", $this->ime, $this->status, $this->id);

			if ($stmt->execute()) {
				return true;
			}
		}
	}

	public function detaljiVrstePriliva()
	{
		if ($this->id && $_SESSION["userid"]) {

			$sqlQuery = "
			SELECT id, ime, status
			FROM " . $this->VrstaPrilivaTabela . " WHERE id = ? ";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->bind_param("i", $this->id);
			$stmt->execute();
			$result = $stmt->get_result();
			$records = array();
			while ($vrsta_priliva = $result->fetch_assoc()) {
				$rows = array();
				$rows['id'] = $vrsta_priliva['id'];
				$rows['ime'] = $vrsta_priliva['ime'];
				$rows['status'] = $vrsta_priliva['status'];
				$records[] = $rows;
			}
			$output = array(
				"data" => $records
			);
			echo json_encode($output);
		}
	}


	public function deleteVrstaPriliva()
	{
		if ($this->id && $_SESSION["userid"]) {

			$stmt = $this->conn->prepare("
				DELETE FROM " . $this->VrstaPrilivaTabela . " 
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