<div id="col-right">
<div class="col-wrap">


<!-- Display a list of the categories which have already been created -->
<?php wp_nonce_field(); ?>
<?php wp_referer_field(); ?>

<?php
	$args = array( 
		'hide_empty' => false,
		'taxonomy' => 'product_color',
		'orderby' => 'meta_value_num',
		'meta_key' => 'EWD_UWCF_Term_Order'
	);

	$get_terms = get_terms($args);
?>

<form action="admin.php?page=EWD-UWCF-options&UWCF_Action=EWD_UWCF_Mass_Delete_Colors&DisplayPage=Colors" method="post">   
<div class="tablenav top">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'color-filters') ?></option>
						<option value='delete'>Delete</option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="<?php _e('Apply', 'color-filters') ?>"  />
		</div>
</div>

<table class="wp-list-table striped widefat fixed tags colors-list" cellspacing="0">
	<thead>
		<tr>
			<th scope='col' id='cb' class='manage-column column-name check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
				<span><?php _e("Name", 'color-filters') ?></span>
			</th>
			<th scope='col' id='cb' class='manage-column column-color'  style="">
				<span><?php _e("Color", 'color-filters') ?></span>
			</th>
			<th scope='col' id='cb' class='manage-column column-description'  style="">
				<span><?php _e("Description", 'color-filters') ?></span>
			</th>
			<th scope='col' id='cb' class='manage-column column-count'  style="">
				<span><?php _e("Products", 'color-filters') ?></span>
			</th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th scope='col' id='cb' class='manage-column column-name check-column'  style="">
				<input type="checkbox" /></th><th scope='col' id='name' class='manage-column column-name sortable desc'  style="">
				<span><?php _e("Name", 'color-filters') ?></span>
			</th>
			<th scope='col' id='cb' class='manage-column column-color'  style="">
				<span><?php _e("Color", 'color-filters') ?></span>
			</th>
			<th scope='col' id='cb' class='manage-column column-description'  style="">
				<span><?php _e("Description", 'color-filters') ?></span>
			</th>
			<th scope='col' id='cb' class='manage-column column-count'  style="">
				<span><?php _e("Products", 'color-filters') ?></span>
			</th>
		</tr>
	</tfoot>

	<tbody id="the-list" class='list:tag'>
		<?php
			if ($get_terms) { 
	  			foreach ($get_terms as $term) {
					$Color = get_term_meta($term->term_id, 'EWD_UWCF_Color', true);

					echo "<tr id='color-item-" . $term->term_id ."' class='color-list-item " . (!$term->parent ? 'parent-color' : '') . "' data-parent='" . $term->parent . "'>";
					echo "<th scope='row' class='check-column'>";
					echo "<input type='checkbox' name='Colors_Bulk[]' value='" . $term->term_id ."' />";
					echo "</th>";
					echo "<td class='name column-name'>";
					echo "<strong>";
					echo "<a class='row-title' href='admin.php?page=EWD-UWCF-options&UWCF_Action=EWD_UWCF_Color_Details&Color_ID=" . $term->term_id ."' title='Edit " . $term->name . "'>" . ($term->parent ? '&#8212; ' : '') . strip_tags($term->name) . "</a></strong>";
					echo "<br />";
					echo "<div class='row-actions'>";
					/*echo "<span class='edit'>";
					echo "<a href='admin.php?page=EWD-UWCF-options&UWCF_Action=UPCP_Category_Details&Selected=Category&Category_ID=" . $Category->Category_ID ."'>Edit</a>";
		 			echo " | </span>";*/
					echo "<span class='delete'>";
					echo "<a class='delete-tag' href='admin.php?page=EWD-UWCF-options&UWCF_Action=EWD_UWCF_Delete_Color&DisplayPage=Colors&Color_ID=" . $term->term_id ."'>" . __("Delete", 'color-filters') . "</a>";
		 			echo "</span>";
					echo "</div>";
					echo "<div class='hidden' id='inline_" . $term->term_id ."'>";
					echo "<div class='name'>" . ($term->parent ? '- ' : '') . strip_tags($term->name) . "</div>";
					echo "</div>";
					echo "</td>";
					if (strpos($Color, 'http') === false) {echo "<td class='description column-color'><div style='width:25px; height:25px; margin-left:6px; background-color:" . $Color . ";'></div></td>";}
					else {echo "<td class='description column-color'><div style='width:25px; height:25px; margin-left:6px; background:url(\"" . $Color . "\");'></div></td>";}
					echo "<td class='description column-description'>" . strip_tags($term->description) . "</td>";
					echo "<td class='description column-items-count'>" . $term->count . "</td>";
					echo "</tr>";
				}
			}
		?>
	</tbody>
</table>

