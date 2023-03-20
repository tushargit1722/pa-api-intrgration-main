<?php
function import_yacht_models()
{
    $cpt_type = 'yachts_model'; // type for associated CPT


    $endpoint = get_option( 'yachts_model_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $yachts_models) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>yacht Models Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($yachts_models);
echo "</pre>";
exit; 
 */
if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($yachts_models["models"] as $model) {
		
    $modelName = isset($model["name"]) ? $model["name"]: "";
    $id = isset($model["id"]) ? $model["id"] : "";
   

    $post_data = array(
        'post_title' => $modelName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'name', $modelName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}