<?php
include_once 'config/Database.php';
include_once 'class/Priliv.php';

$database = new Database();
$db = $database->getConnection();

$prilivi = new Priliv($db);

if (!empty($_POST['action']) && $_POST['action'] == 'listaVrstaPriliva') {
	$prilivi->listaVrstaPrilivaAction();
}

if (!empty($_POST['action']) && $_POST['action'] == 'detaljiVrstePriliva') {
	$prilivi->id = $_POST["id"];
	$prilivi->detaljiVrstePriliva();
}

if (!empty($_POST['action']) && $_POST['action'] == 'dodajVrstuPriliva') {
	$prilivi->ime = $_POST["ime"];
	$prilivi->status = $_POST["status"];
	$prilivi->insertVrstaPriliva();
}

if (!empty($_POST['action']) && $_POST['action'] == 'urediVrstuPriliva') {
	$prilivi->id = $_POST["id"];
	$prilivi->ime = $_POST["ime"];
	$prilivi->status = $_POST["status"];
	$prilivi->updateVrstaPriliva();
}

if (!empty($_POST['action']) && $_POST['action'] == 'brisiVrstuPriliva') {
	$prilivi->id = $_POST["id"];
	$prilivi->deleteVrstaPriliva();
}
?>