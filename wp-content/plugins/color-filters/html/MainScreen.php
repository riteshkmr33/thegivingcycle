<div class="EWD_UWCF_Menu">
	<h2 class="nav-tab-wrapper">
		<a id="ewd-uwcf-dash-mobile-menu-open" href="#" class="MenuTab nav-tab"><?php _e("MENU", 'color-filters'); ?><span id="ewd-uwcf-dash-mobile-menu-down-caret">&nbsp;&nbsp;&#9660;</span><span id="ewd-uwcf-dash-mobile-menu-up-caret">&nbsp;&nbsp;&#9650;</span></a>
		<a id="Dashboard_Menu" class="MenuTab nav-tab <?php if ($Display_Page == '' or $Display_Page == 'Dashboard') {echo 'nav-tab-active';}?>" onclick="ShowTab('Dashboard');"><?php _e("Dashboard", 'color-filters'); ?></a>
		<?php if ($Enable_Colors == "Yes") { ?><a id="Colors_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Colors') {echo 'nav-tab-active';}?>" onclick="ShowTab('Colors');"><?php _e("Colors", 'color-filters'); ?></a><?php } ?>
		<?php if ($Enable_Sizes == "Yes") { ?><a id="Sizes_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Sizes') {echo 'nav-tab-active';}?>" onclick="ShowTab('Sizes');"><?php _e("Sizes", 'color-filters'); ?></a><?php } ?>
		<a id="Options_Menu" class="MenuTab nav-tab <?php if ($Display_Page == 'Options') {echo 'nav-tab-active';}?>" onclick="ShowTab('Options');"><?php _e("Options", 'color-filters'); ?></a>
	</h2>
</div>
		
<div class="clear"></div>
		
<!-- Add the individual pages to the admin area, and create the active tab based on the selected page -->
<div class="OptionTab <?php if ($Display_Page == "" or $Display_Page == 'Dashboard') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Dashboard">
	<?php include( plugin_dir_path( __FILE__ ) . 'DashboardPage.php'); ?>
</div>
		
<div class="OptionTab <?php if ($Display_Page == 'Colors') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Colors">
	<?php include( plugin_dir_path( __FILE__ ) . 'ColorsPage.php'); ?>
</div>	

<div class="OptionTab <?php if ($Display_Page == 'Sizes') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Sizes">
	<?php include( plugin_dir_path( __FILE__ ) . 'SizesPage.php'); ?>
</div>	

<div class="OptionTab <?php if ($Display_Page == 'Options') {echo 'ActiveTab';} else {echo 'HiddenTab';} ?>" id="Options">
	<?php include( plugin_dir_path( __FILE__ ) . 'OptionsPage.php'); ?>
</div>		