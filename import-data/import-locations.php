<?php
function import_locations()
{
    $cpt_type = 'location'; // type for associated CPT


    $endpoint = get_option( 'locations_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $locations) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>Locations Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($locations);
echo "</pre>";
exit;  */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($locations["locations"] as $location) {
		
    $locationName = isset($location["name"]["textEN"]) ? $location["name"]["textEN"]: "";
    $id = isset($location["id"]) ? $location["id"] : "";
    $lat = isset($location["lat"]) ? $location["lat"] : "";
    $lon = isset($location["lon"]) ? $location["lon"] : "";
	
    $post_data = array(
        'post_title' => $locationName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
       
		update_field( 'name', $locationName, $post_id );
		update_field( 'id', $id, $post_id );
		update_field( 'lat', $lat, $post_id );
		update_field( 'lon', $lon, $post_id );
    }
}   
// end of If
return true;
    
}