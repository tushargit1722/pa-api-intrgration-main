<?php

function import_countries(){

$cpt_type = 'countries'; // type for associated CPT
$endpoint_cabins = 'http://ws.nausys.com/CBMS-external/rest/catalogue/v6/countries';
$body_cabins = [
    "username" =>"rest258@TTTTT",
    "password" =>"b8f6t3sw"
];

list($response_code, $countries) = get_data_from_api($endpoint_cabins,$body_cabins); // Call to Get Data for Enpoint

echo '<h2> Function Called : import_cabins(): </h2>';
echo $response_code;
//print_r($countries);
///

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($countries["countries"] as $country) {
    $countryCode = isset($country["code"]) ? $country["code"] : "";

    $post_data = array(
        'post_title' => $countryCode,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
    $post_id = wp_insert_post( $post_data );
        // Get the data for each cabin
        // $cabinName = isset($country["cabinName"]) ? $country["cabinName"] : "";
        // $cabinPosition = isset($country["cabinPosition"]) ? $country["cabinPosition"] : "";
        $countryId = isset($country["id"]) ? $country["id"] : "";
        update_field( 'id', $countryId, $post_id );
        $countryCode = isset($country["code"]) ? $country["code"] : "";
        update_field( 'code', $countryCode, $post_id );
        $countryCode2 = isset($country["code2"]) ? $country["code2"] : "";
        update_field( 'code2', $countryCode2, $post_id );

        $names = isset($country["name"]) ? $country["name"] : "";
        $textEN = isset($country["name"]["textEN"]) ? $country["name"]["textEN"] : "";
        //echo $textEN;
        update_field( 'field_64104898609b6', $textEN, $post_id );
            foreach($names as $name => $name_value) {
                    //echo "Key=" . $name . ", Value=" . $name_value;

                // update_field( 'codtext', $countryCode2, $post_id );           
            }
    }

} // end of If
return true;
}
