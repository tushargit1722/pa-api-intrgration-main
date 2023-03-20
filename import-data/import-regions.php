<?php
function import_regions()
{
    $cpt_type = 'region'; // type for associated CPT


    $endpoint = get_option( 'regions_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $regions) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>regions Items Imported...</h2>';

/* echo $response_code;
echo "<pre>";

foreach ($regions["regions"] as $region) {
	  $cId = isset($region["countryId"]) ? $region["countryId"] : "";
	  print_r($cId);
}
echo "</pre>";
exit;  */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($regions["regions"] as $region) {
		
    $regionName = isset($region["name"]["textEN"]) ? $region["name"]["textEN"]: "";
    $id = isset($region["id"]) ? $region["id"] : "";
    $cId = isset($region["countryId"]) ? $region["countryId"] : "";

    $post_data = array(
        'post_title' => $regionName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'countryid', $cId, $post_id );	
		update_field( 'name', $regionName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}