<?php
function import_sail_types()
{
    $cpt_type = 'sail_type'; // type for associated CPT


    $endpoint = get_option( 'sail_types_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $sail_types) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>sail types Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($sail_types);
echo "</pre>";
exit; */ 

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($sail_types["sailTypes"] as $sailType) {
		
    $sailTypeName = isset($sailType["name"]["textEN"]) ? $sailType["name"]["textEN"]: "";
    $id = isset($sailType["id"]) ? $sailType["id"] : "";
   

    $post_data = array(
        'post_title' => $sailTypeName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'name', $sailTypeName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}