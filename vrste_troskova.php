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
						<li id="expense" class="nav-item">
							<a class="nav-link" href="troskovi.php">Troskovi</a>
						</li>
						<li id="report" class="nav-item">
							<a class="nav-link" href="izvjestaj.php">Izvjestaj</a>
						</li>
						<li id="income" class="nav-item">
							<a class="nav-link" href="prilivi.php">Prilivi</a>
						</li>
						<li id="vrste_troskova" class="nav-item">
							<a class="nav-link active" aria-current="page"" href=" vrste_troskova.php">Vrste Troskova</a>
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
						<li id="expense" class="nav-item">
							<a class="nav-link active" aria-current="page" href="troskovi.php">Troskovi</a>
						</li>
						<li id="report" class="nav-item">
							<a class="nav-link" href="izvjestaj.php">Izvjestaj</a>
						</li>
						<li id="income" class="nav-item">
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
	<script src="js/vrste_troskova.js"></script>
	<div>
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2">
					<button type="button" id="dodajVrstuTroska" class="btn btn-primary btn-sm" data-bs-toggle="modal"
						data-bs-target="#vrstaTroskaModal">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
							class="bi bi-plus-circle" viewBox="0 0 16 16">
							<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
							<path
								d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
							</path>
						</svg>
						Dodaj Vrstu Troska
					</button>
				</div>
			</div>
		</div>
		<table id="listaVrstaTroskova" class="table table-bordered table-striped w-100">
			<thead>
				<tr>
					<th>#</th>
					<th>Ime</th>
					<th>Status</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
		<div class="modal fade" id="vrstaTroskaModal" tabindex="-1" role="dialog"
			aria-labelledby="vrstaTroskaModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<form method="post" id="vrstaTroskaForma">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title align-self-start"><i class="bi bi-plus-square-fill"></i> Uredi Vrstu
								Troska</h5>
							<div class="align-self-end"><button type="button" class="btn-close btn-sm "
									data-bs-dismiss="modal" aria-label="Close"></button></div>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="ime" class="control-label">Ime vrste troska</label>
								<input type="text" name="ime" id="ime" autocomplete="off" class="form-control"
									placeholder="Ime vrste troska" />

							</div>
							<div class="form-group">
								<label for="country" class="control-label">Status</label>
								<select class="form-control" id="status" name="status">
									<option value="">Odaberi Status</option>
									<option value="aktivan">Aktivan</option>
									<option value="neaktivan">Neaktivan</option>
								</select>
							</div>
							<div class="modal-footer">
								<input type="hidden" name="id" id="id" />
								<input type="hidden" name="action" id="action" value="" />
								<input type="submit" name="sacuvaj" id="sacuvaj" class="btn btn-success"
									value="Sacuvaj" />
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
							</div>
						</div>
				</form>
			</div>
		</div>
	</div>
</main>


<?php include('inc/sistem-pocetna-bottom.php'); ?>