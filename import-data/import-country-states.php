<?php
function import_country_states()
{
    $cpt_type = 'countrystate'; // type for associated CPT


    $endpoint = get_option( 'countrystate_endpoint_url' );
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $countrystates) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2> Function Called : import Countr States(): </h2>';
//echo $response_code;
//print_r($countrystates);
//exit;

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($countrystates["countries"] as $country) {
    $countryName = isset($country["name"]) ? $country["name"] : "";

    $post_data = array(
        'post_title' => $countryName,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
    $post_id = wp_insert_post( $post_data );
    
        // Get the data for each cabin
        // $cabinName = isset($country["cabinName"]) ? $country["cabinName"] : "";
        // $cabinPosition = isset($country["cabinPosition"]) ? $country["cabinPosition"] : "";
        $countryId = isset($country["countryId"]) ? $country["countryId"] : "";
        update_field( 'countryid', $countryId, $post_id );

        $id = isset($country["id"]) ? $country["id"] : "";
        update_field( 'id', $id, $post_id );

        update_field( 'name', $countryName, $post_id );

    }

} // end of If
return true;
    
}