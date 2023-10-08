<?php
include_once 'config/Database.php';
include_once 'class/Izvjestaj.php';

$database = new Database();
$db = $database->getConnection();

$izvjestaj = new Izvjestaj($db);

if(!empty($_POST['action']) && $_POST['action'] == 'prikaziIzvjestaj') {
	$izvjestaj->odDatum = $_POST['odDatum'];
	$izvjestaj->doDatum = $_POST['doDatum'];
	$izvjestaj->prikaziIzvjestaj();
}
?>