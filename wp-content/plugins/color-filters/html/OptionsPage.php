<?php
	//$Custom_CSS = get_option("EWD_OTP_Custom_CSS");
	$Enable_Colors = get_option("EWD_UWCF_Enable_Colors");
	$Color_Filters_Display = get_option("EWD_UWCF_Color_Filters_Display");
	$Color_Filters_Show_Text = get_option("EWD_UWCF_Color_Filters_Show_Text");
	$Color_Filters_Show_Color = get_option("EWD_UWCF_Color_Filters_Show_Color");
	$Color_Filters_Hide_Empty = get_option("EWD_UWCF_Color_Filters_Hide_Empty");
	$Color_Filters_Show_Product_Count = get_option("EWD_UWCF_Color_Filters_Show_Product_Count");
	$Display_Thumbnail_Colors = get_option("EWD_UWCF_Display_Thumbnail_Colors");
	$Colors_Product_Page_Display = get_option("EWD_UWCF_Colors_Product_Page_Display");
	$Colors_Used_For_Variations = get_option("EWD_UWCF_Colors_Used_For_Variations");

	$Enable_Sizes = get_option("EWD_UWCF_Enable_Sizes");
	$Size_Filters_Display = get_option("EWD_UWCF_Size_Filters_Display");
	$Size_Filters_Show_Text = get_option("EWD_UWCF_Size_Filters_Show_Text");
	$Size_Filters_Hide_Empty = get_option("EWD_UWCF_Size_Filters_Hide_Empty");
	$Size_Filters_Show_Product_Count = get_option("EWD_UWCF_Size_Filters_Show_Product_Count");
	$Display_Thumbnail_Sizes = get_option("EWD_UWCF_Display_Thumbnail_Sizes");
	$Sizes_Product_Page_Display = get_option("EWD_UWCF_Sizes_Product_Page_Display");
	$Sizes_Used_For_Variations = get_option("EWD_UWCF_Sizes_Used_For_Variations");

	$Enable_Categories = get_option("EWD_UWCF_Enable_Categories");
	$Category_Filters_Display = get_option("EWD_UWCF_Category_Filters_Display");
	$Category_Filters_Show_Text = get_option("EWD_UWCF_Category_Filters_Show_Text");
	$Category_Filters_Hide_Empty = get_option("EWD_UWCF_Category_Filters_Hide_Empty");
	$Category_Filters_Show_Product_Count = get_option("EWD_UWCF_Category_Filters_Show_Product_Count");
	$Display_Thumbnail_Categories = get_option("EWD_UWCF_Display_Thumbnail_Categories");

	$Enable_Tags = get_option("EWD_UWCF_Enable_Tags");
	$Tag_Filters_Display = get_option("EWD_UWCF_Tag_Filters_Display");
	$Tag_Filters_Show_Text = get_option("EWD_UWCF_Tag_Filters_Show_Text");
	$Tag_Filters_Hide_Empty = get_option("EWD_UWCF_Tag_Filters_Hide_Empty");
	$Tag_Filters_Show_Product_Count = get_option("EWD_UWCF_Tag_Filters_Show_Product_Count");
	$Display_Thumbnail_Tags = get_option("EWD_UWCF_Display_Thumbnail_Tags");

	$Enable_Text_Search = get_option("EWD_UWCF_Enable_Text_Search");
	$Enable_Autocomplete = get_option("EWD_UWCF_Enable_Autocomplete");

	$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM $wc_attribute_table_name order by attribute_name ASC;" );

    foreach ($attribute_taxonomies as $attribute_taxonomy) {
    	if ($attribute_taxonomy->attribute_name == "ewd_uwcf_colors" or $attribute_taxonomy->attribute_name == "ewd_uwcf_sizes") {continue;}
    	$Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Enabled");
    	$Attribute_Options[$attribute_taxonomy->attribute_name]['Display'] = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Display");
    	$Attribute_Options[$attribute_taxonomy->attribute_name]['Show_Text'] = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Show_Text");
    	$Attribute_Options[$attribute_taxonomy->attribute_name]['Hide_Empty'] = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Hide_Empty");
    	$Attribute_Options[$attribute_taxonomy->attribute_name]['Product_Count'] = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Product_Count");
    	$Attribute_Options[$attribute_taxonomy->attribute_name]['Thumbnail_Tags'] = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Thumbnail_Tags");
    }

	$Access_Role = get_option("EWD_UWCF_Access_Role");

	$Color_Filters_Label = get_option("EWD_UWCF_Color_Filters_Label");
	
	$Color_Filters_Color_Shape = get_option("EWD_UWCF_Color_Filters_Color_Shape");

	if (isset($_POST['Display_Tab'])) {$Display_Tab = $_POST['Display_Tab'];}
	else {$Display_Tab = "";}
