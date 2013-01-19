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

    $('#select_all').click(function () {
    	var delete_selection = $('tbody').find('.delete_selection');
    	$(delete_selection).attr('checked', this.checked);
    });

    //GET SELECTED POSTS/PAGES FOR DELETION	
	$("#delete_selection").click(function(event) {

		if(!confirm('Delete selected posts?')) return false;//ask user if they're sure
	 
	  	/* stop form from submitting normally */
	  	event.preventDefault();

  		$.each($('input[name="delete_selection"]:checked'), function() {	

			$.ajax({
			  type: "POST",
			  url: 'post_delete_selection',
			  data: { selected: $(this).val() },
			  success: function(data){				

				setTimeout(function () {
					window.location.href = window.location.href;
				}, 1000);

				$('#ajax_message').show().html('Successfully deleted.');
			  },
			  error: function(data) {

			  		console.log(data);
			  },		  
			});				

		});	
	});   
 })