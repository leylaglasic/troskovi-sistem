$(document).ready(function(){	

	var korisnici = $('#listaKorisnika').DataTable({
		"lengthChange": false,
		"processing":true,
		"serverSide":true,		
		"bFilter": false,
		'serverMethod': 'post',		
		"order":[],
		"ajax":{
			url:"korisnici_akcije.php",
			type:"POST",
			data:{action:'listaKorisnika'},
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
	
	$('#dodajKorisnika').click(function(){
		$('#korisnikModal').modal({
			backdrop: 'static',
			keyboard: false
		}).toggle();		
		$("#korisnikModal").on("shown.bs.modal", function () {
			$('#korisnikForma')[0].reset();				
			$('.modal-title').html('<i class=\"bi bi-plus-circle \"></i> Dodaj Korisnika');				
			$('#action').val('dodajKorisnika');
			$('#sacuvaj').val('Sacuvaj');
		});
	});		
	
	$("#listaKorisnika").on('click', '.uredi', function(){
		var id = $(this).attr("id");
		var action = 'detaljiKorisnika';
		$.ajax({
			url:'korisnici_akcije.php',
			method:"POST",
			data:{id:id, action:action},
			dataType:"json",
			success:function(respData){				
				$("#korisnikModal").on("shown.bs.modal", function () { 
					$('#korisnikForma')[0].reset();
					respData.data.forEach(function(item){						
						$('#id').val(item['id']);						
						$('#rola').val(item['rola']);	
						$('#ime').val(item['ime']);
						$('#prezime').val(item['prezime']);	
						$('#email').val(item['email']);	
					});														
					$('.modal-title').html("<i class='fa fa-plus'></i> Uredi Korisnika");
					$('#action').val('urediKorisnika');
					$('#sacuvaj').val('Sacuvaj');					
				}).modal({
					backdrop: 'static',
					keyboard: false
				});			
			}
		});
	});
	
	$("#korisnikModal").on('submit','#korisnikForma', function(event){
		event.preventDefault();
		$('#sacuvaj').attr('disabled','disabled');
		var formData = $(this).serialize();
		$.ajax({
			url:"korisnici_akcije.php",
			method:"POST",
			data:formData,
			success:function(data){				
				$('#korisnikForma')[0].reset();
				$('#korisnikModal').modal('hide');				
				$('#sacuvaj').attr('disabled', false);
				korisnici.ajax.reload();
			}
		})
	});		

	$("#listaKorisnika").on('click', '.brisi', function(){
		var id = $(this).attr("id");		
		var action = "brisiKorisnika";
		if(confirm("Da li stvarno zelite da obrisete ovog korisnika?")) {
			$.ajax({
				url:"korisnici_akcije.php",
				method:"POST",
				data:{id:id, action:action},
				success:function(data) {					
					korisnici.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
	
});