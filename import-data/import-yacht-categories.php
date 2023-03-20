<?php
function import_yacht_categories()
{
    $cpt_type = 'yacht_category'; // type for associated CPT


    $endpoint = get_option( 'yacht_category_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $yacht_categories) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>yacht categories Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($yacht_categories);
echo "</pre>";
exit;  */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($yacht_categories["categories"] as $yacht_cat) {
		
    $yacht_catName = isset($yacht_cat["name"]["textEN"]) ? $yacht_cat["name"]["textEN"]: "";
    $id = isset($yacht_cat["id"]) ? $yacht_cat["id"] : "";
   

    $post_data = array(
        'post_title' => $yacht_catName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        
		update_field( 'name', $yacht_catName, $post_id );
		update_field( 'id', $id, $post_id );
    }
}   
// end of If
return true;
    
}