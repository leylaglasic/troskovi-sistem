$(document).ready(function(){	

	$('#izvjestaj').click(function(){
		var odDatum = $('#od_datum').val();
		var doDatum = $('#do_datum').val();
		//console.log("==fromDate=="+fromDate+"==toDate="+toDate);
		var action = 'prikaziIzvjestaj';
		$.ajax({
			url:'izvjestaj_akcije.php',
			method:"POST",
			data:{odDatum:odDatum, doDatum:doDatum, action:action},
			dataType:"json",
			success:function(respData){				
				var izvjestajHTML = '';
				var ukupniTrosak = 0;
				$('#izvjestajTabela').hide();
				$('#bez_izvjestaja').hide();
				respData.troskovi.forEach(function(item){	
					izvjestajHTML+= '<tr>';
					izvjestajHTML+= '<td>$'+item['iznos']+'</td>';
					izvjestajHTML+= '<td>'+item['datum']+'</td>';
					izvjestajHTML+= '<td>'+item['vrsta_troska_ime']+'</td>';	
					izvjestajHTML+= '</tr>';
					ukupniTrosak = ukupniTrosak + parseInt(item['iznos']);
					$('#izvjestajTabela').show();
				});
				$('#listaIzvjestaja').html(izvjestajHTML);
				$('#detalji').hide();
				$('#ukupniPriliv').text("");
				$('#ukupniTrosak').text("");
				$('#ukupnaUsteda').text("");
				respData.prilivi.forEach(function(income){	
					$('#ukupniPrilivi').text("$"+income['total']);
					$('#ukupniTroskovi').text("$"+ukupniTrosak);
					var finalTotal = income['total'] - ukupniTrosak;
					$('#ukupnaUsteda').text("$"+finalTotal);
					$('#detalji').show();
				});
				
				if(!ukupniTrosak) {
					$('#bez_izvjestaja').html("<strong>Izvjestaj nije moguce prikazati!</strong>").show();
				}
			}
		});
	});	

	
	
});