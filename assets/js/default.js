$(document).ready(function(){
	$('#change_post_page').click(function(){
		$('#choose_page').removeClass('hidden');
		$(this).parent().parent().addClass('hidden');
		$('#post_page_chosen_label').attr('name', 'post_page');
		$('#choose_page').find("#post_page_chosen").attr('name', 'post_page_chosen');
	});
})