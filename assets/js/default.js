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
 })