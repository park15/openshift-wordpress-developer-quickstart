jQuery(document).ready(function($){
 
   jQuery('.custom_upload_file_button').click(function() {
		formfield = jQuery(this).siblings('.custom_upload_file_val');
		tb_show('', 'media-upload.php?TB_iframe=true');
		window.send_to_editor = function(html) {
			fileurl = jQuery(html).attr('href');
			formfield.val(fileurl);
			tb_remove();
		};
		return false;
	});

	jQuery('.custom_clear_file_button').click(function() {
		jQuery(this).siblings('.custom_upload_file_val').val('');
		return false;
	});
	
});