<?php
function import_discount_items()
{
    $cpt_type = 'discount_item'; // type for associated CPT


    $endpoint = get_option( 'discount_items_endpoint_url' );
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $discount_items) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2> Discount items imported... </h2>';
/* echo $response_code;
print_r($discount_items);
exit; */


if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($discount_items["discounts"] as $discount) {
		
    $discountName = isset($discount["name"]["textEN"]) ? $discount["name"]["textEN"] : "";
    $id = isset($discount["id"]) ? $discount["id"] : "";
	
    $post_data = array(
        'post_title' => $discountName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        update_field( 'id', $id, $post_id );
        update_field( 'name', $discountName, $post_id );
    }
} 
// end of If
return true;
    
}