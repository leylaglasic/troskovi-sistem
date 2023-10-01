<?php
include_once 'config/Database.php';
include_once 'class/Trosak.php';

$database = new Database();
$db = $database->getConnection();

$trosak = new Trosak($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listaTroskova') {
	$trosak->listaTroskova();
}

if(!empty($_POST['action']) && $_POST['action'] == 'detaljiTroska') {
	$trosak->trosak_id = $_POST["id"];
	$trosak->detaljiTroska();
}

if(!empty($_POST['action']) && $_POST['action'] == 'dodajTrosak') {
	$trosak->vrsta_troska_id = $_POST["vrsta_troska_id"];
	$trosak->iznos = $_POST["iznos"];
	$trosak->datum = $_POST["datum"];
	$trosak->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'urediTrosak') {
	$trosak->id = $_POST["id"];
	$trosak->vrsta_troska_id = $_POST["vrsta_troska_id"];
	$trosak->iznos = $_POST["iznos"];
	$trosak->datum = $_POST["datum"];
	$trosak->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'brisiTrosak') {
	$trosak->id = $_POST["id"];
	$trosak->delete();
}

?>