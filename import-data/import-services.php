<?php
function import_services()
{
    $cpt_type = 'service'; // type for associated CPT


    $endpoint = get_option( 'services_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $services) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>Services Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($services);
echo "</pre>";
exit;  */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($services["services"] as $service) {
		
    $serviceName = isset($service["name"]["textEN"]) ? $service["name"]["textEN"]: "";
    $id = isset($service["id"]) ? $service["id"] : "";
   

    $post_data = array(
        'post_title' => $serviceName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'name', $serviceName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}