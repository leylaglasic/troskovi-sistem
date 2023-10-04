<?php
include_once 'config/Database.php';
include_once 'class/Trosak.php';

$database = new Database();
$db = $database->getConnection();

$trosak = new Trosak($db);

if (!empty($_POST['action']) && $_POST['action'] == 'listaVrstaTroskova') {
	$trosak->listaVrstaTroskovaAction();
}

if (!empty($_POST['action']) && $_POST['action'] == 'detaljiVrsteTroskova') {
	$trosak->id = $_POST["id"];
	$trosak->detaljiVrstaTroskovaAction();
}

if (!empty($_POST['action']) && $_POST['action'] == 'dodajVrstuTroska') {
	$trosak->ime = $_POST["ime"];
	$trosak->status = $_POST["status"];
	$trosak->insert_vrsta_troska();
}

if (!empty($_POST['action']) && $_POST['action'] == 'urediVrstuTroska') {
	$trosak->id = $_POST["id"];
	$trosak->ime = $_POST["ime"];
	$trosak->status = $_POST["status"];
	$trosak->update_vrsta_troska();
}

if (!empty($_POST['action']) && $_POST['action'] == 'brisiVrstuTroska') {
	$trosak->id = $_POST["id"];
	$trosak->delete_vrsta_troska();
}

?>