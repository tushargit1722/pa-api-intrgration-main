<?php
function import_equipments()
{
    $cpt_type = 'equipment'; // type for associated CPT


    $endpoint = get_option( 'equipments_endpoint_url' );
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $equipments) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2> Equipments Items Imported... </h2>';

/* echo $response_code;
echo "<pre>";
print_r($equipments);
echo "</pre>";
exit; 
 */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($equipments["equipment"] as $equipment) {
		
    $equipmentName = isset($equipment["name"]["textEN"]) ? $equipment["name"]["textEN"]: "";
    $id = isset($equipment["id"]) ? $equipment["id"] : "";
    $categoryid = isset($equipment["categoryId"]) ? $equipment["categoryId"] : "";
	
    $post_data = array(
        'post_title' => $equipmentName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
        update_field( 'id', $id, $post_id );
        update_field( 'categoryId', $categoryid, $post_id );
        update_field( 'name', $equipmentName, $post_id );
    }
}   
// end of If
return true;
    
}