$(document).ready(function () {

	var listaVrstaPriliva = $('#listaVrstaPriliva').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": false,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "vrste_priliva_akcije.php",
			type: "POST",
			data: { action: 'listaVrstaPriliva' },
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

	$('#dodajVrstuPriliva').click(function () {
		$('#vrstaPrilivaModal').modal({
			backdrop: 'static',
			keyboard: false
		}).toggle();
		$("#vrstaPrilivaModal").on("shown.bs.modal", function () {
			$('#vrstaPrilivaForma')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Category");
			$('#action').val('dodajVrstuPriliva');
			$('#sacuvaj').val('Sacuvaj');
		});
	});

	$("#listaVrstaPriliva").on('click', '.uredi', function () {
		var id = $(this).attr("id");
		var action = 'detaljiVrstePriliva';
		$.ajax({
			url: 'vrste_priliva_akcije.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (respData) {
				$("#vrstaPrilivaModal").on("shown.bs.modal", function () {
					$('#vrstaPrilivaForma')[0].reset();
					respData.data.forEach(function (item) {
						$('#id').val(item['id']);
						$('#ime').val(item['ime']);
						$('#status').val(item['status']);
					});
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit category");
					$('#action').val('urediVrstuPriliva');
					$('#sacuvaj').val('Sacuvaj');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#vrstaPrilivaModal").on('submit', '#vrstaPrilivaForma', function (event) {
		event.preventDefault();
		$('#sacuvaj').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "vrste_priliva_akcije.php",
			method: "POST",
			data: formData,
			success: function (data) {
				$('#vrstaPrilivaForma')[0].reset();
				$('#vrstaPrilivaModal').modal('hide');
				$('#sacuvaj').attr('disabled', false);
				listaVrstaPriliva.ajax.reload();
			}
		})
	});

	$("#listaVrstaPriliva").on('click', '.brisi', function () {
		var id = $(this).attr("id");
		var action = "brisiVrstuPriliva";
		if (confirm("Da li stvarno zelite da obriste ovu vrstu priliva?")) {
			$.ajax({
				url: "vrste_priliva_akcije.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					listaVrstaPriliva.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

});