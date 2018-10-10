<?php
/*
Plugin Name: PMPro Customizations
Plugin URI: https://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Customizations for my Paid Memberships Pro Setup
Version: .1
Author: Paid Memberships Pro
Author URI: https://www.paidmembershipspro.com
*/

//Now start placing your customization code below this line

/*
Plugin Name: Register Helper Example
Plugin URI: http://www.paidmembershipspro.com/wp/pmpro-customizations/
Description: Register Helper Initialization Example
Version: .1
Author: Stranger Studios
Author URI: http://www.strangerstudios.com
*/
//we have to put everything in a function called on init, so we are sure Register Helper is loaded
function my_pmprorh_init()
{
	//don't break if Register Helper is not loaded
	if(!function_exists( 'pmprorh_add_registration_field' )) {
		return false;
	}

	//define the fields
	$fields = array();
	$fields[] = new PMProRH_Field(
		'over18',						// input name, will also be used as meta key
		'checkbox',							// type of field
		array(
			'label'		=> 'By checking this box you certify that you are over 18 years of age.'	,		// custom field label
			'profile'	=> true,			// show in user profile
			'required'	=> true,			// make this field required
		)
	);

	//add the fields into a new checkout_boxes area of the checkout page
	foreach($fields as $field)
		pmprorh_add_registration_field(
			'checkout_boxes',				// location on checkout page
			$field						// PMProRH_Field object
		);
	//that's it. see the PMPro Register Helper readme for more information and examples.
}
add_action( 'init', 'my_pmprorh_init' );
