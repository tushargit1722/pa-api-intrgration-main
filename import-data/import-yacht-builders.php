<?php
function import_yacht_builders()
{
    $cpt_type = 'yacht_builder'; // type for associated CPT


    $endpoint = get_option( 'yacht_builders_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $yacht_builders) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>yacht builders type Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($yacht_builders);
echo "</pre>";
exit; */ 

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($yacht_builders["builders"] as $builder) {
		
    $builderName = isset($builder["name"]) ? $builder["name"]: "";
    $id = isset($builder["id"]) ? $builder["id"] : "";
   

    $post_data = array(
        'post_title' => $builderName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'name', $builderName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}