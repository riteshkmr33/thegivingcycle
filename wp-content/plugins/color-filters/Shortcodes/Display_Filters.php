<?php
function EWD_UWCF_Display_Filters($atts) {

	$Enable_Colors = get_option("EWD_UWCF_Enable_Colors");
	$Color_Filters_Display = get_option("EWD_UWCF_Color_Filters_Display");
	$Color_Filters_Show_Text = get_option("EWD_UWCF_Color_Filters_Show_Text");
	$Color_Filters_Show_Color = get_option("EWD_UWCF_Color_Filters_Show_Color");
	$Color_Filters_Hide_Empty = get_option("EWD_UWCF_Color_Filters_Hide_Empty");
	$Color_Filters_Show_Product_Count = get_option("EWD_UWCF_Color_Filters_Show_Product_Count");

	$Enable_Sizes = get_option("EWD_UWCF_Enable_Sizes");
	$Size_Filters_Display = get_option("EWD_UWCF_Size_Filters_Display");
	$Size_Filters_Show_Text = get_option("EWD_UWCF_Size_Filters_Show_Text");
	$Size_Filters_Hide_Empty = get_option("EWD_UWCF_Size_Filters_Hide_Empty");
	$Size_Filters_Show_Product_Count = get_option("EWD_UWCF_Size_Filters_Show_Product_Count");

	$Enable_Categories = get_option("EWD_UWCF_Enable_Categories");
	$Category_Filters_Display = get_option("EWD_UWCF_Category_Filters_Display");
	$Category_Filters_Show_Text = get_option("EWD_UWCF_Category_Filters_Show_Text");
	$Category_Filters_Hide_Empty = get_option("EWD_UWCF_Category_Filters_Hide_Empty");
	$Category_Filters_Show_Product_Count = get_option("EWD_UWCF_Category_Filters_Show_Product_Count");

	$Enable_Tags = get_option("EWD_UWCF_Enable_Tags");
	$Tag_Filters_Display = get_option("EWD_UWCF_Tag_Filters_Display");
	$Tag_Filters_Show_Text = get_option("EWD_UWCF_Tag_Filters_Show_Text");
	$Tag_Filters_Hide_Empty = get_option("EWD_UWCF_Tag_Filters_Hide_Empty");
	$Tag_Filters_Show_Product_Count = get_option("EWD_UWCF_Tag_Filters_Show_Product_Count");

	$Enable_Text_Search = get_option("EWD_UWCF_Enable_Text_Search");
	$Enable_Autocomplete = get_option("EWD_UWCF_Enable_Autocomplete");

	$Color_Filters_Color_Shape = get_option("EWD_UWCF_Color_Filters_Color_Shape");

	// Get the attributes passed by the shortcode, and store them in new variables for processing
	extract( shortcode_atts( array(
			'search_string' => ""),
			$atts
		)
	);

	$ReturnString = "<div class='ewd-uwcf-filters'>";
	$ReturnString .= "<form id='ewd-uwcf-filtering-form' data-shopurl='" . get_permalink(wc_get_page_id('shop')) . "'>";


	if ($Enable_Text_Search == "Yes") {
		$ReturnString .= "<div class='ewd-uwcf-text-search'>";
		$ReturnString .= "<input type='text' class='ewd-uwcf-text-search-input " . ($Enable_Autocomplete == "Yes" ? 'ewd-uwcf-text-search-autocomplete' : '') . "' name='ewd-uwcf-text-search-input' placeholder='" . __("Search Products...", 'color-filters') . "' />";
		if ($Enable_Autocomplete != "Yes") {$ReturnString .= "<div class='ewd-uwcf-text-search-submit'>" . __("Search", 'color-filters') . "</div>";}
		$ReturnString .= "</div>";
	}

	$hide_empty = ($Color_Filters_Hide_Empty == "No" ? false : true);
		
	$get_terms = get_terms( 
		apply_filters( 'elm_cf_get_terms_args', array( 
			'hide_empty' => $hide_empty,
			'taxonomy' => 'product_color',
			'orderby' => 'meta_value_num',
			'meta_key' => 'EWD_UWCF_Term_Order'
		)) 
	);
		
	if ($Enable_Colors == "Yes" and $get_terms) {
		if (isset($_GET['pa_ewd_uwcf_colors'])) {$Selected_Colors = explode(",", $_GET['pa_ewd_uwcf_colors']);}
		else {$Selected_Colors = array();}

		$ReturnString .= "<div class='ewd-uwcf-color-filters-wrap ewd-uwcf-style-" . $Color_Filters_Display . "'>";

		if ($Color_Filters_Display == "Dropdown") {
			$CheckboxString = "";
			$ReturnString .= "<select class='ewd-uwcf-color-dropdown'>";
			$ReturnString .= "<option value='-1'>" . __("All Colors", 'color-filters') . "</option>";
		}

		foreach( $get_terms as $term ) { 
			$Color = get_term_meta($term->term_id, 'EWD_UWCF_Color', true);
			if (strpos($Color, 'http') === false) {$Style = ($Color != '' ? apply_filters( 'elm_cf_color_style_attribute', 'style="background: ' . $Color . ';"' ) : '');}
			else {$Style = 'style="background:url(\'' . $Color . '\')";';}

			if ($Color_Filters_Display != "Dropdown") {
				$ReturnString .= "<div class='ewd-uwcf-color-item text-" . $Color_Filters_Show_Text . "'>";
				$ReturnString .= "<input type='checkbox' class='ewd-uwcf-color ewd-uwcf-filtering-checkbox " . ($Color_Filters_Display == "Checklist" ? 'ewd-uwcf-checklist' : '') . "' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Colors) ? 'checked' : '') . " />";

				if ($Color_Filters_Show_Color == "Yes") {
					$ReturnString .= "<div class='ewd-uwcf-color-wrap'>";
					$ReturnString .= "<div class='ewd-uwcf-color-preview " . (in_array($term->slug, $Selected_Colors) ? 'ewd-uwcf-selected' : '') . " " . ($Color_Filters_Color_Shape == "Circle" ? 'ewd-uwcf-rcorners' : '' ) . "' " . $Style . "></div>";
					$ReturnString .= "</div>";
				}

				if ($Color_Filters_Show_Text == "Yes") {
					$ReturnString .= "<div class='ewd-uwcf-color-link " . (in_array($term->slug, $Selected_Colors) ? 'ewd-uwcf-selected' : '') . "'>";
					$ReturnString .= "<span class='ewd-uwcf-color-name'>" . $term->name . "</span> ";
					$ReturnString .= ($Color_Filters_Show_Product_Count == "Yes" ? "(<span class='ewd-uwcf-product-count'>" . $term->count . "</span>)" : "");	
					$ReturnString .= "</div>";
				}

				$ReturnString .= "</div>";

			}
			else {
				$CheckboxString .= "<input type='checkbox' class='ewd-uwcf-color ewd-uwcf-filtering-checkbox' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Colors) ? 'checked' : '') . " />";
				$ReturnString .= "<option value='" . $term->slug . "' " . $Style . " " . (in_array($term->slug, $Selected_Colors) ? 'selected' : '') . ">" . $term->name . ($Color_Filters_Show_Product_Count == "Yes" ? " (" . $term->count . ")" : "") . "</option>";
			}
		}

		if ($Color_Filters_Display == "Dropdown") {
			$ReturnString .= "</select>";
			$ReturnString .= $CheckboxString;
		}

		$ReturnString .= "</div>";

		if ($Color_Filters_Display != "Dropdown") {$ReturnString .= "<div class='ewd-uwcf-color-item ewd-uwcf-all-colors'>" . __("Show All Colors", 'color-filters') . "</div>";}
	}

	$hide_empty = ($Size_Filters_Hide_Empty == "No" ? false : true); $hide_empty = false;

	$get_terms = get_terms( 
		apply_filters( 'elm_cf_get_terms_args', array( 
			'hide_empty' => $hide_empty,
			'taxonomy' => 'product_size',
			'orderby' => 'meta_value_num',
			'meta_key' => 'EWD_UWCF_Term_Order'
		)) 
	);
	
	if ($Enable_Sizes == "Yes" and $get_terms) {
		if (isset($_GET['pa_ewd_uwcf_sizes'])) {$Selected_Sizes = explode(",", $_GET['pa_ewd_uwcf_sizes']);}
		else {$Selected_Sizes = array();}

		$ReturnString .= "<div class='ewd-uwcf-size-filters-wrap ewd-uwcf-style-" . $Size_Filters_Display . "'>";

		if ($Size_Filters_Display == "Dropdown") {
			$CheckboxString = "";
			$ReturnString .= "<select class='ewd-uwcf-size-dropdown'>";
			$ReturnString .= "<option value='-1'>" . __("All Sizes", 'color-filters') . "</option>";
		}

		foreach( $get_terms as $term ) { 
			if ($Size_Filters_Display != "Dropdown") {
				$ReturnString .= "<div class='ewd-uwcf-size-item'>";
	
				$ReturnString .= "<input type='checkbox' class='ewd-uwcf-size ewd-uwcf-filtering-checkbox " . ($Size_Filters_Display == "Checklist" ? 'ewd-uwcf-checklist' : '') . "' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Sizes) ? 'checked' : '') . " />";
	
				$ReturnString .= "<div class='ewd-uwcf-size-link " . (in_array($term->slug, $Selected_Sizes) ? 'ewd-uwcf-selected' : '') . "'>";
				$ReturnString .= "<span class='ewd-uwcf-size-name'>" . $term->name . "</span> ";
				$ReturnString .= ($Size_Filters_Show_Product_Count == "Yes" ? "(<span class='ewd-uwcf-product-count'>" . $term->count . "</span>)" : "");	
				$ReturnString .= "</div>";
	
				$ReturnString .= "</div>";
			}
			else {
				$CheckboxString .= "<input type='checkbox' class='ewd-uwcf-size ewd-uwcf-filtering-checkbox' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Sizes) ? 'checked' : '') . " />";
				$ReturnString .= "<option value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Sizes) ? 'selected' : '') . ">" . $term->name . ($Size_Filters_Show_Product_Count == "Yes" ? " (" . $term->count . ")" : "") . "</option>";
			}
		}

		if ($Size_Filters_Display == "Dropdown") {
			$ReturnString .= "</select>";
			$ReturnString .= $CheckboxString;
		}

		$ReturnString .= "</div>";

		if ($Size_Filters_Display != "Dropdown") {$ReturnString .= "<div class='ewd-uwcf-size-item ewd-uwcf-all-sizes'>" . __("Show All Sizes", 'color-filters') . "</div>";}
	}

	$hide_empty = ($Category_Filters_Hide_Empty == "No" ? false : true); $hide_empty = false;

	$get_terms = get_terms( 
		apply_filters( 'elm_cf_get_terms_args', array( 
			'hide_empty' => $hide_empty,
			'taxonomy' => 'product_cat'
		)) 
	);
	
	if ($Enable_Categories == "Yes" and $get_terms) {
		if (isset($_GET['product_cat'])) {$Selected_Categories = explode(",", $_GET['product_cat']);}
		else {$Selected_Categories = array();}

		$ReturnString .= "<div class='ewd-uwcf-category-filters-wrap ewd-uwcf-style-" . $Category_Filters_Display . "'>";

		if ($Category_Filters_Display == "Dropdown") {
			$CheckboxString = "";
			$ReturnString .= "<select class='ewd-uwcf-category-dropdown'>";
			$ReturnString .= "<option value='-1'>" . __("All Categories", 'color-filters') . "</option>";
		}

		foreach( $get_terms as $term ) {
			if ($Category_Filters_Display != "Dropdown") {
				$ReturnString .= "<div class='ewd-uwcf-category-item'>";
	
				$ReturnString .= "<input type='checkbox' class='ewd-uwcf-category ewd-uwcf-filtering-checkbox " . ($Category_Filters_Display == "Checklist" ? 'ewd-uwcf-checklist' : '') . "' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Categories) ? 'checked' : '') . " />";
	
				$ReturnString .= "<div class='ewd-uwcf-category-link " . (in_array($term->slug, $Selected_Categories) ? 'ewd-uwcf-selected' : '') . "'>";
				$ReturnString .= "<span class='ewd-uwcf-category-name'>" . $term->name . "</span> ";
				$ReturnString .= ($Category_Filters_Show_Product_Count == "Yes" ? "(<span class='ewd-uwcf-product-count'>" . $term->count . "</span>)" : "");	
				$ReturnString .= "</div>";
	
				$ReturnString .= "</div>";
			}
			else {
				$CheckboxString .= "<input type='checkbox' class='ewd-uwcf-category ewd-uwcf-filtering-checkbox' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Categories) ? 'checked' : '') . " />";
				$ReturnString .= "<option value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Categories) ? 'selected' : '') . ">" . $term->name . ($Category_Filters_Show_Product_Count == "Yes" ? " (" . $term->count . ")" : "") . "</option>";
			}
		}

		if ($Category_Filters_Display == "Dropdown") {
			$ReturnString .= "</select>";
			$ReturnString .= $CheckboxString;
		}

		$ReturnString .= "</div>";

		if ($Category_Filters_Display != "Dropdown") {$ReturnString .= "<div class='ewd-uwcf-category-item ewd-uwcf-all-categories'>" . __("Show All Categories", 'color-filters') . "</div>";}
	}

	$hide_empty = ($Tag_Filters_Hide_Empty == "No" ? false : true); $hide_empty = false;

	$get_terms = get_terms( 
		apply_filters( 'elm_cf_get_terms_args', array( 
			'hide_empty' => $hide_empty,
			'taxonomy' => 'product_tag'
		)) 
	);
	
	if ($Enable_Tags == "Yes" and $get_terms) {
		if (isset($_GET['product_tag'])) {$Selected_Tags = explode(",", $_GET['product_tag']);}
		else {$Selected_Tags = array();}

		$ReturnString .= "<div class='ewd-uwcf-tag-filters-wrap ewd-uwcf-style-" . $Tags_Filters_Display . "'>";

		if ($Tag_Filters_Display == "Dropdown") {
			$CheckboxString = "";
			$ReturnString .= "<select class='ewd-uwcf-tag-dropdown'>";
			$ReturnString .= "<option value='-1'>" . __("All Tags", 'color-filters') . "</option>";
		}

		foreach( $get_terms as $term ) {
			if ($Tag_Filters_Display != "Dropdown") {
				$ReturnString .= "<div class='ewd-uwcf-tag-item'>";
	
				$ReturnString .= "<input type='checkbox' class='ewd-uwcf-tag ewd-uwcf-filtering-checkbox " . ($Tags_Filters_Display == "Checklist" ? 'ewd-uwcf-checklist' : '') . "' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Tags) ? 'checked' : '') . " />";
	
				$ReturnString .= "<div class='ewd-uwcf-tag-link " . (in_array($term->slug, $Selected_Tags) ? 'ewd-uwcf-selected' : '') . "'>";
				$ReturnString .= "<span class='ewd-uwcf-tag-name'>" . $term->name . "</span> ";
				$ReturnString .= ($Tags_Filters_Show_Product_Count == "Yes" ? "(<span class='ewd-uwcf-product-count'>" . $term->count . "</span>)" : "");	
				$ReturnString .= "</div>";
	
				$ReturnString .= "</div>";
			}
			else {
				$CheckboxString .= "<input type='checkbox' class='ewd-uwcf-tag ewd-uwcf-filtering-checkbox' value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Tags) ? 'checked' : '') . " />";
				$ReturnString .= "<option value='" . $term->slug . "' " . (in_array($term->slug, $Selected_Tags) ? 'selected' : '') . ">" . $term->name . ($Tag_Filters_Show_Product_Count == "Yes" ? " (" . $term->count . ")" : "") . "</option>";
			}
		}

		if ($Tag_Filters_Display == "Dropdown") {
			$ReturnString .= "</select>";
			$ReturnString .= $CheckboxString;
		}

		$ReturnString .= "</div>";

		if ($Tag_Filters_Display != "Dropdown") {$ReturnString .= "<div class='ewd-uwcf-tag-item ewd-uwcf-all-tags'>" . __("Show All Tags", 'color-filters') . "</div>";}
	}


	$ReturnString .= "</form>";
	$ReturnString .= "</div>";

	return $ReturnString;
}

add_shortcode('ultimate-woocommerce-filters', 'EWD_UWCF_Display_Filters');

?>