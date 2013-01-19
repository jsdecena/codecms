$(document).ready(function(){

	//SETTINGS PAGE
	$('#change_post_page').click(function(){
		$('#choose_page').removeClass('hidden');
		$(this).parent().parent().addClass('hidden');
		$('#post_page_chosen_label').attr('name', 'post_page');
		$('#choose_page').find("#post_page_chosen").attr('name', 'post_page_chosen');
	});

	$('#cancel_edit').click(function(){
		$('#choose_page').addClass('hidden');
		$('#choose_page_default').removeClass('hidden');		
		$('#post_page_chosen_label').attr('name', 'post_page_chosen');
		$('#choose_page').find("#post_page_chosen").attr('name', 'post_page');
	});
	//END SETTINGS PAGE

	//POST LIST PAGE
	$('#select_all').click(function(){
		$('input[name=delete_selection]').attr('checked', true);
	});

    $('#select_all').click(function () {
    	var delete_selection = $('tbody').find('.delete_selection');
    	$(delete_selection).attr('checked', this.checked);
    });

    //GET SELECTED POSTS/PAGES FOR DELETION	
	$("#delete_selected").click(function(event) {
	 
	  	/* stop form from submitting normally */
	  	event.preventDefault();

		$.each($('input[name="delete_selection[]"]:checked'), function() {

			var selected = $(this).val();

		});
	});


	//CREATE THE PAGE
/*	$('form').submit(function(e) {

		e.preventDefault;
		
	  	console.log($(this).serializeArray());
	  	return false;
	});*/   
 })