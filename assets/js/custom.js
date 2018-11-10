jQuery(document).ready(function () {
	jQuery('.manage_page').change(function(){
		var page = jQuery( this ).val();
		var base_url =jQuery( this ).attr('data');
		window.location.href = base_url+page;
	});
})