

window.addEventListener('load', function(e) {
	document.addEventListener('keydown',pont,false);	
}, false);


function pont(e){
	e.preventDefault();
	
	var pont = document.getElementById('Pont').innerHTML;
	var pnev = document.getElementById('Nev').innerHTML;

	var pq = 'pont=' + pont + '&pnev=' + pnev;
	console.log(pq);
	
	ajax({
		url: 'ajax_info.php',
		method: 'post',
		postdata: pq,
		success: function(xhr, responseText){
			console.log(responseText);
			var pontok =  JSON.parse(responseText);
			//console.log(pontok);
			/*$('#proba').innerHTML = '<ul><li>' +
				responseText +
				'</li></ul>'*/
				
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
		
	});
}