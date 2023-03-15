<?php
function import_engine_builders()
{
    $cpt_type = 'engine_builder'; // type for associated CPT


    $endpoint = get_option( 'engine_builders_endpoint_url' );
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $engine_builders) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2> Engine Builders Items Imported... </h2>';

/* echo $response_code;
echo "<pre>";
print_r($engine_builders);
echo "</pre>";
exit; 
 */
 
 
if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($engine_builders["builders"] as $builder) {
		
    $builderName = isset($builder["name"]) ? $builder["name"]: "";
    $id = isset($builder["id"]) ? $builder["id"] : "";
	
    $post_data = array(
        'post_title' => $builderName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        update_field( 'id', $id, $post_id );
        update_field( 'name', $builderName, $post_id );
    }
}  
// end of If
return true;
    
}