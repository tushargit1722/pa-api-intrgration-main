<?php
function import_seasons()
{
    $cpt_type = 'season'; // type for associated CPT


    $endpoint = get_option( 'seasons_endpoint_url');
    $endpoint_username = get_option( 'api-username' );
    $endpoint_password = get_option( 'api-password' );

$body_cabins = [
    "username" =>$endpoint_username,
    "password" =>$endpoint_password
];

list($response_code, $seasons) = get_data_from_api($endpoint,$body_cabins); // Call to Get Data for Enpoint

echo '<h2>seasons Items Imported...</h2>';
/*  
echo $response_code;
echo "<pre>";
print_r($seasons);
foreach ($seasons["seasons"] as $season) {
	$id = isset($season["id"]) ? $season["id"] : "";
    $charterCompanyId = isset($season["charterCompanyId"]) ? $season["charterCompanyId"] : "";
    $defaultSeason = isset($season["defaultSeason"]) ? $season["defaultSeason"] : "";
    $from = isset($season["from"]) ? $season["from"] : "";
    $seasonyr = isset($season["season"]) ? $season["season"] : "";
    $to = isset($season["to"]) ? $season["to"] : "";
	
	$locationsId[] = isset($season["locationsId"]) ? $season["locationsId"] : "";
	
	echo $id . "<br>";
	echo $charterCompanyId . "<br>";
	echo $defaultSeason . "<br>";
	echo $from . "<br>";
	echo $seasonyr . "<br>";
	echo $to . "<br>";
	
	$locationsId =array(51, 5168287, 53);
	
	foreach($locationsId as $locids) {
		
		echo $locids."<br>";
	}
}

echo "</pre>";
exit;   */

if ( ( 200 === $response_code) && post_type_exists( $cpt_type )) {
    delete_all_posts_for($cpt_type); // To delete

    // Loop through each cabin definition
    foreach ($seasons["seasons"] as $myseason) {
		
   	$id = isset($myseason["id"]) ? $myseason["id"] : "";
    $charterCompanyId = isset($myseason["charterCompanyId"]) ? $myseason["charterCompanyId"] : "";
    $defaultSeason = isset($myseason["defaultSeason"]) ? $myseason["defaultSeason"] : "";
    $from = isset($myseason["from"]) ? $myseason["from"] : "";
    $to = isset($myseason["to"]) ? $myseason["to"] : "";
    $seasonyr = isset($myseason["season"]) ? $myseason["season"] : "";
	
    $post_data = array(
        'post_title' => $charterCompanyId,
        'post_status' => 'publish',
        'post_type' => $cpt_type,
    );
	
		$post_id = wp_insert_post( $post_data );
		
		update_field( 'id', $id, $post_id );
		update_field( 'charterCompanyId', $charterCompanyId, $post_id );
		update_field( 'defaultSeason', $defaultSeason, $post_id );
		update_field( 'from', $from, $post_id );
		update_field( 'season', $seasonyr, $post_id );
		update_field( 'to', $to, $post_id );
		
		/* $locationsId =array(51, 5168287, 53);


		foreach($locationsId as $locids) {
						
			// Check rows existexists.
			if( have_rows('locationsId') ){

				// Loop through rows.
				while( have_rows('locationsId') ) : the_row();

					// Load sub field value.
					$sub_value = get_sub_field('locid');
					// Do something...
					update_field( $sub_value, $locids, $post_id );
				// End loop.
				endwhile;
			
			}
		} */
	
    }
}   
// end of If
return true;
    
}