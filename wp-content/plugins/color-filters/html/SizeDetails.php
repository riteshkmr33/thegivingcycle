<?php $term = get_term($_GET['Size_ID'], 'product_size'); ?>

<div id="col-right">
	<div class="col-wrap">
		<div id="add-page" class="postbox metabox-holder" >
			<div class="handlediv" title="Click to toggle"><br /></div>
			<h3 class='hndle'><span><?php echo __("Products With ", 'color-filters') . $term->name; ?></span></h3>
			<div class="inside">
				<div id="posttype-page" class="posttypediv">
					<div id="tabs-panel-posttype-page-most-recent" class="tabs-panel tabs-panel-active">
						<table class="wp-list-table striped widefat tags sorttable category-products-list">
				    		<thead>
				    			<tr>
				        		    <th><?php _e("Product Name", 'color-filters') ?></th>
				    			</tr>
				    		</thead>
				    		<tbody>
				    			<?php 
				    				$Products = get_posts(array(
    								    'posts_per_page' => -1,
    								    'post_type' => 'product',
    								    'tax_query' => array(
    								        array(
    								            'taxonomy' => 'product_size',
    								            'field' => 'term_id',
    								            'terms' => $term->term_id,
    								        )
    								    )
    								));
								if (empty($Products)) { echo "<div class='product-category-row list-item'><p>No products currently in size<p/></div>"; }
								else {
				    				foreach ($Products as $Product) {
				    					echo "<tr id='category-product-item-" . $Product->ID . "' class='category-product-item'>";
				    				    echo "<td class='product-name'>";
				    				    echo "<a href='admin.php?post.php?post=" . $Product->ID . "&action=edit'>" . $Product->post_title . "</a>";
				    				    echo "</td>";
				    					echo "</tr>";
				    				}
								}?>
				    		</tbody>
				    		<tfoot>
				    		    <tr>
				    		        <th><?php _e("Product Name", 'color-filters') ?></th>
				    		    </tr>
				    		</tfoot>
						</table>
					</div><!-- /.tabs-panel -->
				</div><!-- /.posttypediv -->
			</div>
		</div>
	</div>
</div><!-- col-right -->

<!-- Form to create a new category -->
<div id="col-left">
	<div class="col-wrap">
		<div class="form-wrap">
			<h3><?php _e("Edit") ?> <?php echo $term->name; ?></h3>
			<form id="addcat" method="post" action="admin.php?page=EWD-UWCF-options&UWCF_Action=EWD_UWCF_Edit_Size&DisplayPage=Sizes" class="validate">
				<input type="hidden" name="action" value="Edit_Size" />
				<input type="hidden" name="term_id" value="<?php echo $term->term_id; ?>" />
				<?php wp_nonce_field('EWD_UWCF_Nonce_Field', 'EWD_UWCF_Nonce_Field'); ?>
				<?php wp_referer_field(); ?>
				<div class="form-field form-required">
					<label for="Size_Name"><?php _e("Name", 'color-filters') ?></label>
					<input name="Size_Name" id="Size_Name" type="text" value="<?php echo $term->name; ?>" size="60" />
					<p><?php _e( 'The name is how it appears on your site.' ); ?></p>
				</div>
				<div class="form-field form-required">
					<label for="Size_Slug"><?php _e("Slug", 'color-filters') ?></label>
					<input name="Size_Slug" id="Size_Slug" type="text" value="<?php echo $term->slug; ?>" size="60" />
					<p><?php _e( 'The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.' ); ?></p>
				</div>
				<div class="form-field term-parent-wrap">
					<label for="parent"><?php echo esc_html( $tax->labels->parent_item ); ?></label>
					<?php
					$dropdown_args = array(
						'hide_empty'       => 0,
						'hide_if_empty'    => false,
						'taxonomy'         => 'product_size',
						'name'             => 'parent',
						'orderby'          => 'name',
						'selected'         => $term->parent,
						'exclude_tree'     => $term->term_id,
						'hierarchical'     => true,
						'show_option_none' => __( 'None' ),
					);
					$dropdown_args = apply_filters( 'taxonomy_parent_dropdown_args', $dropdown_args, $taxonomy, 'edit' );
					wp_dropdown_categories( $dropdown_args );
					?>
					<p><?php _e( 'Assign a parent term to create a hierarchy. For example, a parent could be "Pant Sizes" with children being "24", "26", etc.' ); ?></p>
				</div>
				<div class="form-field">
					<label for="Size_Description"><?php _e("Description", 'color-filters') ?></label>
					<textarea name="Size_Description" id="Size_Description" rows="5" cols="40" value="<?php echo $term->description; ?>"></textarea>
					<p><?php _e("The description of the category. What will it be used to display?", 'color-filters') ?></p>
				</div>
	
				<p class="submit"><input type="submit" class="button-primary" value="<?php _e('Edit Size', 'color-filters') ?>"  /></p>
			</form>
		</div>
		<br class="clear" />
	</div>
</div>