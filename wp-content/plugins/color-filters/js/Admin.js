function ShowTab(TabName) {
	jQuery(".OptionTab").each(function() {
			jQuery(this).addClass("HiddenTab");
			jQuery(this).removeClass("ActiveTab");
	});
	jQuery("#"+TabName).removeClass("HiddenTab");
	jQuery("#"+TabName).addClass("ActiveTab");
	
	jQuery(".nav-tab").each(function() {
			jQuery(this).removeClass("nav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("nav-tab-active");
}

function ShowOptionTab(TabName) {
	jQuery(".uwcf-option-set").each(function() {
		jQuery(this).addClass("uwcf-hidden");
	});
	jQuery("#"+TabName).removeClass("uwcf-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".uwcf-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".uwcf-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
	jQuery('input[name="Display_Tab"]').val(TabName);
}

jQuery(document).ready(function($) {
	jQuery('.ewd-uwcf-toggle').on('change', function() {
		if ((jQuery(this).val() == "Yes" && jQuery(this).is(':checked')) || (jQuery(this).val() == "No" && !jQuery(this).is(':checked'))) {
			var Type = jQuery(this).data('filtertype');
			jQuery('tr[data-filtertype="' + Type + '"]').removeClass('ewd-uwcf-hidden');
		}
		else {
			var Type = jQuery(this).data('filtertype');
			jQuery('tr[data-filtertype="' + Type + '"]').addClass('ewd-uwcf-hidden');
		}
	});

	jQuery('.ewd-uwcf-admin-option-toggle').on('change', function() {
		var Input_Name = jQuery(this).data('inputname'); console.log(Input_Name);
		if (jQuery(this).is(':checked')) {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', true).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', false);
		}
		else {
			jQuery('input[name="' + Input_Name + '"][value="Yes"]').prop('checked', false).trigger('change');
			jQuery('input[name="' + Input_Name + '"][value="No"]').prop('checked', true);
		}
	})
});

jQuery( document ).ready(function( $ ) {
	if (EWD_UWCF_Colors == undefined) {var EWD_UWCF_Colors = [];}
	
	jQuery(EWD_UWCF_Colors).each(function(index, element) { console.log(element);
		jQuery('#product_color-' + element.term_id + ', #popular-product_color-' + element.term_id).prepend('<div style="width:20px;height:15px;background:' + element.color + ';float: left;margin: 5px 5px 0 0;"></div>');
	});
	var Color_Picker_HTML = '<div class="cf-color-filters ewd-uwcf-pp-color-select-div"><div id="ewd-uwcf-pp-color-picker"><div id="normal_fill_color_picker" class="colorSelector small-text"><div></div></div><input class="cf-color small-text" name="normal_fill" id="normal_fill_color" type="text" size="40" /></div></div>';
	jQuery('#newproduct_color').after(Color_Picker_HTML);
});

jQuery( document ).ready(function( $ ) {
	if ( jQuery().ColorPicker ) {
		jQuery( '.cf-color-filters' ).each( function () {
			var option_id = jQuery( this ).find( '.cf-color' ).attr( 'id' );
			var color = jQuery( this ).find( '.cf-color' ).val();
			var picker_id = option_id += '_picker';

			jQuery( '#' + picker_id ).children( 'div' ).css( 'backgroundColor', color );
			jQuery( '#' + picker_id ).ColorPicker({
				color: color,
				onShow: function ( colpkr ) {
					jQuery( colpkr ).fadeIn( 200 );
					return false;
				},
				onHide: function ( colpkr ) {
					jQuery( colpkr ).fadeOut( 200 );
					return false;
				},
				onChange: function ( hsb, hex, rgb ) {
					jQuery( '#' + picker_id ).children( 'div' ).css( 'backgroundColor', '#' + hex );
					jQuery( '#' + picker_id ).next( 'input' ).attr( 'value', '#' + hex );
				
				}
			});
		});
	}
});

jQuery(function() {
    jQuery(".wp-list-table.colors-list tbody").sortable({
    	items: '.parent-color',
    	stop: function( event, ui ) {
    		jQuery('.color-list-item').each(function(index, el) {
    			if (jQuery(this).data('parent') != 0) {jQuery(this).insertAfter('#color-item-' + jQuery(this).data('parent'));}
    		});
    		saveColorOrderClick();
    	}
    }).disableSelection();
});

function saveColorOrderClick() {
    // ----- Retrieve the li items inside our sortable list
    var items = jQuery(".wp-list-table.colors-list tbody tr");

    var linkIDs = [items.size()];
    var index = 0;

    // ----- Iterate through each li, extracting the ID embedded as an attribute
    items.each(
        function(intIndex) {
            linkIDs[intIndex] = jQuery(this).attr("id").substring(11);
            jQuery(this).find('.menu_order').html(intIndex);
            index++;
        });

    var data = 'IDs=' + JSON.stringify(linkIDs) + '&action=ewd_uwcf_update_size_order'; console.log(data);
    jQuery.post(ajaxurl, data, function(response) {console.log(response);});

    //$get("<%=txtExampleItemsOrder.ClientID %>").value = linkIDs.join(",");
}

jQuery(function() {
    jQuery(".wp-list-table.sizes-list tbody").sortable({
    	items: '.parent-size',
    	stop: function( event, ui ) {
    		jQuery('.size-list-item').each(function(index, el) {
    			if (jQuery(this).data('parent') != 0) {jQuery(this).insertAfter('#size-item-' + jQuery(this).data('parent'));}
    		});
    		saveSizeOrderClick();
    	}
    }).disableSelection();
});

function saveSizeOrderClick() {
    // ----- Retrieve the li items inside our sortable list
    var items = jQuery(".wp-list-table.sizes-list tbody tr");

    var linkIDs = [items.size()];
    var index = 0;

    // ----- Iterate through each li, extracting the ID embedded as an attribute
    items.each(
        function(intIndex) {
            linkIDs[intIndex] = jQuery(this).attr("id").substring(10);
            jQuery(this).find('.menu_order').html(intIndex);
            index++;
        });

    var data = 'IDs=' + JSON.stringify(linkIDs) + '&action=ewd_uwcf_update_size_order'; console.log(data);
    jQuery.post(ajaxurl, data, function(response) {console.log(response);});

    //$get("<%=txtExampleItemsOrder.ClientID %>").value = linkIDs.join(",");
}

jQuery(document).ready(function($) {
	jQuery('a[href="edit-tags.php?taxonomy=pa_ewd_uwcf_colors&post_type=product"], a[href="edit-tags.php?taxonomy=pa_ewd_uwcf_sizes&post_type=product"]').parent().parent().css('display', 'none');
	jQuery('.woocommerce_attribute[data-taxonomy="pa_ewd_uwcf_colors"], .woocommerce_attribute[data-taxonomy="pa_ewd_uwcf_sizes"]').css('display', 'none');
	jQuery('select.attribute_taxonomy option[value="pa_ewd_uwcf_colors"], select.attribute_taxonomy option[value="pa_ewd_uwcf_sizes"]').css('display', 'none');
});

jQuery( document ).ready(function( $ ) {
	var custom_uploader;
 
    jQuery('#Color_Image_Button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: false
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('#Color_Image').val(attachment.url);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
});

//NEW DASHBOARD MOBILE MENU AND WIDGET TOGGLING
jQuery(document).ready(function($){
	$('#ewd-uwcf-dash-mobile-menu-open').click(function(){
		$('.EWD_UWCF_Menu .nav-tab:nth-of-type(1n+2)').toggle();
		$('#ewd-uwcf-dash-mobile-menu-up-caret').toggle();
		$('#ewd-uwcf-dash-mobile-menu-down-caret').toggle();
		return false;
	});
	$(function(){
		$(window).resize(function(){
			if($(window).width() > 785){
				$('.EWD_UWCF_Menu .nav-tab:nth-of-type(1n+2)').show();
			}
			else{
				$('.EWD_UWCF_Menu .nav-tab:nth-of-type(1n+2)').hide();
				$('#ewd-uwcf-dash-mobile-menu-up-caret').hide();
				$('#ewd-uwcf-dash-mobile-menu-down-caret').show();
			}
		}).resize();
	});	
	$('#ewd-uwcf-dashboard-support-widget-box .ewd-uwcf-dashboard-new-widget-box-top').click(function(){
		$('#ewd-uwcf-dashboard-support-widget-box .ewd-uwcf-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-uwcf-dash-mobile-support-up-caret').toggle();
		$('#ewd-uwcf-dash-mobile-support-down-caret').toggle();
	});
	$('#ewd-uwcf-dashboard-optional-table .ewd-uwcf-dashboard-new-widget-box-top').click(function(){
		$('#ewd-uwcf-dashboard-optional-table .ewd-uwcf-dashboard-new-widget-box-bottom').toggle();
		$('#ewd-uwcf-dash-optional-table-up-caret').toggle();
		$('#ewd-uwcf-dash-optional-table-down-caret').toggle();
	});
});


//REVIEW ASK POP-UP
jQuery(document).ready(function() {
    jQuery('.ewd-uwcf-hide-review-ask').on('click', function() {
        var Ask_Review_Date = jQuery(this).data('askreviewdelay');

        jQuery('.ewd-uwcf-review-ask-popup, #ewd-uwcf-review-ask-overlay').addClass('uwcf-hidden');

        var data = 'Ask_Review_Date=' + Ask_Review_Date + '&action=ewd_uwcf_hide_review_ask';
        jQuery.post(ajaxurl, data, function() {});
    });
    jQuery('#ewd-uwcf-review-ask-overlay').on('click', function() {
    	jQuery('.ewd-uwcf-review-ask-popup, #ewd-uwcf-review-ask-overlay').addClass('uwcf-hidden');
    })
});


