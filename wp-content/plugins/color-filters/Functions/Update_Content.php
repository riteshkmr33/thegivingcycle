<?php 

function EWD_UWCF_Update_Content() {
	global $ewd_uwcf_message;
	
	if (isset($_GET['UWCF_Action'])) {
		switch ($_GET['UWCF_Action']) {
			case "EWD_UWCF_Add_Color":
				$ewd_uwcf_message = EWD_UWCF_Add_Color();
				break;
			case "EWD_UWCF_Edit_Color":
				$ewd_uwcf_message = EWD_UWCF_Edit_Color();
				break;
			case "EWD_UWCF_Delete_Color":
				$ewd_uwcf_message = EWD_UWCF_Delete_Color($_GET['Color_ID']);
				break;
			case "EWD_UWCF_Mass_Delete_Colors":
				$ewd_uwcf_message = EWD_UWCF_Mass_Delete_Colors();
				break;
			case "EWD_UWCF_Add_Size":
				$ewd_uwcf_message = EWD_UWCF_Add_Size();
				break;
			case "EWD_UWCF_Edit_Size":
				$ewd_uwcf_message = EWD_UWCF_Edit_Size();
				break;
			case "EWD_UWCF_Delete_Size":
				$ewd_uwcf_message = EWD_UWCF_Delete_Size($_GET['Size_ID']);
				break;
			case "EWD_UWCF_Mass_Delete_Sizes":
				$ewd_uwcf_message = EWD_UWCF_Mass_Delete_Sizes();
				break;		
			case "EWD_UWCF_Update_Options":
				$ewd_uwcf_message = EWD_UWCF_Update_Options();
				break;
			default:
				$ewd_uwcf_message = __("The form has not worked correctly. Please contact the plugin developer.", 'color-filters');
				break;
	 	}
	}
}
?>