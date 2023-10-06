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
							<a class="nav-link active" aria-current="page" href="prilivi.php">Prilivi</a>
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
						<li id="expense" class="nav-item">
							<a class="nav-link" href="troskovi.php">Troskovi</a>
						</li>
						<li id="report" class="nav-item">
							<a class="nav-link" href="izvjestaj.php">Izvjestaj</a>
						</li>
						<li id="income" class="nav-item">
							<a class="nav-link  active" aria-current="page" href="prilivi.php">Prilivi</a>
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
	<script src="js/priliv.js"></script>
	<div>
		<div class="panel-heading">
			<div class="row">
				<div class="col-md-10">
					<h3 class="panel-title"></h3>
				</div>
				<div class="col-md-2">
					<button type="button" id="dodajPriliv" class="btn btn-primary btn-sm" data-bs-toggle="modal"
						data-bs-target="#prilivModal">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
							class="bi bi-plus-circle" viewBox="0 0 16 16">
							<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
							<path
								d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z">
							</path>
						</svg>
						Dodaj Priliv
					</button>
				</div>
			</div>
		</div>
		<table id="listaPriliva" class="table table-bordered table-striped w-100">
			<thead>
				<tr>
					<th>#</th>
					<th>Iznos</th>
					<th>Vrsta Priliva</th>
					<th>Datum</th>
					<th></th>
					<th></th>
				</tr>
			</thead>
		</table>
		<div class="modal fade" id="prilivModal" tabindex="-1" role="dialog" aria-labelledby="prilivModalLabel"
			aria-hidden="true">
			<div class="modal-dialog">
				<form method="post" id="prilivForma">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title align-self-start"><i class="bi bi-plus-square-fill"></i> Uredi Priliv
							</h5>
							<div class="align-self-end"><button type="button" class="btn-close btn-sm "
									data-bs-dismiss="modal" aria-label="Close"></button></div>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label for="country" class="control-label">Vrsta Priliva</label>
								<select class="form-control" id="vrsta_priliva_id" name="vrsta_priliva_id">
									<option value="">Odaberi Vrstu Priliva</option>
									<?php
									$vrstaPrilivaRezultat = $Priliv->listaVrstaPriliva();
									while ($vrsta_priliva_id = $vrstaPrilivaRezultat->fetch_assoc()) {
										?>
										<option value="<?php echo $vrsta_priliva_id['id']; ?>">
											<?php echo $vrsta_priliva_id['ime']; ?>
										</option>
									<?php } ?>
								</select>
							</div>

							<div class="form-group">
								<label for="priliv" class="control-label">Iznos</label>
								<input type="text" name="iznos" id="iznos" autocomplete="off" class="form-control" />

							</div>

							<div class="form-group">
								<label for="project" class="control-label">Datum</label>
								<input type="date" class="form-control" id="datum" name="datum"
									placeholder="Datum priliva">
							</div>

						</div>
						<div class="modal-footer">
							<input type="hidden" name="id" id="id" />
							<input type="hidden" name="action" id="action" value="" />
							<input type="submit" name="sacuvaj" id="sacuvaj" class="btn btn-success" value="Sacuvaj" />
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</main>


<?php include('inc/sistem-pocetna-bottom.php'); ?>