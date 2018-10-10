<?php
// register the location of the plugin templates
function bp_tol_register_template_location() {
	$theme_package_id = bp_get_theme_compat_id();

	if ( file_exists( STYLESHEETPATH."/buddyboss-wall/bp-{$theme_package_id}/" ) ) {
		$templates_dir = STYLESHEETPATH."/buddyboss-wall/bp-{$theme_package_id}/";
	} elseif ( file_exists( TEMPLATEPATH."/buddyboss-wall/bp-{$theme_package_id}/" ) ) {
		$templates_dir = TEMPLATEPATH."/buddyboss-wall/bp-{$theme_package_id}/";
	} else {
		if ( 'legacy' === $theme_package_id ) {
			$templates_dir = BP_TOL_DIR . '/templates/bp-legacy/';
		} elseif ( 'nouveau' === $theme_package_id ) {
			$templates_dir = BP_TOL_DIR . '/templates/bp-nouveau/';
		}
	}

	return $templates_dir;
}


// replace member-header.php with the template overload from the plugin
function bp_tol_maybe_replace_template( $templates, $slug, $name ) {

    if( 'members/single/member-header' != $slug )
        return $templates;

    return array( 'members/single/member-header-tol.php' );
}


function bp_tol_start() {

    if( function_exists( 'bp_register_template_stack' ) )
        bp_register_template_stack( 'bp_tol_register_template_location' );

    // if viewing a member page, overload the template
//    if ( bp_is_user()  )
//        add_filter( 'bp_get_template_part', 'bp_tol_maybe_replace_template', 10, 3 );

}
add_action( 'bp_init', 'bp_tol_start' );