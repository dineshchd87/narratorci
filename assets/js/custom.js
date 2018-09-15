$(document).ready(function () {
	$('.manage_page').change(function(){
		var page = $( this ).val();
		var base_url = $( this ).attr('data');
		window.location.href = base_url+page;
	});
})