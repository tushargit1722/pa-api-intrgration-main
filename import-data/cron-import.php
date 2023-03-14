<?php

// Add custom cron interval for once daily at 12:30 AM
function custom_cron_interval( $schedules ) {
    $schedules['daily_12_30'] = array(
        'interval' => 86400,
        'display'  => esc_html__( 'Once Daily at 12:30 AM', 'textdomain' ),
    );
    return $schedules;
}
add_filter( 'cron_schedules', 'custom_cron_interval' );

// Schedule the cron job
function schedule_custom_cron_job() {
    if ( ! wp_next_scheduled( 'custom_cron_event' ) ) {
        wp_schedule_event( strtotime( '12:30 AM' ), 'daily_12_30', 'custom_cron_event' );
    }
}
add_action( 'wp', 'schedule_custom_cron_job' );

// Run the cron job
function import_catalogue_data_through_cron() {
    // Your code goes here
        // call function 1
        if (import_cabins()) {
            echo "import_cabins executed successfully.<br>";
        } else {
            echo "import_cabins failed to execute.<br>";
        }

        if (import_countries()) {
            echo "import_countries executed successfully.<br>";
        } else {
            echo "import_countries failed to execute.<br>";
        }
}
add_action( 'custom_cron_event', 'import_catalogue_data_through_cron' );

