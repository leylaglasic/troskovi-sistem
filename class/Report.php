<?php
class Report
{

	private $vrstaTroskaTabela = ' vrsta_troska';
	private $troskoviTabela = ' troskovi';
	private $priliviTabela = 'prilivi';
	private $vrstaPrilivaTabela = 'vrsta_priliva';
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	public function prikaziReport()
	{
		if ($this->odDatum && $this->doDatum && $_SESSION["userid"]) {

			$sqlQuery = "SELECT prilivi.id, prilivi.iznos, prilivi.datum, vrsta_priliva.ime AS vrsta_priliva_ime
				FROM " . $this->priliviTabela . " AS prilivi 
				LEFT JOIN " . $this->vrstaPrilivaTabela . " AS vrsta_priliva ON prilivi.vrsta_priliva_id = vrsta_priliva.id 
				WHERE prilivi.korisnik_id = '" . $_SESSION["userid"] . "' AND prilivi.datum BETWEEN  '" . $this->odDatum . "' AND '" . $this->doDatum . "'";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$priliviNiz = array();
			$ukupniPriliv = 0;
			while ($priliv = $result->fetch_assoc()) {
				$ukupniPriliv += $priliv['iznos'];
			}
			if ($ukupniPriliv) {
				$row = array();
				$row['total'] = $ukupniPriliv;
				$priliviNiz[] = $row;
			}

			$sqlQuery = "SELECT troskovi.id, troskovi.iznos, troskovi.datum, vrsta_troska.ime AS vrsta_troska_ime
				FROM " . $this->troskoviTabela . " AS troskovi 
				LEFT JOIN " . $this->vrstaTroskaTabela . " AS vrsta_troska ON troskovi.vrsta_troska_id = vrsta_troska.id 
				WHERE troskovi.datum BETWEEN  '" . $this->odDatum . "' AND '" . $this->doDatum . "'";

			$stmt = $this->conn->prepare($sqlQuery);
			$stmt->execute();
			$result = $stmt->get_result();
			$troskoviNiz = array();
			while ($troskovi = $result->fetch_assoc()) {
				$rows = array();
				$rows['id'] = $troskovi['id'];
				$rows['iznos'] = $troskovi['iznos'];
				$rows['datum'] = $troskovi['datum'];
				$rows['vrsta_troska_ime'] = $troskovi['vrsta_troska_ime'];
				$troskoviNiz[] = $rows;
			}
			$output = array(
				"troskovi" => $troskoviNiz,
				"prilivi" => $priliviNiz
			);
			echo json_encode($output);
		}
	}
}
?>