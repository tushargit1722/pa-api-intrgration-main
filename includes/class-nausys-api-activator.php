<?php

/**
 * Fired during plugin activation
 *
 * @link       http://mundrisoft.com
 * @since      1.0.0
 *
 * @package    Nausys_CPT_Api
 * @subpackage Nausys_CPT_Api/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Nausys_CPT_Api
 * @subpackage Nausys_CPT_Api/includes
 *
 */
class Nausys_Api_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		register_activation_hook(__FILE__, 'my_plugin_activation');

	}
	
function my_plugin_activation() {
  if (!file_exists(API_ERROR_LOG)) {
    $file_handle = fopen(API_ERROR_LOG, 'w');
    fclose($file_handle);
  }
  if (!is_writable(API_ERROR_LOG)) {
    // handle error: the log file is not writable
  }
}

}
