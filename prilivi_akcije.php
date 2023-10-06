<?php
include_once 'config/Database.php';
include_once 'class/Priliv.php';

$database = new Database();
$db = $database->getConnection();

$priliv = new Priliv($db);

if (!empty($_POST['action']) && $_POST['action'] == 'listaPriliva') {
	$priliv->listaPriliva();
}

if (!empty($_POST['action']) && $_POST['action'] == 'detaljiPriliva') {
	$priliv->id = $_POST["id"];
	$priliv->detaljiPriliva();
}

if (!empty($_POST['action']) && $_POST['action'] == 'dodajPriliv') {
	$priliv->vrsta_priliva_id = $_POST["vrsta_priliva_id"];
	$priliv->iznos = $_POST["iznos"];
	$priliv->datum = $_POST["datum"];
	$priliv->insert();
}

if (!empty($_POST['action']) && $_POST['action'] == 'urediPriliv') {
	$priliv->id = $_POST["id"];
	$priliv->vrsta_priliva_id = $_POST["vrsta_priliva_id"];
	$priliv->iznos = $_POST["iznos"];
	$priliv->datum = $_POST["datum"];
	$priliv->update();
}

if (!empty($_POST['action']) && $_POST['action'] == 'brisiPriliv') {
	$priliv->id = $_POST["id"];
	$priliv->delete();
}
?>