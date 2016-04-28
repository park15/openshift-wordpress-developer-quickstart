jQuery(document).ready(function($) {
	// settings tabs
	//When page loads…
	if ( $.isFunction($.fn.wpColorPicker) ) {
		$('.color').wpColorPicker({});
	}	
	
	
	var activetab = $('input#last-tab').val();
	$(".tab_content").hide(); //Hide all content
	if (activetab){
		$("h2.nav-tab-wrapper a[href$='"+activetab+"']").addClass("nav-tab-active").show(); //Activate first tab
		$(".tab_content"+activetab).show(); //Show first tab content
	} else {
		$("h2.nav-tab-wrapper a:first").addClass("nav-tab-active").show(); //Activate first tab
		$(".tab_content:first").show(); //Show first tab content
	}
	
	$('h2.nav-tab-wrapper a').click(function(e) {				
		e.preventDefault();
		jQuery(".chosen-select").chosen({ width: '50%' });
		var tab = $(this).attr('href');
		$( 'h2.nav-tab-wrapper a' ).removeClass( 'nav-tab-active' );
		$(this).addClass( 'nav-tab-active' );
		$(".tab_content").hide();		
		$("#tab_container " + tab).fadeIn(400, function(){
			jQuery(".chosen-select").chosen({ width: '50%' });
		});
		$("input#last-tab").val(tab);	
			
	});
	
	$('#media-items').bind('DOMNodeInserted',function(){
		$('input[value="Insert into Post"]').each(function(){
				$(this).attr('value','Use This Image');
		});
	});

	$('.repeatable-add').click(function() {
		field = $(this).closest('td').find('.custom_repeatable li:last').clone(true);
		fieldLocation = $(this).closest('td').find('.custom_repeatable li:last');
		$('input', field).val('').attr('name', function(index, name) {
			return name.replace(/(\d+)/, function(fullMatch, n) {
				return Number(n) + 1;
			});
		});
		field.insertAfter(fieldLocation, $(this).closest('td'));
		return false;
	});
	
	$('.repeatable-remove').click(function(){
		$(this).parent().remove();
		return false;
	});
	


	jQuery(".chosen-select").chosen();
	
	var showslidertype = jQuery(".chosen-select[name='thm_settings[thm_slider-type]']").val();
	$('#slider-type-'+showslidertype).show();
	
	$(".chosen-select[name='thm_settings[thm_slider-type]']").chosen().change(function() {
		showslidertype = jQuery(this).val();
  	 	$('.slider-type').fadeOut();
   		$('#slider-type-'+showslidertype).fadeIn();
   		
	});
	
	var showslidertype = jQuery(".chosen-select[name='_essential_slider_settings[slider-type]']").val();
	$('#slider-type-'+showslidertype).show();
	
	$(".chosen-select[name='_essential_slider_settings[slider-type]']").chosen().change(function() {
		showslidertype = jQuery(this).val();
  	 	$('table.slider-type').fadeOut();
   		$('#slider-type-'+showslidertype).fadeIn();
   		
	});
	
	var customcolors = jQuery(".chosen-select[name='thm_settings[thm_site-style]']").val();
	if (customcolors == 'custom' ){
			$('#custom-colors').fadeIn();	
		} else { 
			$('#custom-colors').fadeOut();	
		}
	
	$(".chosen-select[name='thm_settings[thm_site-style]']").chosen().change(function() {
		customcolors = jQuery(this).val();
		
		if (customcolors == 'custom' ){
			$('#custom-colors').fadeIn();	
		} else { 
			$('#custom-colors').fadeOut();	
		}
  	 	
   		
   		
	});
	
	if ($("input[name='thm_settings[thm_body-pattern]']:checked").val() == 'custom'  ){
			$('tr.thm_custom-pattern').fadeIn();	
	} 
	
	$("input[name='thm_settings[thm_body-pattern]']").change(function() {
		pattern = jQuery(this).val();
		
		if (pattern == 'custom' ){
			$('tr.thm_custom-pattern').fadeIn();	
		} else { 
			$('tr.thm_custom-pattern').fadeOut();	
		}
	});
	
	
		$('input[type="checkbox"].use_slider ').live('click',function(){
			if($(this).is(":checked") && (!$(' input[type="checkbox"].def_slider').is(":checked")) ){
		        $('.hidden-container').fadeIn();
		    }else{
		        $('.hidden-container').fadeOut();   
		    }
		});
		$(' input[type="checkbox"].def_slider').live('click',function(){
			if(!$(' input[type="checkbox"].use_slider').is(":checked")){
				$('.hidden-container').fadeOut();
			} else if($(this).is(":checked") && $('input[type="checkbox"].use_slider').is(":checked")){
				$('.hidden-container').fadeOut();
		    } else if(!$(this).is(":checked") && $(' input[type="checkbox"].use_slider').is(":checked")){
		        $('.hidden-container').fadeIn();   
		    } else{
		        $('.hidden-container').fadeIn();   
		    }
		});
		
		
		if ($('input[name="thm_settings[thm_home-tabs]"]').is(":checked")){
			$('tr.thm_active-tab').show();
		}
		$('input[name="thm_settings[thm_home-tabs]"]').on('click',function(){
			if($(this).is(":checked")){
				$('tr.thm_active-tab').show();
			} else {
				$('tr.thm_active-tab').hide();
			}
		});
		
	 jQuery("ul.ui-sortable").sortable({
        cursor: 'move',
        update: function(event, ui) {
        			$(this).next().val($(this).sortable('toArray').toString());
        	
        	      }
    });
    
    var paternbg = jQuery("input[name='thm_settings[thm_body-color-bg]']").val();
    
    jQuery('.thm_body-pattern td label').css('background-color','#'+paternbg);
    
    jQuery("input[name='thm_settings[thm_body-color-bg]']").live('change' , function(){
    	jQuery('.thm_body-pattern td label').css('background-color','#'+jQuery(this).val());
    });
    $("#reset").submit(function(e){
    if (!confirm("Are you sure that you eant to reset all setings?"))
    {
        e.preventDefault();
        return;
    } 
});
    

});

