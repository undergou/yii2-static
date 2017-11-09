$(document).ready(function(){
	$("#rating").click(function(){
		var rate = event.target.getAttribute('value');
		var slug = $('#slug').html();
		$.ajax({
			url:'rating/create.html',
			type: 'POST',
			data: {rate: rate,
					slug: slug},
			success: function(response){
				$('#result-ajax').html(response);
			}
		});
	});
});
