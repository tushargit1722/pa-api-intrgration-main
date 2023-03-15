<?php 

function import_charter_bases(){

	$charter_bases_cpt_type = 'charterbase'; // type for associated CPT
	$endpoint_charter_bases = get_option( 'charter_bases_endpoint_url' );
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

	$body_charter_bases = [
		"username" =>$endpoint_username,
		"password" =>$endpoint_password
	];
	list($response_code, $charter_bases) = get_data_from_api($endpoint_charter_bases,$body_charter_bases); // Call to Get Data for Enpoint

	echo '<h2> Function Called : import_charter_bases(): </h2>';
	echo $response_code;

/* 
echo $response_code;
echo "<pre>";
foreach ($charter_bases["bases"] as $charter_base) {
	$secondaryBase = isset($charter_base["secondaryBase"]) ? $charter_base["secondaryBase"] : "";
	$id = isset($charter_base["id"]) ? $charter_base["id"] : "";

	var_dump($secondaryBase);
}
echo "</pre>";
exit;  */


if ( ( 200 === $response_code) && post_type_exists( $charter_bases_cpt_type )) {
	delete_all_posts_for($charter_bases_cpt_type); // To delete
	// Loop through each charter_base definition
	foreach ($charter_bases["bases"] as $charter_base) {
		// Get the data for each charter_base
        $id = isset($charter_base["id"]) ? $charter_base["id"] : "";
		$locationId = isset($charter_base["locationId"]) ? $charter_base["locationId"] : "";
		$companyId = isset($charter_base["companyId"]) ? $charter_base["companyId"] : "";
        $checkInTime = isset($charter_base["checkInTime"]) ? $charter_base["checkInTime"] : "";
        $checkOutTime = isset($charter_base["checkOutTime"]) ? $charter_base["checkOutTime"] : "";
        $lat = isset($charter_base["lat"]) ? $charter_base["lat"] : "";
        $lon = isset($charter_base["lon"]) ? $charter_base["lon"] : "";
       
	    // $disabled = isset($charter_base["disabled"]) ? $charter_base["disabled"] : "";
        
		//$secondaryBase = isset($charter_base["secondaryBase"]) ? $charter_base["secondaryBase"] : "";
		

    
	$post_data = array(
		'post_title' => $id,
		'post_status' => 'publish',
		'post_type' => $charter_bases_cpt_type,
	);
	
	$post_id = wp_insert_post( $post_data );
	update_field( 'id', $id, $post_id );
	update_field( 'locationid', $locationId, $post_id );
	update_field( 'companyid', $companyId, $post_id );
	update_field( 'checkInTime', $checkInTime, $post_id );
	update_field( 'checkOutTime', $checkOutTime, $post_id );
	update_field( 'lat', $lat, $post_id );
	update_field( 'lon', $lon, $post_id );
	
	// update_field( 'disabled', $disabled, $post_id );
	
	//update_field( 'secondaryBase', $secondaryBase, $post_id );
	
	} // end of foreach
} // end of If
return true;
} // end of Import charter_bases
