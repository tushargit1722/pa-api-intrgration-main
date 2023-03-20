<?php
function import_steering_types()
{
    $cpt_type = 'steeringtype'; // type for associated CPT


    $endpoint = get_option( 'steering_type_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $steering_type) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>Steering type Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($steering_type);
echo "</pre>";
exit;  */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($steering_type["steeringTypes"] as $steering) {
		
    $steeringName = isset($steering["name"]["textEN"]) ? $steering["name"]["textEN"]: "";
    $id = isset($steering["id"]) ? $steering["id"] : "";
   

    $post_data = array(
        'post_title' => $steeringName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'name', $steeringName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}