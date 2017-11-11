$(document).ready(function(){
	$("#rating").click(function(){
		var rate = event.target.getAttribute('value');
		var slug = $('#slug').html();
		var obj = {rate: rate,
            		slug: slug};
		var data = JSON.stringify(obj);
		console.log(data);
		$.ajax({
			url:'/rating/create.html',
			type: 'POST',
			data: data,
            contentType: 'application/json; charset=utf-8',
			dataType: 'json',
			success: function(response){
                var objResponse = JSON.parse(response);
				$('#result-ajax').html('<div class="alert '+objResponse.classStyle+'">'+objResponse.message+'</div>');
			}
		});
	});
});
