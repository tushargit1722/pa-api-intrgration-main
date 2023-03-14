<?php
/*
 * Plugin Name: PharmaACE API Integration
 * Plugin URI: pharmaace.com
 * Author: PharmaACE
 * Author URI: https://pharmaace.com/
 * Description: Plugin for API Integration
 * Version: 1.0
 * text-domain: pa-api-integration
*/

defined( 'ABSPATH' ) or die;

define('API_ERROR_LOG', plugin_dir_path(__FILE__) . 'api-error.log');



include plugin_dir_path( __FILE__ ) . 'pa-config.php';
include plugin_dir_path( __FILE__ ) . 'includes/error-log.php';
include plugin_dir_path( __FILE__ ) . 'import-data/pa-push-cpt.php';
include plugin_dir_path( __FILE__ ) . 'import-data/import-cabins.php';
include plugin_dir_path( __FILE__ ) . 'import-data/import-countries.php';
include plugin_dir_path( __FILE__ ) . 'import-data/import-charter-bases.php';

class paPlugin
{
    function __construct(){

    }

    function activate()
	{
		//generate Admin menu
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-nausys-api-activator.php';
		Nausys_Api_Activator::activate();
			// flush rewrite rules
			flush_rewrite_rules();
	}
	function deactivate()
	{
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-nausys-api-deactivator.php';
		Nausys_Api_Deactivator::deactivate();

			// flush rewrite rules
			flush_rewrite_rules();
	}
	
    function pa_register(){
        add_action( 'admin_menu',  'pa_add_menu_page');
        add_action( 'admin_init',  'register_config_options');
        add_action( 'admin_enqueue_scripts', array($this, 'pa_enqueue'));   	
	}
    function pa_enqueue(){
		// enqueue all our scripts
		//wp_enqueue_style( 'nausys-css', plugins_url( '/assets/nausys-css.css' , __FILE__ ,10));
		//wp_enqueue_script( 'nausys-js', plugins_url( '/assets/nausys-js.js' , __FILE__ ));
	}

} // end of class


if( class_exists('paPlugin')){
    $paPlugin  = new paPlugin();
    $paPlugin->pa_register();
}

function pa_add_menu_page() {
    add_menu_page(
        'API page', //page title
        'API PAge', //menu title
        'manage_options', //admin_level
        'api-page', //page-slug
        'api_page_function', //callback function 
        'dashicons-book', // icon for plugin
         5 //position in admin panel
    );
    add_submenu_page( 
        'api-page', // parent-slug
		'API Logs', // page title
		'API logs', // sub-menu title
		'manage_options', // admin levels
		'error-log', // sub menu page slug
		'get_error_logs' // call back function
    );
    add_submenu_page( 
        'api-page', // submenu for page-slug parent-slug
        'Config', 
        'Config', 
        'manage_options', 
        'api-config-page', 
        'api_configuration_options'
    );
    add_submenu_page( 
        'api-config-page', // submenu for page-slug parent-slug
        'Config', 
        'Config', 
        'manage_options', 
        'api-cabins', 
        'api_configuration_options_cabins'
    );
}


function api_page_function(){
	?>
	<div class="">
		<h2 class="">Fetch API (test)</h2>
	</div>
	<form method="post" >
	<input type="submit" class="ns-btn" name="import_cabins"
			value="Import Cabins"/>
	<input type="submit" class="ns-btn" name="import_countries"
			value="Import Countries"/>
	<input type="submit" class="ns-btn" name="import_charter_bases"
			value="Import Charter Bases"/>
	<input type="submit" class="ns-btn" name="pushcpt"
			value="All data"/>
			
	</form>
<?php

//button call Api
if(array_key_exists('pushcpt', $_POST)) 
{
    pushcpt();    
}
// call Api for Cabins
if(array_key_exists('import_cabins', $_POST))
{
    import_cabins();
}
// call Api for Countries
if(array_key_exists('import_countries', $_POST))
{
    import_countries();
}	
// call Api for Charter Bases
if(array_key_exists('import_charter_bases', $_POST))
{
    import_charter_bases();
}	





}
function get_data_from_api($endpoint,$body) {

	$body = wp_json_encode( $body );
	$options = [
	'method'      => 'POST',
	'body'        => $body,
	'headers'     => [
		'Content-Type' => 'application/json',
	],
	'timeout'     => 120,
	'redirection' => 5,
	'blocking'    => true,
	'httpversion' => '1.0',
	'sslverify'   => false,
	'data_format' => 'body',
	];

	$response		= wp_remote_post( $endpoint, $options ); // Complete Respose from server
	$response_code	= wp_remote_retrieve_response_code( $response );	// Reponse Code
	$response_body	= json_decode( wp_remote_retrieve_body( $response), true ); // Response Body PHP
	//$response_body	= wp_remote_retrieve_body( $response); // Response Body Json
	// Error handelling

	if ( (401 === $response_code )) {		
		$response_body = "Unauthorized access";
		log_entry_apicall($endpoint,$response_code);
		return array($response_code, $response_body);
		}
	
	if ( (200 !== $response_code )) { 
		$response_body = "Error in pinging API";
		log_entry_apicall($endpoint,$response_code);
		return array($response_code, $response_body);
	}

	if ( ( 200 === $response_code)) {
		log_entry_apicall($endpoint,$response_code);
		//return $response_body;

		return array($response_code, $response_body);

	}
	   
}

function delete_all_posts_for($post_type) {
    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'post_status' => 'any',
    );
    $posts = get_posts($args);
    foreach ($posts as $post) {
        wp_delete_post($post->ID, true);
    }
	wp_reset_postdata();
	return 'true';
}

function log_entry_apicall($endpoint,$error){

	$message = 'API Call : ';
	$data = array(
	  'code' => $error,
	  'endpoint' => $endpoint,
	  'time' => date('Y-m-d H:i:s')
	);
	$log_data = json_encode($data);

	$file_handle = fopen(API_ERROR_LOG, 'a');
	$log_message = $message . ' ' . $log_data . PHP_EOL;
	fwrite($file_handle, $log_message);
	fclose($file_handle);
}



