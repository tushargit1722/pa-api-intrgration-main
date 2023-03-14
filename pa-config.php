<?php 

function register_config_options()
{   
    register_setting( 'plugin-configuration-group', 'api-username' );
    register_setting( 'plugin-configuration-group', 'api-password' );
    register_setting( 'plugin-configuration-group', 'endpoint_url' );
}


function api_configuration_options(){  
    ?>
    <div class="wrap">
    <h1>Plugin Configuration</h1>
<script> 
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
    <form method="post" action="options.php">
        <?php settings_fields( 'plugin-configuration-group' ); ?>
        <?php do_settings_sections( 'plugin-configuration-group' ); ?>

        <table class="form-table">
        <tr valign="top">
            <th scope="row">API Username:</th>
            <td><input type="text" size=50 name="api-username" value="<?php echo esc_attr( get_option('api-username') ); ?>" /></td>
            </tr>    
        <tr valign="top">
            <th scope="row">API Password:</th>
            <td><input type="password" id="myInput" size=50 name="api-password" value="<?php echo esc_attr( get_option('api-password') ); ?>" /></td>
             
        </tr>
        <tr valign="top">  
            <th> </th>        
            <td><input type="checkbox" onclick="myFunction()"> Show Password</tr></td>
             
        </tr>
         

            <tr valign="top">
            <th scope="row">Cabins endpoint:</th>
            <td><input type="url" size=100 name="endpoint_url" value="<?php echo esc_attr( get_option('endpoint_url') ); ?>" /></td>
            </tr>
        </table>
        
        <?php submit_button(); ?>
    
    </form>
    </div>
    <?php
    }