<div class="tablenav bottom">
		<div class="alignleft actions">
				<select name='action'>
  					<option value='-1' selected='selected'><?php _e("Bulk Actions", 'color-filters') ?></option>
						<option value='delete'><?php _e("Delete", 'color-filters') ?></option>
				</select>
				<input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
		</div>
		<br class="clear" />
</div>
</form>

<br class="clear" />
</div>
</div>

<div id="col-left">
	<div class="col-wrap">
		<div class="form-wrap">
			<h3><?php _e("Add a New Color", 'color-filters') ?></h3>
			<form id="addcat" method="post" action="admin.php?page=EWD-UWCF-options&UWCF_Action=EWD_UWCF_Add_Color&DisplayPage=Colors" class="validate">
				<input type="hidden" name="action" value="Add_Color" />
				<?php wp_nonce_field('EWD_UWCF_Nonce_Field', 'EWD_UWCF_Nonce_Field'); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field form-required">
					<label for="Color_Name"><?php _e("Name", 'color-filters') ?></label>
					<input name="Color_Name" id="Color_Name" type="text" value="" size="60" />
					<p><?php _e( 'The name is how it appears on your site.' ); ?></p>
				</div>
				<div class="form-field form-required">
					<label for="Color_Slug"><?php _e("Slug", 'color-filters') ?></label>
					<input name="Color_Slug" id="Color_Slug" type="text" value="" size="60" />
					<p><?php _e( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.' ); ?></p>
				</div>
				<div class="form-field term-parent-wrap">
					<label for="parent"><?php echo esc_html( $tax->labels->parent_item ); ?></label>
					<?php
					$dropdown_args = array(
						'hide_empty'       => 0,
						'hide_if_empty'    => false,
						'taxonomy'         => 'product_color',
						'name'             => 'parent',
						'orderby'          => 'name',
						'hierarchical'     => true,
						'show_option_none' => __( 'None' ),
					);
					$dropdown_args = apply_filters( 'taxonomy_parent_dropdown_args', $dropdown_args, $taxonomy, 'new' );
					wp_dropdown_categories( $dropdown_args );
					?>
					<p><?php _e( 'Assign a parent term to create a hierarchy. For example, if you have many shades of blue, they could be assigned to a parent color blue.' ); ?></p>
				</div>
				<div class="form-field">
					<label for="Color_Description"><?php _e("Description", 'color-filters') ?></label>
					<textarea name="Color_Description" id="Color_Description" rows="5" cols="40"></textarea>
					<p><?php _e("The description of the category. What will it be used to display?", 'color-filters') ?></p>
				</div>
				<div class="form-field term-color-wrap cf-color-filters">
					<label for="normal_fill_color_picker">Color</label>
					<div>
						<div id="normal_fill_color_picker" class="colorSelector small-text"><div></div></div>		
						<input class="cf-color small-text" name="normal_fill" id="normal_fill_color" type="text" size="40" />
					</div>
					<div class='ewd-uwcf-color-image-upload'>
						<label><?php _e("Or upload an image the color pattern below:", 'color-filter'); ?></label>
						<input id="Color_Image" type="text" size="36" name="Color_Image" value="http://" />
						<input id="Color_Image_Button" class="button" type="button" value="Upload Image" />
					</div>
				</div>
	
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Add New Color', 'color-filters') ?>"  /></p>
			</form>
		</div>
		<br class="clear" />
	</div>
</div>


	<!--<form method="get" action=""><table style="display: none"><tbody id="inlineedit">
		<tr id="inline-edit" class="inline-edit-row" style="display: none"><td colspan="4" class="colspanchange">

			<fieldset><div class="inline-edit-col">
				<h4>Quick Edit</h4>

				<label>
					<span class="title">Name</span>
					<span class="input-text-wrap"><input type="text" name="name" class="ptitle" value="" /></span>
				</label>
					<label>
					<span class="title">Slug</span>
					<span class="input-text-wrap"><input type="text" name="slug" class="ptitle" value="" /></span>
				</label>
				</div></fieldset>
	
		<p class="inline-edit-save submit">
			<a accesskey="c" href="#inline-edit" title="Cancel" class="cancel button-secondary alignleft">Cancel</a>
						<a accesskey="s" href="#inline-edit" title="Update Level" class="save button-primary alignright">Update Level</a>
			<img class="waiting" style="display:none;" src="<?php echo ABSPATH . 'wp-admin/images/wpspin_light.gif'?>" alt="" />
			<span class="error" style="display:none;"></span>
			<input type="hidden" id="_inline_edit" name="_inline_edit" value="fb59c3f3d1" />			<input type="hidden" name="taxonomy" value="wmlevel" />
			<input type="hidden" name="post_type" value="post" />
			<br class="clear" />
		</p>
		</td></tr>
		</tbody></table></form>-->
		
<!--</div>-->
		