<?php
function import_price_measures()
{
    $cpt_type = 'price_measure'; // type for associated CPT


    $endpoint = get_option( 'price_measures_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $price_measure) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>PriceMeasure Items Imported...</h2>';
/* 
echo $response_code;
echo "<pre>";
print_r($price_measure);
echo "</pre>";
exit;  */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($price_measure["priceMeasures"] as $priceMeasure) {
		
    $priceMeasureName = isset($priceMeasure["name"]["textEN"]) ? $priceMeasure["name"]["textEN"]: "";
    $id = isset($priceMeasure["id"]) ? $priceMeasure["id"] : "";
	
    $post_data = array(
        'post_title' => $priceMeasureName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
       
		update_field( 'name', $priceMeasureName, $post_id );
		update_field( 'id', $id, $post_id );
	
    }
}   
// end of If
return true;
    
}