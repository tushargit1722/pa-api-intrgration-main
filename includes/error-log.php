<?php
function get_error_logs(){
    ?>	
    <h2 class="error-log-heading">Log for API Calls</h2>
        <div class='container error-log'> 
            <?php 
            $log_file_path = API_ERROR_LOG;
            if ( file_exists( $log_file_path ) ) {
                echo '<pre>';
                echo file_get_contents( $log_file_path );
                echo '</pre>';
            } else {
                echo 'Log file not found.';
            }
            ?>
        </div>
    <?php
}