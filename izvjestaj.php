<?php
include('inc/sistem-pocetna-top.php');
?>

<main>
	<?php if ($_SESSION["rola"] == 'administrator') { ?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Tenth navbar example">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sistem-menu"
					aria-controls="sistem-menu" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-md-center" id="sistem-menu">
					<ul class="navbar-nav">
						<li id="troskovi" class="nav-item">
							<a class="nav-link" href="troskovi.php">Troskovi</a>
						</li>
						<li id="izvjestaj_meni_admin" class="nav-item">
							<a class="nav-link active" aria-current="page" href="izvjestaj.php">Izvjestaj</a>
						</li>
						<li id="prilivi" class="nav-item">
							<a class="nav-link" href="prilivi.php">Prilivi</a>
						</li>
						<li id="vrste_troskova" class="nav-item">
							<a class="nav-link" href="vrste_troskova.php">Vrste Troskova</a>
						</li>
						<li id="vrste_priliva" class="nav-item">
							<a class="nav-link" href="vrste_priliva.php">Vrste Priliva</a>
						</li>
						<li id="korisnici" class="nav-item">
							<a class="nav-link" href="korisnici.php">Korisnici</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	<?php }
	if ($_SESSION["rola"] == 'korisnik') { ?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark" aria-label="Tenth navbar example">
			<div class="container-fluid">
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample08"
					aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-md-center" id="sistem-menu">
					<ul class="navbar-nav">
						<li id="trosak" class="nav-item">
							<a class="nav-link" href="troskovi.php">Troskovi</a>
						</li>
						<li id="izvjestaj_meni_korisnik" class="nav-item">
							<a class="nav-link active" aria-current="page" href="izvjestaj.php">Izvjestaj</a>
						</li>
						<li id="priliv" class="nav-item">
							<a class="nav-link" href="prilivi.php">Prilivi</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	<?php } ?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<script src="js/izvjestaj.js"></script>
	<div class="panel-heading">
		<div class="row">
			<div>
				<h4>Izvjestaj troskova i priliva</h4>
			</div>
			<div class="col-md-3">
				<label for="od_datum" class="control-label">Od</label>
				<input type="date" class="form-control" id="od_datum" name="od_datum" placeholder="Od datuma">
			</div>
			<div class="col-md-3">
				<label for="do_datum" class="control-label">Do</label>
				<input type="date" class="form-control" id="do_datum" name="do_datum" placeholder="Do Datuma">
			</div>
			<div class="col-md-3">
				<button type="submit" id="izvjestaj" title="Vidi Izvjestaj" class="btn btn-success">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
						class="bi bi-binoculars-fill" viewBox="0 0 16 16">
						<path
							d="M4.5 1A1.5 1.5 0 0 0 3 2.5V3h4v-.5A1.5 1.5 0 0 0 5.5 1h-1zM7 4v1h2V4h4v.882a.5.5 0 0 0 .276.447l.895.447A1.5 1.5 0 0 1 15 7.118V13H9v-1.5a.5.5 0 0 1 .146-.354l.854-.853V9.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v.793l.854.853A.5.5 0 0 1 7 11.5V13H1V7.118a1.5 1.5 0 0 1 .83-1.342l.894-.447A.5.5 0 0 0 3 4.882V4h4zM1 14v.5A1.5 1.5 0 0 0 2.5 16h3A1.5 1.5 0 0 0 7 14.5V14H1zm8 0v.5a1.5 1.5 0 0 0 1.5 1.5h3a1.5 1.5 0 0 0 1.5-1.5V14H9zm4-11H9v-.5A1.5 1.5 0 0 1 10.5 1h1A1.5 1.5 0 0 1 13 2.5V3z">
						</path>
					</svg>
					Vidi Izvjestaj
				</button>
			</div>
		</div>
	</div>
	<table class="table table-bordered table-striped" id="izvjestajTabela" style="display:none;">
		<thead>
			<tr>
				<th>Trosak</th>
				<th>Datum</th>
				<th>Vrsta Troska</th>
			</tr>
		</thead>
		<tbody id="listaIzvjestaja">

		</tbody>
	</table>
	<div class="panel-heading" id="detalji" style="display:none;">
	<div class="row">
  <div class="col-sm-2 mb-3 mb-sm-0">
    <div class="card text-bg-primary">
      <div class="card-body">
        <h5 class="card-title">Ukupni Prilivi: </h5>
        <p id="ukupniPrilivi" class="card-text"></p>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card text-bg-secondary">
      <div class="card-body">
	  <h5 class="card-title">Ukupni Troskovi: </h5>
        <p id="ukupniTroskovi" class="card-text"></p>
      </div>
    </div>
  </div>
  <div class="col-sm-2">
    <div class="card text-bg-success">
      <div class="card-body">
	  <h5 class="card-title">Ukupna Usteda: </h5>
        <p id="ukupnaUsteda" class="card-text"></p>
      </div>
    </div>
  </div>
</div>
	</div>
	<div class="panel-heading" id="bez_izvjestaja" style="display:none;">
	</div>
</main>
<?php include('inc/sistem-pocetna-bottom.php'); ?>