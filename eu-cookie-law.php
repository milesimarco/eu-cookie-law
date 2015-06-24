<?php
/*
Plugin Name:  EU Cookie Law
Plugin URI:   https://wordpress.org/plugins/eu-cookie-law/
Description:  Cookie Law informs users that your site has cookies, with a popup for more information and ability to lock scripts before acceptance.
Version:      2.5
Author:       Alex Moss, Marco Milesi, Peadig, Shane Jones
Author URI:   https://wordpress.org/plugins/eu-cookie-law/
Contributors: alexmoss, Milmor, peer, ShaneJones

*/

function eucookie_start() {
    require 'class-frontend.php';
    if ( is_admin() ) { require 'class-admin.php'; }
} add_action('init', 'eucookie_start');

function ecl_action_admin_init() {
    $arraya_ecl_v = get_plugin_data ( __FILE__ );
    $new_version = $arraya_ecl_v['Version'];
        
    if ( version_compare($new_version,  get_option('ecl_version_number') ) == 1 ) {
        ecl_check_defaults();
        update_option( 'ecl_version_number', $new_version );   
    }

    if ( eucookie_option('tinymcebutton') ) {
        require 'inc/tinymce.php';
    }
} add_action('admin_init', 'ecl_action_admin_init');

function ecl_check_defaults() { require 'defaults.php'; }

add_action( 'plugins_loaded', 'ecl_load_textdomain' );
function ecl_load_textdomain() {
    load_plugin_textdomain( 'eu-cookie-law', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

?>