$(document).ready(function () {

	var listaPriliva = $('#listaPriliva').DataTable({
		"lengthChange": false,
		"processing": true,
		"serverSide": true,
		"bFilter": false,
		'serverMethod': 'post',
		"order": [],
		"ajax": {
			url: "prilivi_akcije.php",
			type: "POST",
			data: { action: 'listaPriliva' },
			dataType: "json"
		},
		"columnDefs": [
			{
				"targets": [0, 4, 5],
				"orderable": false,
			},
		],
		"pageLength": 10
	});

	$('#dodajPriliv').click(function () {
		$('#prilivModal').modal({
			backdrop: 'static',
			keyboard: false
		}).toggle();
		$("#prilivModal").on("shown.bs.modal", function () {
			$('#prilivForma')[0].reset();
			$('.modal-title').html("<i class='fa fa-plus'></i> Add Income");
			$('#action').val('dodajPriliv');
			$('#sacuvaj').val('Sacuvaj');
		});
	});

	$("#listaPriliva").on('click', '.uredi', function () {
		var id = $(this).attr("id");
		var action = 'detaljiPriliva';
		$.ajax({
			url: 'prilivi_akcije.php',
			method: "POST",
			data: { id: id, action: action },
			dataType: "json",
			success: function (respData) {
				$("#prilivModal").on("shown.bs.modal", function () {
					$('#prilivForma')[0].reset();
					respData.data.forEach(function (item) {
						$('#id').val(item['id']);
						$('#vrsta_priliva_id').val(item['vrsta_priliva_id']);
						$('#iznos').val(item['iznos']);
						$('#datum').val(item['datum']);
					});
					$('.modal-title').html("<i class='fa fa-plus'></i> Edit Income");
					$('#action').val('urediPriliv');
					$('#sacuvaj').val('Sacuvaj');
				}).modal({
					backdrop: 'static',
					keyboard: false
				});
			}
		});
	});

	$("#prilivModal").on('submit', '#prilivForma', function (event) {
		event.preventDefault();
		$('#sacuvaj').attr('disabled', 'disabled');
		var formData = $(this).serialize();
		$.ajax({
			url: "prilivi_akcije.php",
			method: "POST",
			data: formData,
			success: function (data) {
				$('#prilivForma')[0].reset();
				$('#prilivModal').modal('hide');
				$('#sacuvaj').attr('disabled', false);
				listaPriliva.ajax.reload();
			}
		})
	});

	$("#listaPriliva").on('click', '.brisi', function () {
		var id = $(this).attr("id");
		var action = "brisiPriliv";
		if (confirm("Da li stvarno zelite da obrisete ovaj priliv?")) {
			$.ajax({
				url: "prilivi_akcije.php",
				method: "POST",
				data: { id: id, action: action },
				success: function (data) {
					listaPriliva.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});

});