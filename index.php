<?php 
include_once 'config/Database.php';
include_once 'class/Korisnik.php';

$database = new Database();
$db = $database->getConnection();

$Korisnik = new Korisnik($db);

if($Korisnik->loggedIn()) {	
	header("Location: troskovi.php");	
}

$loginMessage = '';
if(!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {	
	$Korisnik->email = $_POST["email"];
	$Korisnik->password = $_POST["password"];	
	if($Korisnik->login()) {
		header("Location: troskovi.php");	
	} else {
		$loginMessage = 'Informacije nisu tacne. Pokusajte ponovo.';
	}
} 

include('inc/header.php');
include('inc/container.php');
?>
<form id="loginform" role="form" method="POST" action="">
    <img class="mb-4" src="/biblioteke/icons/coin.svg" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Prijava na sistem</h1>

    <div class="form-floating">
      <input type="text" class="form-control" id="email" name="email" value="<?php if(!empty($_POST["email"])) { echo $_POST["email"]; } ?>" placeholder="ime@domena.ba" required>
      <label for="email">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="password" name="password" value="<?php if(!empty($_POST["password"])) { echo $_POST["password"]; } ?>" placeholder="password" required>
      <label for="floatingPassword">Password</label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit" name="login" value="Login">Prijava</button>
	<hr>

	<?php if ($loginMessage != '') { ?>
					                			
	<div class="alert alert-info" role="alert">
  <p><?php echo $loginMessage; ?></p>
</div>
<?php } ?>
  </form>
  <div class="row">
    <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-subtitle">Admin</h5>
        <p class="card-text mb-0">Email: admin@admin.com</p>
        <p class="card-text">Password: 123</p>
      </div>
    </div>
    </div>
    <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-subtitle">Korisnik</h5>
        <p class="card-text mb-0">Email: korisnik@korisnik.com</p>
        <p class="card-text">Password: 123</p>
      </div>
    </div>
    </div>
  </div>
</main>
<?php include('inc/footer.php');?>
<script src="/biblioteke/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>			      