?>

<div class="wrap uwcf-options-page-tabbed">
<div class="uwcf-options-submenu-div">
	<ul class="uwcf-options-submenu uwcf-options-page-tabbed-nav">
		<li><a id="Basic_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == '' or $Display_Tab == 'Basic') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Basic');">Basic</a></li>
		<!-- <li><a id="Premium_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Premium') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Premium');">Premium</a></li> -->
		<li><a id="Labelling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Labelling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Labelling');">Labelling</a></li>
		<li><a id="Styling_Menu" class="MenuTab options-subnav-tab <?php if ($Display_Tab == 'Styling') {echo 'options-subnav-tab-active';}?>" onclick="ShowOptionTab('Styling');">Styling</a></li>
	</ul>
</div>

<div class="uwcf-options-page-tabbed-content">

<form method="post" action="admin.php?page=EWD-UWCF-options&DisplayPage=Options&UWCF_Action=EWD_UWCF_Update_Options">
<?php wp_nonce_field('EWD_UWCF_Nonce_Field', 'EWD_UWCF_Nonce_Field'); ?>

<input type='hidden' name='Display_Tab' value='<?php echo $Display_Tab; ?>' />
<div id='Basic' class='uwcf-option-set<?php echo ( ($Display_Tab == '' or $Display_Tab == 'Basic') ? '' : ' uwcf-hidden' ); ?>'>
<h2 id="basic-order-options" class="uwcf-options-tab-title">Basic Options</h2>
<table class="form-table">
<tr>
<th scope="row"><?php _e("Enable Color Filtering", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Color Filtering", 'color-filters'); ?></span></legend>
		<div class="ewd-uwcf-admin-hide-radios">
			<label title='Yes'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Colors' name='enable_colors' value='Yes' <?php if($Enable_Colors == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
			<label title='No'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Colors'  name='enable_colors' value='No' <?php if($Enable_Colors == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		</div>
		<label class="ewd-uwcf-admin-switch">
			<input type="checkbox" class="ewd-uwcf-admin-option-toggle" data-inputname="enable_colors" <?php if($Enable_Colors == "Yes") {echo "checked='checked'";} ?>>
			<span class="ewd-uwcf-admin-switch-slider round"></span>
		</label>		
		<p><?php _e("Should the color filters be displayed when the plugin's widget or shortcode is used?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Text", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Color Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='color_filters_show_text' value='Yes' <?php if($Color_Filters_Show_Text == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='color_filters_show_text' value='No' <?php if($Color_Filters_Show_Text == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a color's name be displayed in the filtering box?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Color", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Color Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='color_filters_show_color' value='Yes' <?php if($Color_Filters_Show_Color == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='color_filters_show_color' value='No' <?php if($Color_Filters_Show_Color == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a color's color swatch be displayed in the filtering box?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Hide Empty", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Color Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='color_filters_hide_empty' value='Yes' <?php if($Color_Filters_Hide_Empty == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='color_filters_hide_empty' value='No' <?php if($Color_Filters_Hide_Empty == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Which colors with no associated products be hidden?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Product Count", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Show Product Count", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='color_filters_show_product_count' value='Yes' <?php if($Color_Filters_Show_Product_Count == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='color_filters_show_product_count' value='No' <?php if($Color_Filters_Show_Product_Count == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should the number of products for each color be displayed?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
</table>
<table class="form-table<?php echo ( ( $EWD_UWCF_Full_Version != 'Yes' or get_option('EWD_UWCF_Trial_Happening') == 'Yes' ) ? ' ewd-uwcf-premium-options-table' : '' ); ?>">
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Color Filter Layout", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Color Filter Layout", 'color-filters'); ?></span></legend>
		<label title='List'><input type='radio' name='color_filters_display' value='List' <?php if($Color_Filters_Display == "List") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("List", 'color-filters')?></span></label><br />
		<label title='Tiles'><input type='radio' name='color_filters_display' value='Tiles' <?php if($Color_Filters_Display == "Tiles") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Tiles", 'color-filters')?></span></label><br />
		<label title='Swatch'><input type='radio' name='color_filters_display' value='Swatch' <?php if($Color_Filters_Display == "Swatch") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Swatch", 'color-filters')?></span></label><br />
		<label title='Checklist'><input type='radio' name='color_filters_display' value='Checklist' <?php if($Color_Filters_Display == "Checklist") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Checklist", 'color-filters')?></span></label><br />
		<label title='Dropdown'><input type='radio' name='color_filters_display' value='Dropdown' <?php if($Color_Filters_Display == "Dropdown") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Dropdown", 'color-filters')?></span></label><br />
		<p><?php _e("Which type of display should be used for filter colors?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Display Thumbnail Colors", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Color Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='display_thumbnail_colors' value='Yes' <?php if($Display_Thumbnail_Colors == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='display_thumbnail_colors' value='No' <?php if($Display_Thumbnail_Colors == "No") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a list of available colors be shown under each product thumbnail on the shop page?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Display on Product Page", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Display on Product Page", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='colors_product_page_display' value='Yes' <?php if($Colors_Product_Page_Display == "Yes") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='colors_product_page_display' value='No' <?php if($Colors_Product_Page_Display == "No") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a product's color, if any, be displayed on the product page?", 'color-filters')?></p>
	</fieldset>
</tr>
<tr data-filtertype='Colors' class='<?php echo ($Enable_Colors != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Use Color for Variations", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Use Color for Variations", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='colors_used_for_variations' value='Yes' <?php if($Colors_Used_For_Variations == "Yes") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='colors_used_for_variations' value='No' <?php if($Colors_Used_For_Variations == "No") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should it be possible to use colors for variations? Save the product for new colors to be shown as options for variations.", 'color-filters')?></p>
	</fieldset>
</tr>
<?php if ($EWD_UWCF_Full_Version != "Yes") { ?>
	<tr data-filtertype='Colors' class='ewd-uwcf-premium-options-table-overlay<?php echo ($Enable_Colors != "Yes" ? " ewd-uwcf-hidden" : ""); ?>'>
		<th colspan="2">
			<div class="ewd-uwcf-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate WooCommerce Filters Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/woocommerce-filters/#buy" class="ewd-uwcf-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
<table class="form-table">
<tr class="ewd-uwcf-admin-tr-spacer"></tr>
<tr>
<th scope="row"><?php _e("Enable Size Filtering", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Size Filtering", 'color-filters'); ?></span></legend>
		<div class="ewd-uwcf-admin-hide-radios">
			<label title='Yes'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Sizes' name='enable_sizes' value='Yes' <?php if($Enable_Sizes == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
			<label title='No'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Sizes' name='enable_sizes' value='No' <?php if($Enable_Sizes == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		</div>
		<label class="ewd-uwcf-admin-switch">
			<input type="checkbox" class="ewd-uwcf-admin-option-toggle" data-inputname="enable_sizes" <?php if($Enable_Sizes == "Yes") {echo "checked='checked'";} ?>>
			<span class="ewd-uwcf-admin-switch-slider round"></span>
		</label>		
		<p><?php _e("Should the size filters be displayed when the plugin's widget or shortcode is used?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Text", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Size Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='size_filters_show_text' value='Yes' <?php if($Size_Filters_Show_Text == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='size_filters_show_text' value='No' <?php if($Size_Filters_Show_Text == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a size's name be displayed in the filtering box?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Hide Empty", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Size Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='size_filters_hide_empty' value='Yes' <?php if($Size_Filters_Hide_Empty == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='size_filters_hide_empty' value='No' <?php if($Size_Filters_Hide_Empty == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Which sizes with no associated products be hidden?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Product Count", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Show Product Count", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='size_filters_show_product_count' value='Yes' <?php if($Size_Filters_Show_Product_Count == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='size_filters_show_product_count' value='No' <?php if($Size_Filters_Show_Product_Count == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should the number of products for each size be displayed?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
</table>
<table class="form-table<?php echo ( ( $EWD_UWCF_Full_Version != 'Yes' or get_option('EWD_UWCF_Trial_Happening') == 'Yes' ) ? ' ewd-uwcf-premium-options-table' : '' ); ?>">
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Size Filter Layout", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Size Filter Layout", 'color-filters'); ?></span></legend>
		<label title='List'><input type='radio' name='size_filters_display' value='List' <?php if($Size_Filters_Display == "List") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("List", 'color-filters')?></span></label><br />
		<label title='Tiles'><input type='radio' name='size_filters_display' value='Tiles' <?php if($Size_Filters_Display == "Tiles") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Tiles", 'color-filters')?></span></label><br />
		<label title='Checklist'><input type='radio' name='size_filters_display' value='Checklist' <?php if($Size_Filters_Display == "Checklist") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Checklist", 'color-filters')?></span></label><br />
		<label title='Dropdown'><input type='radio' name='size_filters_display' value='Dropdown' <?php if($Size_Filters_Display == "Dropdown") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Dropdown", 'color-filters')?></span></label><br />
		<p><?php _e("Which type of display should be used for size filters?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Display Thumbnail Sizes", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Size Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='display_thumbnail_sizes' value='Yes' <?php if($Display_Thumbnail_Sizes == "Yes") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='display_thumbnail_sizes' value='No' <?php if($Display_Thumbnail_Sizes == "No") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a list of available sizes be shown under each product thumbnail on the shop page?", 'color-filters')?></p>
	</fieldset>
</tr>
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Display on Product Page", 'size-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Display on Product Page", 'size-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='sizes_product_page_display' value='Yes' <?php if($Sizes_Product_Page_Display == "Yes") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'size-filters')?></span></label><br />
		<label title='No'><input type='radio' name='sizes_product_page_display' value='No' <?php if($Sizes_Product_Page_Display == "No") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'size-filters')?></span></label><br />
		<p><?php _e("Should a product's size, if any, be displayed on the product page?", 'size-filters')?></p>
	</fieldset>
</tr>
<tr data-filtertype='Sizes' class='<?php echo ($Enable_Sizes != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Use Sizes for Variations", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Use Sizes for Variations", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='sizes_used_for_variations' value='Yes' <?php if($Sizes_Used_For_Variations == "Yes") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='sizes_used_for_variations' value='No' <?php if($Sizes_Used_For_Variations == "No") {echo "checked='checked'";} ?> <?php if($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should it be possible to use sizes for variations? Save the product for new sizes to be shown as options for variations.", 'color-filters')?></p>
	</fieldset>
</tr>
<?php if ($EWD_UWCF_Full_Version != "Yes") { ?>
	<tr data-filtertype='Sizes' class='ewd-uwcf-premium-options-table-overlay<?php echo ($Enable_Sizes != "Yes" ? " ewd-uwcf-hidden" : ""); ?>'>
		<th colspan="2">
			<div class="ewd-uwcf-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate WooCommerce Filters Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/woocommerce-filters/#buy" class="ewd-uwcf-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
<table class="form-table">
<tr class="ewd-uwcf-admin-tr-spacer"></tr>
<tr>
<th scope="row"><?php _e("Enable Category Filtering", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Category Filtering", 'color-filters'); ?></span></legend>
		<div class="ewd-uwcf-admin-hide-radios">
			<label title='Yes'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Categories' name='enable_categories' value='Yes' <?php if($Enable_Categories == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
			<label title='No'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Categories' name='enable_categories' value='No' <?php if($Enable_Categories == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		</div>
		<label class="ewd-uwcf-admin-switch">
			<input type="checkbox" class="ewd-uwcf-admin-option-toggle" data-inputname="enable_categories" <?php if($Enable_Categories == "Yes") {echo "checked='checked'";} ?>>
			<span class="ewd-uwcf-admin-switch-slider round"></span>
		</label>		
		<p><?php _e("Should the category filters be displayed when the plugin's widget or shortcode is used?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Categories' class='<?php echo ($Enable_Categories != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Text", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Category Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='category_filters_show_text' value='Yes' <?php if($Category_Filters_Show_Text == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='category_filters_show_text' value='No' <?php if($Category_Filters_Show_Text == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a category's name be displayed in the filtering box?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Categories' class='<?php echo ($Enable_Categories != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Hide Empty", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Category Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='category_filters_hide_empty' value='Yes' <?php if($Category_Filters_Hide_Empty == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='category_filters_hide_empty' value='No' <?php if($Category_Filters_Hide_Empty == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Which categories with no associated products be hidden?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Categories' class='<?php echo ($Enable_Categories != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Product Count", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Show Product Count", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='category_filters_show_product_count' value='Yes' <?php if($Category_Filters_Show_Product_Count == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='category_filters_show_product_count' value='No' <?php if($Category_Filters_Show_Product_Count == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should the number of products for each category be displayed?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
</table>
<table class="form-table<?php echo ( ( $EWD_UWCF_Full_Version != 'Yes' or get_option('EWD_UWCF_Trial_Happening') == 'Yes' ) ? ' ewd-uwcf-premium-options-table' : '' ); ?>">
<tr data-filtertype='Categories' class='<?php echo ($Enable_Categories != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Category Filter Layout", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Category Filter Layout", 'color-filters'); ?></span></legend>
		<label title='List'><input type='radio' name='category_filters_display' value='List' <?php if($Category_Filters_Display == "List") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("List", 'color-filters')?></span></label><br />
		<label title='Checklist'><input type='radio' name='category_filters_display' value='Checklist' <?php if($Category_Filters_Display == "Checklist") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Checklist", 'color-filters')?></span></label><br />
		<label title='Dropdown'><input type='radio' name='category_filters_display' value='Dropdown' <?php if($Category_Filters_Display == "Dropdown") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Dropdown", 'color-filters')?></span></label><br />
		<p><?php _e("Which type of display should be used for filter categories?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Categories' class='<?php echo ($Enable_Categories != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Display Thumbnail Categories", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Category Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='display_thumbnail_categories' value='Yes' <?php if($Display_Thumbnail_Categories == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='display_thumbnail_categories' value='No' <?php if($Display_Thumbnail_Categories == "No") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a list of available categories be shown under each product thumbnail on the shop page?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_UWCF_Full_Version != "Yes") { ?>
	<tr data-filtertype='Categories' class='ewd-uwcf-premium-options-table-overlay<?php echo ($Enable_Categories != "Yes" ? " ewd-uwcf-hidden" : ""); ?>'>
		<th colspan="2">
			<div class="ewd-uwcf-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate WooCommerce Filters Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/woocommerce-filters/#buy" class="ewd-uwcf-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
<table class="form-table">
<tr class="ewd-uwcf-admin-tr-spacer"></tr>
<tr>
<th scope="row"><?php _e("Enable Tag Filtering", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Tag Filtering", 'color-filters'); ?></span></legend>
		<div class="ewd-uwcf-admin-hide-radios">
			<label title='Yes'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Tags' name='enable_tags' value='Yes' <?php if($Enable_Tags == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
			<label title='No'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='Tags' name='enable_tags' value='No' <?php if($Enable_Tags == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		</div>
		<label class="ewd-uwcf-admin-switch">
			<input type="checkbox" class="ewd-uwcf-admin-option-toggle" data-inputname="enable_tags" <?php if($Enable_Tags == "Yes") {echo "checked='checked'";} ?>>
			<span class="ewd-uwcf-admin-switch-slider round"></span>
		</label>		
		<p><?php _e("Should the tag filters be displayed when the plugin's widget or shortcode is used?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Tags' class='<?php echo ($Enable_Tags != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Text", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='tag_filters_show_text' value='Yes' <?php if($Tag_Filters_Show_Text == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='tag_filters_show_text' value='No' <?php if($Tag_Filters_Show_Text == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a tag's name be displayed in the filtering box?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Tags' class='<?php echo ($Enable_Tags != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Hide Empty", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='tag_filters_hide_empty' value='Yes' <?php if($Tag_Filters_Hide_Empty == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='tag_filters_hide_empty' value='No' <?php if($Tag_Filters_Hide_Empty == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Which tags with no associated products be hidden?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Tags' class='<?php echo ($Enable_Tags != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Product Count", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Show Product Count", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='tag_filters_show_product_count' value='Yes' <?php if($Tag_Filters_Show_Product_Count == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='tag_filters_show_product_count' value='No' <?php if($Tag_Filters_Show_Product_Count == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should the number of products for each tag be displayed?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
</table>
<table class="form-table<?php echo ( ( $EWD_UWCF_Full_Version != 'Yes' or get_option('EWD_UWCF_Trial_Happening') == 'Yes' ) ? ' ewd-uwcf-premium-options-table' : '' ); ?>">
<tr data-filtertype='Tags' class='<?php echo ($Enable_Tags != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Tag Filter Layout", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='List'><input type='radio' name='tag_filters_display' value='List' <?php if($Tag_Filters_Display == "List") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("List", 'color-filters')?></span></label><br />
		<label title='Checklist'><input type='radio' name='tag_filters_display' value='Checklist' <?php if($Tag_Filters_Display == "Checklist") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Checklist", 'color-filters')?></span></label><br />
		<label title='Dropdown'><input type='radio' name='tag_filters_display' value='Dropdown' <?php if($Tag_Filters_Display == "Dropdown") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Dropdown", 'color-filters')?></span></label><br />
		<p><?php _e("Which type of display should be used for filter tags?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='Tags' class='<?php echo ($Enable_Tags != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Display Thumbnail Tags", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='display_thumbnail_tags' value='Yes' <?php if($Display_Thumbnail_Tags == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='display_thumbnail_tags' value='No' <?php if($Display_Thumbnail_Tags == "No") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a list of available tags be shown under each product thumbnail on the shop page?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_UWCF_Full_Version != "Yes") { ?>
	<tr data-filtertype='Tags' class='ewd-uwcf-premium-options-table-overlay<?php echo ($Enable_Tags != "Yes" ? " ewd-uwcf-hidden" : ""); ?>'>
		<th colspan="2">
			<div class="ewd-uwcf-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate WooCommerce Filters Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/woocommerce-filters/#buy" class="ewd-uwcf-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
<div class="ewd-uwcf-admin-section-heading"><?php _e("Text Search Options", 'color-filters'); ?></div>
<table class="form-table">
<tr>
<th scope="row"><?php _e("Enable Text Search", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Text Search", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='enable_text_search' value='Yes' <?php if($Enable_Text_Search == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='enable_text_search' value='No' <?php if($Enable_Text_Search == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a text search box be displayed when the plugin's widget or shortcode is used?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr>
<th scope="row"><?php _e("Enable Product Title Autocomplete", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Product Title Autocomplete", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='enable_autocomplete' value='Yes' <?php if($Enable_Autocomplete == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='enable_autocomplete' value='No' <?php if($Enable_Autocomplete == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("If text search is enabled, should a list of matching products be displayed when a user starts typing?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
</table>
<div class="ewd-uwcf-admin-section-heading"><?php _e("Attributes", 'color-filters'); ?></div>
<table class="form-table">
<?php 
	foreach ($attribute_taxonomies as $attribute_taxonomy) {
    	if ($attribute_taxonomy->attribute_name == "ewd_uwcf_colors" or $attribute_taxonomy->attribute_name == "ewd_uwcf_sizes") {continue;}

    	if ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] == "") {$Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] = "No";}
    	if ($Attribute_Options[$attribute_taxonomy->attribute_name]['Display'] == "") {$Attribute_Options[$attribute_taxonomy->attribute_name]['Display'] = "List";}
    	if ($Attribute_Options[$attribute_taxonomy->attribute_name]['Show_Text'] == "") {$Attribute_Options[$attribute_taxonomy->attribute_name]['Show_Text'] = "Yes";}
    	if ($Attribute_Options[$attribute_taxonomy->attribute_name]['Hide_Empty'] == "") {$Attribute_Options[$attribute_taxonomy->attribute_name]['Hide_Empty'] = "No";}
    	if ($Attribute_Options[$attribute_taxonomy->attribute_name]['Product_Count'] == "") {$Attribute_Options[$attribute_taxonomy->attribute_name]['Product_Count'] = "No";}
    	if ($Attribute_Options[$attribute_taxonomy->attribute_name]['Thumbnail_Tags'] == "") {$Attribute_Options[$attribute_taxonomy->attribute_name]['Thumbnail_Tags'] = "No";}
?>
<tr>
<th scope="row"><?php printf(__("Enable %s Filtering", 'color-filters'), $attribute_taxonomy->attribute_label); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Enable Tag Filtering", 'color-filters'); ?></span></legend>
		<div class="ewd-uwcf-admin-hide-radios">
			<label title='Yes'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' name='<?php echo $attribute_taxonomy->attribute_name; ?>_enable' value='Yes' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
			<label title='No'><input type='radio' class='ewd-uwcf-toggle' data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' name='<?php echo $attribute_taxonomy->attribute_name; ?>_enable' value='No' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		</div>
		<label class="ewd-uwcf-admin-switch">
			<input type="checkbox" class="ewd-uwcf-admin-option-toggle" data-inputname="<?php echo $attribute_taxonomy->attribute_name; ?>_enable" <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] == "Yes") {echo "checked='checked'";} ?>>
			<span class="ewd-uwcf-admin-switch-slider round"></span>
		</label>		
		<p><?php _e("Should the $attribute_taxonomy->attribute_label filters be displayed when the plugin's widget or shortcode is used?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' class='<?php echo ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Text", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_show_text' value='Yes' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Show_Text'] == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_show_text' value='No' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Show_Text'] == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should the attribute's name be displayed in the filtering box?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' class='<?php echo ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Hide Empty", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_hide_empty' value='Yes' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Hide_Empty'] == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_hide_empty' value='No' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Hide_Empty'] == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should attributes with no associated products be hidden?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' class='<?php echo ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php _e("Show Product Count", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Show Product Count", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_product_count' value='Yes' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Product_Count'] == "Yes") {echo "checked='checked'";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_product_count' value='No' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Product_Count'] == "No") {echo "checked='checked'";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should the number of products for each attribute be displayed?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
</table>
<table class="form-table<?php echo ( ( $EWD_UWCF_Full_Version != 'Yes' or get_option('EWD_UWCF_Trial_Happening') == 'Yes' ) ? ' ewd-uwcf-premium-options-table' : '' ); ?>">
<tr data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' class='<?php echo ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php echo $attribute_taxonomy->attribute_label . __(" Filter Layout", 'color-filters'); ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='List'><input type='radio' name='tag_filters_display' value='List' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Display'] == "List") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("List", 'color-filters')?></span></label><br />
		<label title='Checklist'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_display' value='Checklist' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Display'] == "Checklist") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Checklist", 'color-filters')?></span></label><br />
		<label title='Dropdown'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_display' value='Dropdown' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Display'] == "Dropdown") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Dropdown", 'color-filters')?></span></label><br />
		<p><?php _e("Which type of display should be used for filter attributes?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<tr data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' class='<?php echo ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] != "Yes" ? "ewd-uwcf-hidden" : ""); ?>'>
<th scope="row"><?php echo __("Display Thumbnail ", 'color-filters') . $attribute_taxonomy->attribute_label; ?></th>
<td>
	<fieldset><legend class="screen-reader-text"><span><?php _e("Tag Filter Layout", 'color-filters'); ?></span></legend>
		<label title='Yes'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_thumbnail_tags' value='Yes' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Thumbnail_Tags'] == "Yes") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Yes", 'color-filters')?></span></label><br />
		<label title='No'><input type='radio' name='<?php echo $attribute_taxonomy->attribute_name; ?>_thumbnail_tags' value='No' <?php if($Attribute_Options[$attribute_taxonomy->attribute_name]['Thumbnail_Tags'] == "No") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("No", 'color-filters')?></span></label><br />
		<p><?php _e("Should a list of available attributes be shown under each product thumbnail on the shop page?", 'color-filters')?></p>
	</fieldset>
</td>
</tr>
<?php if ($EWD_UWCF_Full_Version != "Yes") { ?>
	<tr data-filtertype='attribute_<?php echo $attribute_taxonomy->attribute_name; ?>' class='ewd-uwcf-premium-options-table-overlay<?php echo ($Attribute_Options[$attribute_taxonomy->attribute_name]['Enabled'] != "Yes" ? " ewd-uwcf-hidden" : ""); ?>'>
		<th colspan="2">
			<div class="ewd-uwcf-unlock-premium">
				<img src="<?php echo plugins_url( '../images/options-asset-lock.png', __FILE__ ); ?>" alt="Upgrade to Ultimate WooCommerce Filters Premium">
				<p>Access this section by by upgrading to premium</p>
				<a href="https://www.etoilewebdesign.com/plugins/woocommerce-filters/#buy" class="ewd-uwcf-dashboard-get-premium-widget-button" target="_blank">UPGRADE NOW</a>
			</div>
		</th>
	</tr>
<?php } ?>
</table>
<table class="form-table">
<tr class="ewd-uwcf-admin-tr-spacer"></tr>
<?php } ?>
</tr>
</table>
<div class="ewd-uwcf-admin-section-heading"><?php _e("Other Options", 'color-filters'); ?></div>
<table class="form-table">
<tr>
<th scope="row">Set Access Role</th>
<td>
	<fieldset><legend class="screen-reader-text"><span>Set Access Role</span></legend>
		<label title='Access Role'></label>
		<select name='access_role'>
			<option value="administrator"<?php if($Access_Role == "administrator") {echo " selected=selected";} ?>>Administrator</option>
			<option value="delete_others_pages"<?php if($Access_Role == "delete_others_pages") {echo " selected=selected";} ?>>Editor</option>
			<option value="delete_published_posts"<?php if($Access_Role == "delete_published_posts") {echo " selected=selected";} ?>>Author</option>
			<option value="delete_posts"<?php if($Access_Role == "delete_posts") {echo " selected=selected";} ?>>Contributor</option>
			<option value="read"<?php if($Access_Role == "read") {echo " selected=selected";} ?>>Subscriber</option>
		</select>
		<p>Who should have access to the "WC Filters" admin menu?</p>
	</fieldset>
</td>
</tr>
</table>
</div>

<div id='Premium' class='uwcf-option-set<?php echo ( $Display_Tab == 'Premium' ? '' : ' uwcf-hidden' ); ?>'>
<h2 id="premium-order-options" class="uwcf-options-tab-title">Premium Options</h2>
<table class="form-table">
</table>
</div>

<div id='Labelling' class='uwcf-option-set<?php echo ( $Display_Tab == 'Labelling' ? '' : ' uwcf-hidden' ); ?>'>
	<h2 id="label-order-options" class="uwcf-options-tab-title">Labelling Options</h2>
	<div class="uwcf-label-description"> Replace the default text in the plugin's widgets </div>

	<div id='labelling-view-options' class="uwcf-options-div uwcf-options-flex">
		<!--<div class="uwcf-styling-header">Status Tracking Form</div>-->
		<div class='uwcf-option uwcf-field-input'>
			<?php _e("Color Filters", 'color-filters')?>
			<fieldset>
				<input type='text' name='color_filters_label' value='<?php echo $Color_Filters_Label; ?>' <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?>/>
			</fieldset>
		</div>
	</div>
</div>

<div id='Styling' class='uwcf-option-set<?php echo ( $Display_Tab == 'Styling' ? '' : ' uwcf-hidden' ); ?>'>
	<h2 id="styling-order-options" class="uwcf-options-tab-title">Styling Options</h2>
			<div class="uwcf-label-description"> Apply custom styling to the plugin's widgets </div>
			<div id='styling-view-options' class="uwcf-options-div uwcf-options-flex">

		<div class='uwcf-styling-header'>Color Filter</div>
		<div class='uwcf-option uwcf-field-input'>
			<span><?php _e("Color Filters Color Shape", 'color-filters')?></span>
			<fieldset><legend class="screen-reader-text"><span><?php _e("Color Filters Color Shape", 'color-filters')?></span></legend>
				<label title='Circle'><input type='radio' name='color_filters_color_shape' value='Circle' <?php if($Color_Filters_Color_Shape == "Circle") {echo "checked='checked'";} ?> /> <span><?php _e("Circle", 'color-filters')?></span></label><br />
				<label title='Square'><input type='radio' name='color_filters_color_shape' value='Square' <?php if($Color_Filters_Color_Shape == "Square") {echo "checked='checked'";} ?> <?php if ($EWD_UWCF_Full_Version != "Yes") {echo "disabled";} ?> /> <span><?php _e("Square", 'color-filters')?></span></label><br />
				<p><?php _e("What shape should the filter color previews be?", 'color-filters')?></p>
			</fieldset>
		</div>
		<!--<div class='uwcf-option uwcf-field-input'>
			<div class='uwcf-option-label'>Title Color</div>
			<div class='uwcf-option-input'><input type='text' class='ewd-uwcf-spectrum' name='otp_styling_title_font_color' value='<?php echo $OTP_Styling_Title_Font_Color; ?>' /></div>
		</div>-->
	</div>
</div>

<p class="submit"><input type="submit" name="Options_Submit" id="submit" class="button button-primary" value="Save Changes"  /></p></form>

</div>
</div>
