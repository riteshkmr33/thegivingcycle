<?php
add_action('woocommerce_after_shop_loop_item', 'EWD_UWCF_WC_Shop_Add_Product_Color_Swatches');
function EWD_UWCF_WC_Shop_Add_Product_Color_Swatches() {
	global $post, $wpdb;

	$Color_Filters_Display = get_option("EWD_UWCF_Color_Filters_Display");
	$Display_Thumbnail_Colors = get_option("EWD_UWCF_Display_Thumbnail_Colors");
	$Size_Filters_Display = get_option("EWD_UWCF_Size_Filters_Display");
	$Display_Thumbnail_Sizes = get_option("EWD_UWCF_Display_Thumbnail_Sizes");
	$Category_Filters_Display = get_option("EWD_UWCF_Category_Filters_Display");
	$Display_Thumbnail_Categories = get_option("EWD_UWCF_Display_Thumbnail_Categories");
	$Tag_Filters_Display = get_option("EWD_UWCF_Tag_Filters_Display");
	$Display_Thumbnail_Tags = get_option("EWD_UWCF_Display_Thumbnail_Tags");

	$Color_Filters_Color_Shape = get_option("EWD_UWCF_Color_Filters_Color_Shape");

	$wc_attribute_table_name = $wpdb->prefix . "woocommerce_attribute_taxonomies";
    $attribute_taxonomies = $wpdb->get_results( "SELECT * FROM $wc_attribute_table_name order by attribute_name ASC;" );

	if ($Display_Thumbnail_Colors == "Yes") {
		$terms = wp_get_post_terms($post->ID, 'product_color');
	
		if (!empty($terms)) {
			echo "<div class='ewd-uwcf-thumbnail-links ewd-uwcf-wc-shop-product-colors'>";
			echo "<div class='ewd-uwcf-shop-product-colors-title'>" . __("Colors", 'color-filters') . "</div>";
			echo "<div class='ewd-uwcf-shop-product-colors-container'>";
			foreach ($terms as $term) {
				$Color = get_term_meta($term->term_id, 'EWD_UWCF_Color', true);
				$Style = ($Color != '' ? apply_filters( 'elm_cf_color_style_attribute', 'style="background: ' . $Color . ';"' ) : '');
	
				echo "<div class='ewd-uwcf-color-wrap'>";
				echo "<a href='" . EWD_UWCF_Build_Term_Link('pa_ewd_uwcf_colors', $term->slug, $Color_Filters_Display) . "''><div class='ewd-uwcf-color-preview " . ($Color_Filters_Color_Shape == "Circle" ? 'ewd-uwcf-rcorners' : '' ) . "' " . $Style . "></div></a>";
				echo "</div>";
			}
			echo "<div class='ewd-uwcf-clear'></div>";
			echo "</div>";
			echo "</div>";
		}
	}

	if ($Display_Thumbnail_Sizes == "Yes") {
		$terms = wp_get_post_terms($post->ID, 'product_size');
	
		if (!empty($terms)) {
			echo "<div class='ewd-uwcf-thumbnail-links ewd-uwcf-wc-shop-product-sizes'>";
			echo "<div class='ewd-uwcf-shop-product-sizes-title'>" . __("Sizes", 'color-filters') . "</div>";
			echo "<div class='ewd-uwcf-shop-product-sizes-container'>";
			foreach ($terms as $term) {
				echo "<div class='ewd-uwcf-size-wrap'>";
				echo "<a href='" . EWD_UWCF_Build_Term_Link('pa_ewd_uwcf_sizes', $term->slug, $Size_Filters_Display) . "'>" . $term->name . "</a>";
				echo "</div>";
			}
			echo "<div class='ewd-uwcf-clear'></div>";
			echo "</div>";
			echo "</div>";
		}
	}

	if ($Display_Thumbnail_Categories == "Yes") {
		$terms = wp_get_post_terms($post->ID, 'product_cat');
	
		if (!empty($terms)) {
			echo "<div class='ewd-uwcf-thumbnail-links ewd-uwcf-wc-shop-product-categories'>";
			echo "<div class='ewd-uwcf-shop-product-categories-title'>" . __("Categories", 'color-filters') . "</div>";
			echo "<div class='ewd-uwcf-shop-product-categories-container'>";
			foreach ($terms as $term) {
				echo "<div class='ewd-uwcf-category-wrap'>";
				echo "<a href='" . EWD_UWCF_Build_Term_Link('product_cat', $term->slug, $Category_Filters_Display) . "'>" . $term->name . "</a>";
				echo "</div>";
			}
			echo "<div class='ewd-uwcf-clear'></div>";
			echo "</div>";
			echo "</div>";
		}
	}

	if ($Display_Thumbnail_Tags == "Yes") {
		$terms = wp_get_post_terms($post->ID, 'product_tag');
	
		if (!empty($terms)) {
			echo "<div class='ewd-uwcf-thumbnail-links ewd-uwcf-wc-shop-product-tags'>";
			echo "<div class='ewd-uwcf-shop-product-tags-title'>" . __("Tags", 'color-filters') . "</div>";
			echo "<div class='ewd-uwcf-shop-product-tags-container'>";
			foreach ($terms as $term) {
				echo "<div class='ewd-uwcf-tag-wrap'>";
				echo "<a href='" . EWD_UWCF_Build_Term_Link('product_tag', $term->slug, $Tag_Filters_Display) . "'>" . $term->name . "</a>";
				echo "</div>";
			}
			echo "<div class='ewd-uwcf-clear'></div>";
			echo "</div>";
			echo "</div>";
		}
	}

	foreach ($attribute_taxonomies as $attribute_taxonomy) {
		if ($attribute_taxonomy->attribute_name == "ewd_uwcf_colors" or $attribute_taxonomy->attribute_name == "ewd_uwcf_sizes") {continue;}

		$Attribute_Display = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Display");;
		$Display_Attribute_Thumbnail_Tags = get_option("EWD_UWCF_" . $attribute_taxonomy->attribute_name . "_Thumbnail_Tags");
		if ($Display_Attribute_Thumbnail_Tags == "Yes") {
			$terms = wp_get_post_terms($post->ID, $attribute_taxonomy->attribute_name);
		
			if (!empty($terms)) {
				echo "<div class='ewd-uwcf-thumbnail-links ewd-uwcf-wc-shop-product-" . $attribute_taxonomy->attribute_name . "'>";
				echo "<div class='ewd-uwcf-shop-product-" . $attribute_taxonomy->attribute_name . "-title'>" . $attribute_taxonomy->attribute_label . "</div>";
				echo "<div class='ewd-uwcf-shop-product-" . $attribute_taxonomy->attribute_name . "-container'>";
				foreach ($terms as $term) {
					echo "<div class='ewd-uwcf-" . $attribute_taxonomy->attribute_name . "-wrap'>";
					echo "<a href='" . EWD_UWCF_Build_Term_Link('pa_' . $attribute_taxonomy->attribute_name, $term->slug, $Attribute_Display) . "'>" . $term->name . "</a>";
					echo "</div>";
				}
				echo "<div class='ewd-uwcf-clear'></div>";
				echo "</div>";
				echo "</div>";
			}
		}
	}
}

function EWD_UWCF_Build_Term_Link($attribute, $attribute_slug, $Display) {
	$Shop_URL = get_permalink(wc_get_page_id('shop')) . "?ewd_uwcf=1";
	foreach ($_GET as $key => $value) {
		if ($key == "ewd_uwcf") {continue;}
		elseif ($key != $attribute) {$Shop_URL .= '&' . $key . '=' . $value;}
		elseif ($Display == "Dropdown") {$Shop_URL .= '&' . $key . '=' . $attribute_slug;}
		/*elseif (strpos($value, $attribute_slug) !== false) {
			if (strpos($value, ",") !== false) {$Shop_URL .= '&' . $key . '=' . str_replace($attribute_slug, '', $value);}
		}
		else {$Shop_URL .= '&' . $key . '=' . $value . "," . $attribute_slug;}*/
	}

	if (strpos($Shop_URL, $attribute) === false) {$Shop_URL .= '&' . $attribute . '=' . $attribute_slug;}

	return $Shop_URL;
}

?>