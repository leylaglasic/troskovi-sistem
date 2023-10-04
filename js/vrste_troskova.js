$(document).ready(function () {

	var vrste_troskova = $('#listaVrstaTroskova').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": false,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "vrste_troskova_akcije.php",
			type: "POST",
			data: { action: 'listaVrstaTroskova' },
			dataType: "json"
		},
		"columnDefs": [
			{
				"targets": [0, 3, 4],
				"orderable": false,
			},
		],
		"pageLength": 10
	});

	$('#dodajVrstuTroska').click(function () {
		$('#vrstaTroskaModal').modal({
			backdrop: 'static',
			keyboard: false
		}).toggle();
		$("#vrstaTroskaModal").on("shown.bs.modal", function () {
			$('#vrstaTroskaForma')[0].reset();
			$('.modal-title').html('<i class=\"bi bi-plus-circle \"></i> Dodaj Vrstu Troska');
			$('#action').val('dodajVrstuTroska');
			$('#sacuvaj').val('Sacuvaj');
		});
	});

	$("#listaVrstaTroskova").on('click', '.uredi', function () {
		var id = $(this).attr("id");
		var action = 'detaljiVrsteTroskova';
		$.ajax({
			url: 'vrste_troskova_akcije.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (respData) {
				$("#vrstaTroskaModal").on("shown.bs.modal", function () {
					$('#vrstaTroskaForma')[0].reset();
					respData.data.forEach(function (item) {
						$('#id').val(item['id']);
						$('#ime').val(item['ime']);
						$('#status').val(item['status']);
					});
					$('.modal-title').html('<i class=\"bi bi-plus-circle \"></i> Uredi Vrstu Troska');
					$('#action').val('urediVrstuTroska');
					$('#sacuvaj').val('Sacuvaj');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#vrstaTroskaModal").on('submit', '#vrstaTroskaForma', function (event) {
		event.preventDefault();
		$('#sacuvaj').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "vrste_troskova_akcije.php",
			method: "POST",
			data: formData,
			success: function (data) {
				$('#vrstaTroskaForma')[0].reset();
				$('#vrstaTroskaModal').modal('hide');
				$('#sacuvaj').attr('disabled', false);
				vrste_troskova.ajax.reload();
			}
		})
	});

	$("#listaVrstaTroskova").on('click', '.brisi', function () {
		var id = $(this).attr("id");
		var action = "brisiVrstuTroska";
		if (confirm("Da li stvarno zelite da obrisete ovu vrstu troska?")) {
			$.ajax({
				url: "vrste_troskova_akcije.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					vrste_troskova.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

});