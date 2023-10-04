<?php
include_once 'config/Database.php';
include_once 'class/Korisnik.php';

$database = new Database();
$db = $database->getConnection();

$korisnik = new Korisnik($db);

if(!empty($_POST['action']) && $_POST['action'] == 'listaKorisnika') {
	$korisnik->listaKorisnika();
}

if(!empty($_POST['action']) && $_POST['action'] == 'detaljiKorisnika') {
	$korisnik->id = $_POST["id"];
	$korisnik->detaljiKorisnika();
}

if(!empty($_POST['action']) && $_POST['action'] == 'dodajKorisnika') {
	$korisnik->rola = $_POST["rola"];
	$korisnik->ime = $_POST["ime"];
	$korisnik->prezime = $_POST["prezime"];
	$korisnik->email = $_POST["email"];
	$korisnik->password = $_POST["password"];
	$korisnik->insert();
}

if(!empty($_POST['action']) && $_POST['action'] == 'urediKorisnika') {
	$korisnik->id = $_POST["id"];
	$korisnik->rola = $_POST["rola"];
	$korisnik->ime = $_POST["ime"];
	$korisnik->prezime = $_POST["prezime"];
	$korisnik->email = $_POST["email"];
	$korisnik->password = $_POST["password"];
	$korisnik->update();
}

if(!empty($_POST['action']) && $_POST['action'] == 'brisiKorisnika') {
	$korisnik->id = $_POST["id"];
	$korisnik->delete();
}

?>