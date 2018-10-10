		<div class="wrap">
		<div class="Header"><h2><?php _e("Ultimate WooCommerce Filters Settings", 'color-filters') ?></h2></div>

		<?php if ($EWD_UWCF_Full_Version != "Yes" or get_option("EWD_UWCF_Trial_Happening") == "Yes") { ?>
			<div class="ewd-uwcf-dashboard-new-upgrade-banner">
				<div class="ewd-uwcf-dashboard-banner-icon"></div>
				<div class="ewd-uwcf-dashboard-banner-buttons">
					<a class="ewd-uwcf-dashboard-new-upgrade-button" href="http://www.etoilewebdesign.com/plugins/woocommerce-filters/#buy" target="_blank">UPGRADE NOW</a>
				</div>
				<div class="ewd-uwcf-dashboard-banner-text">
					<div class="ewd-uwcf-dashboard-banner-title">
						GET FULL ACCESS WITH OUR PREMIUM VERSION
					</div>
					<div class="ewd-uwcf-dashboard-banner-brief">
						Easily filter your WooCommerce products by color, size, category, tag or any attribute
					</div>
				</div>
			</div>
		<?php }
