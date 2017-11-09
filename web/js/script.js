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
			dataType: 'json',
			success: function(response){
                console.log(response);

				$('#result-ajax').html(response);
			}
		});
	});
});
