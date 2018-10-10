jQuery(document).ready(function($) {
	Reload_Page_With_Filters();
	Add_Color_Click_Handlers();
	Add_Size_Click_Handlers();
	Add_Category_Click_Handlers();
	Add_Tag_Click_Handlers();
	Add_Product_Search_Handlers();
});

function Reload_Page_With_Filters() {
	jQuery('#ewd-uwcf-filtering-form').on('change', function() {
		var URL = jQuery(this).data('shopurl') + '?';

		var Connector = '';

		var Colors = '';
		jQuery('.ewd-uwcf-color').each(function(index, el) {
			if (jQuery(this).is(':checked')) {Colors += jQuery(this).val() + ',';}
		});
		if (Colors != '') {URL += Connector + 'pa_ewd_uwcf_colors=' + Colors.slice(0,-1); Connector = '&'}

		var Sizes = '';
		jQuery('.ewd-uwcf-size').each(function(index, el) {
			if (jQuery(this).is(':checked')) {Sizes += jQuery(this).val() + ',';}
		});
		if (Sizes != '') {URL += Connector + 'pa_ewd_uwcf_sizes=' + Sizes.slice(0,-1); Connector = '&'}

		var Categories = '';
		jQuery('.ewd-uwcf-category').each(function(index, el) {
			if (jQuery(this).is(':checked')) {Categories += jQuery(this).val() + ',';}
		});
		if (Categories != '') {URL += Connector + 'product_cat=' + Categories.slice(0,-1); Connector = '&'}

		var Tags = '';
		jQuery('.ewd-uwcf-tag').each(function(index, el) {
			if (jQuery(this).is(':checked')) {Tags += jQuery(this).val() + ',';}
		});
		if (Tags != '') {URL += Connector + 'product_tag=' + Tags.slice(0,-1); Connector = '&'}

		var Search_String = '';
		if (jQuery('.ewd-uwcf-text-search-input').val() != '' && jQuery('.ewd-uwcf-text-search-input').val() != undefined) {Search_String = jQuery('.ewd-uwcf-text-search-input').val();}
		if (Search_String != '') {URL += Connector + 's=' + Search_String; Connector = '&'}

		window.location.href = URL;
	});
}

function Add_Color_Click_Handlers() {
	jQuery('.ewd-uwcf-color-link, .ewd-uwcf-color-wrap').on('click', function() {
		var Checkbox = jQuery(this).parent().find('.ewd-uwcf-filtering-checkbox');
		if (Checkbox.is(':checked')) {Checkbox.prop('checked', false).trigger('change');}
		else {Checkbox.prop('checked', true).trigger('change');}
	});

	jQuery('.ewd-uwcf-all-colors').on('click', function() {jQuery('.ewd-uwcf-color').prop('checked', false).trigger('change');});

	jQuery('.ewd-uwcf-color-dropdown').css('background', jQuery('.ewd-uwcf-color-dropdown option[selected]').css('background'));
	jQuery('.ewd-uwcf-color-dropdown').on('change', function() {
		jQuery('.ewd-uwcf-color').prop('checked', false);
		jQuery('.ewd-uwcf-color[value="' + jQuery(this).val() + '"]').prop('checked', true);
	});
}

function Add_Size_Click_Handlers() {
	jQuery('.ewd-uwcf-size-link').on('click', function() {
		var Checkbox = jQuery(this).parent().find('.ewd-uwcf-filtering-checkbox');
		if (Checkbox.is(':checked')) {Checkbox.prop('checked', false).trigger('change');}
		else {Checkbox.prop('checked', true).trigger('change');}
	});

	jQuery('.ewd-uwcf-all-sizes').on('click', function() {jQuery('.ewd-uwcf-size').prop('checked', false).trigger('change');});

	jQuery('.ewd-uwcf-size-dropdown').on('change', function() {
		jQuery('.ewd-uwcf-size').prop('checked', false);
		jQuery('.ewd-uwcf-size[value="' + jQuery(this).val() + '"]').prop('checked', true);
	});
}

function Add_Category_Click_Handlers() {
	jQuery('.ewd-uwcf-category-link').on('click', function() {
		var Checkbox = jQuery(this).parent().find('.ewd-uwcf-filtering-checkbox');
		if (Checkbox.is(':checked')) {Checkbox.prop('checked', false).trigger('change');}
		else {Checkbox.prop('checked', true).trigger('change');}
	});

	jQuery('.ewd-uwcf-all-categories').on('click', function() {jQuery('.ewd-uwcf-category').prop('checked', false).trigger('change');});

	jQuery('.ewd-uwcf-category-dropdown').on('change', function() {
		jQuery('.ewd-uwcf-category').prop('checked', false);
		jQuery('.ewd-uwcf-category[value="' + jQuery(this).val() + '"]').prop('checked', true);
	});
}

function Add_Tag_Click_Handlers() {
	jQuery('.ewd-uwcf-tag-link').on('click', function() {
		var Checkbox = jQuery(this).parent().find('.ewd-uwcf-filtering-checkbox');
		if (Checkbox.is(':checked')) {Checkbox.prop('checked', false).trigger('change');}
		else {Checkbox.prop('checked', true).trigger('change');}
	});

	jQuery('.ewd-uwcf-all-tags').on('click', function() {jQuery('.ewd-uwcf-tag').prop('checked', false).trigger('change');});

	jQuery('.ewd-uwcf-tag-dropdown').on('change', function() {
		jQuery('.ewd-uwcf-tag').prop('checked', false);
		jQuery('.ewd-uwcf-tag[value="' + jQuery(this).val() + '"]').prop('checked', true);
	});
}

function Add_Product_Search_Handlers() {
	jQuery('.ewd-uwcf-text-search-submit').on('click', function() {
		jQuery('#ewd-uwcf-filtering-form').trigger('change');
	});

	if (jQuery('.ewd-uwcf-text-search-autocomplete').length) {
		var Product_Titles = [];

		jQuery(EWD_UWCF_Data.Products).each(function(index, el) {
			Product_Titles.push(el.post_title);
		});
		
		jQuery('.ewd-uwcf-text-search-input').on('keyup', function() {
			jQuery('.ewd-uwcf-text-search-input').autocomplete({
				source: Product_Titles,
				minLength: 3,
				appendTo: "#ewd-ufaq-jquery-ajax-search",
				select: function(event, ui) {
					jQuery(this).val(ui.item.value);
					jQuery('#ewd-uwcf-filtering-form').trigger('change');
				}
			});
			jQuery('#ufaq-ajax-text-input').autocomplete( "enable" );
		}); 
	}
}