$(document).ready(function(){

	//LIVE COPY THE TITLE TO THE URL REWRITE

	$('input[id$=page_title]').on('keyup',function(){
		
		var txtClone = $(this).val().replace(/[^a-zA-Z0-9-_]/g, '-').toLowerCase();

		$('input[id$=page_slug]').val(txtClone);

	});

});