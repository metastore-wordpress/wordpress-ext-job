<?php
/**
 * Plugin Name:     (WP-EXT) Job
 * Plugin URI:      https://metastore.pro/
 *
 * Description:     Job post type and more.
 *
 * Author:          Kitsune Solar
 * Author URI:      https://kitsune.solar/
 *
 * Version:         1.0.0
 *
 * Text Domain:     wp-ext-job
 * Domain Path:     /languages
 *
 * License:         GPLv3
 * License URI:     https://www.gnu.org/licenses/gpl-3.0.html
 */

/**
 * Loading `WP_EXT_Job`.
 */

function run_wp_ext_job() {
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_Post_Type.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_Post_Field.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_Taxonomy.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_User_Role.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_Theme.class.php' );
//	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_Template.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_ShortCode.class.php' );
	require_once( plugin_dir_path( __FILE__ ) . 'includes/WP_EXT_Job_Widget.class.php' );
}

run_wp_ext_job();
