<?php 

function import_cabins(){

	$cabins_cpt_type = 'cabins'; // type for associated CPT
	$endpoint_cabins = get_option( 'cabins_endpoint_url' );
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );
	$body_cabins = [
		"username" =>$endpoint_username,
		"password" =>$endpoint_password
	];
	list($response_code, $cabins) = get_data_from_api($endpoint_cabins,$body_cabins); // Call to Get Data for Enpoint

	echo '<h2> Function Called : import_cabins(): </h2>';
	echo $response_code;
	echo $endpoint_cabins;

if ( ( 200 === $response_code) && post_type_exists( $cabins_cpt_type )) {
	delete_all_posts_for($cabins_cpt_type); // To delete
	// Loop through each cabin definition
	foreach ($cabins["cabinDefinitions"] as $cabin) {
		// Get the data for each cabin
		$cabinName = isset($cabin["cabinName"]) ? $cabin["cabinName"] : "";
		$cabinPosition = isset($cabin["cabinPosition"]) ? $cabin["cabinPosition"] : "";
		$cabinType = isset($cabin["cabinType"]) ? $cabin["cabinType"] : "";
		$cabinId = isset($cabin["id"]) ? $cabin["id"] : "";
	
	$post_data = array(
		'post_title' => $cabinName,
		'post_status' => 'publish',
		'post_type' => $cabins_cpt_type,
	);
	
	$post_id = wp_insert_post( $post_data );
	update_field( 'id', $cabinId, $post_id );
	update_field( 'cabinposition', $cabinPosition, $post_id );
	update_field( 'cabintype', $cabinType, $post_id );
	
	} // end of foreach
} // end of If
return true;
} // end of Import Cabins
