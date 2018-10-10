<?php
/* Creates the admin page, and fills it in based on whether the user is looking at
*  the overview page or an individual item is being edited */
function EWD_UWCF_Output_Options() {
	global $wpdb, $EWD_UWCF_Full_Version;

	$Enable_Colors = get_option("EWD_UWCF_Enable_Colors");
	$Enable_Sizes = get_option("EWD_UWCF_Enable_Sizes");
	
	if (isset($_GET['DisplayPage'])) {
		  $Display_Page = $_GET['DisplayPage'];
	}
	else { 
		$Display_Page = null;
	}
	if (!isset($_GET['UWCF_Action'])) {
		$_GET['UWCF_Action'] = null;
	}

	include( plugin_dir_path( __FILE__ ) . '../html/AdminHeader.php');
	if ($_GET['UWCF_Action'] == "EWD_UWCF_Color_Details") {include( plugin_dir_path( __FILE__ ) . '../html/ColorDetails.php');}
	elseif ($_GET['UWCF_Action'] == "EWD_UWCF_Size_Details") {include( plugin_dir_path( __FILE__ ) . '../html/SizeDetails.php');}
	else {include( plugin_dir_path( __FILE__ ) . '../html/MainScreen.php');}
	include( plugin_dir_path( __FILE__ ) . '../html/AdminFooter.php');
}
?>