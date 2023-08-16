<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Disable Site Health for Non-Administrators
 * Plugin URI:        https://github.com/Kntnt/kntnt-disable-site-health-for-non-administrators
 * Description:       Disables site health for non-administrators.
 * Version:           1.0.1
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Disable_Site_health_For_Non_Administrators;


defined( 'ABSPATH' ) && new Plugin;


final class Plugin {

	private $allowed_roles = [ 'administrator' ];

	public function __construct() {
		add_action( 'init', [ $this, 'run' ] );
	}

	public function run() {
		if ( ! array_intersect( wp_get_current_user()->roles, $this->allowed_roles ) ) {
			add_action( 'wp_dashboard_setup', [ $this, 'disable_site_health_widget' ] );
			add_action( 'admin_menu', [ $this, 'disable_site_health_submenu' ], 999 );
		}
	}

	public function disable_site_health_widget() {
		global $wp_meta_boxes;
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_site_health'] );
	}

	public function disable_site_health_submenu() {
		remove_submenu_page( 'tools.php', 'site-health.php' );
	}

}
