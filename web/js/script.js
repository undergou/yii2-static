$(document).ready(function(){
	$("#rating").click(function(){
		var rate = event.target.getAttribute('value');
		var slug = $('#slug').html();
		$.ajax({
			url:'/ajax/request.html',
			type: 'GET',
			data: {rate: rate,
					slug: slug},
			success: function(response){
				$('#result-ajax').html(response);
			}
		});
	});
});
