$(document).ready(function(){	

	var expenseRecords = $('#listaTroskova').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"troskovi_akcije.php",
			type:"POST",
			data:{action:'listaTroskova'},
			dataType:"json"
		},
		"columnDefs":[
			{
				"targets":[0, 4, 5],
				"orderable":false,
			},
		],
		"pageLength": 10
	});	
	
	$('#dodajTrosak').click(function(){
		$('#trosakModal').modal({
			backdrop: 'static',
			keyboard: false
		}).toggle();		
		$('#trosakModal').on('shown.bs.modal', function () {
			$('#trosakForma')[0].reset();				
			$('.modal-title').html('<i class=\"bi bi-plus-circle \"></i> Dodaj Trosak');					
			$('#action').val('dodajTrosak');
			$('#snimi').val('Sacuvaj');
		});
	});		
	
	$("#listaTroskova").on('click', '.uredi', function(){
		var id = $(this).attr("id");
		var action = 'detaljiTroska';
		$.ajax({
			url:'troskovi_akcije.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#trosakModal").on("shown.bs.modal", function () { 
					$('#trosakForma')[0].reset();
					respData.data.forEach(function(item){						
						$('#id').val(item['id']);						
						$('#vrsta_troska_id').val(item['vrsta_troska_id']);	
						$('#iznos').val(item['iznos']);
						$('#datum').val(item['datum']);						
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Uredi Trosak");
					$('#action').val('urediTrosak');
					$('#sacuvaj').val('Sacuvaj');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#trosakModal").on('submit','#trosakForma', function(event){
		event.preventDefault();
		$('#sacuvaj').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"troskovi_akcije.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#trosakForma')[0].reset();
				$('#trosakModal').modal('hide');				
				$('#sacuvaj').attr('disabled', false);
				expenseRecords.ajax.reload();
			}
		})
	});		

	$("#listaTroskova").on('click', '.brisi', function(){
		var id = $(this).attr("id");		
		var action = "brisiTrosak";
		if(confirm("Da li stvarno zelite da obrisete ovaj trosak?")) {
			$.ajax({
				url:"troskovi_akcije.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					expenseRecords.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});