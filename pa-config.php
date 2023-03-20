<?php 

function register_config_options()
{   
    register_setting( 'plugin-configuration-group', 'api-username' );
    register_setting( 'plugin-configuration-group', 'api-password' );
    register_setting( 'plugin-configuration-group', 'cabins_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'charter_bases_endpoint_url' );
    register_setting( 'plugin-configuration-group', 'countries_endpoint_url' );
    register_setting( 'plugin-configuration-group', 'countrystate_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'discount_items_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'engine_builders_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'equipments_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'equipment_categories_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'locations_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'price_measures_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'regions_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'sail_types_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'seasons_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'services_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'steering_type_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'yacht_builders_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'yacht_category_endpoint_url' );
	register_setting( 'plugin-configuration-group', 'yachts_model_endpoint_url' );
	
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
            <td><input type="url" size=100 name="cabins_endpoint_url" value="<?php echo esc_attr( get_option('cabins_endpoint_url') ); ?>" /></td>
            </tr>

            <tr valign="top">
            <th scope="row">Countries endpoint:</th>
            <td><input type="url" size=100 name="countries_endpoint_url" value="<?php echo esc_attr( get_option('countries_endpoint_url') ); ?>" /></td>
            </tr>


            <tr valign="top">
            <th scope="row">Charter Bases endpoint:</th>
            <td><input type="url" size=100 name="charter_bases_endpoint_url" value="<?php echo esc_attr( get_option('charter_bases_endpoint_url') ); ?>" /></td>
            </tr>

            <tr valign="top">
            <th scope="row">Country States endpoint:</th>
            <td><input type="url" size=100 name="countrystate_endpoint_url" value="<?php echo esc_attr( get_option('countrystate_endpoint_url') ); ?>" /></td>
            </tr>
			
			 <tr valign="top">
            <th scope="row">Discount Items endpoint:</th>
            <td><input type="url" size=100 name="discount_items_endpoint_url" value="<?php echo esc_attr( get_option('discount_items_endpoint_url') ); ?>" /></td>
            </tr>
			
			
			 <tr valign="top">
            <th scope="row">Engine Builders endpoint:</th>
            <td><input type="url" size=100 name="engine_builders_endpoint_url" value="<?php echo esc_attr( get_option('engine_builders_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Equipment endpoint:</th>
            <td><input type="url" size=100 name="equipments_endpoint_url" value="<?php echo esc_attr( get_option('equipments_endpoint_url') ); ?>" /></td>
            </tr>

			<tr valign="top">
            <th scope="row">Equipment categories endpoint:</th>
            <td><input type="url" size=100 name="equipment_categories_endpoint_url" value="<?php echo esc_attr( get_option('equipment_categories_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Locations endpoint:</th>
            <td><input type="url" size=100 name="locations_endpoint_url" value="<?php echo esc_attr( get_option('locations_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Price Measures endpoint:</th>
            <td><input type="url" size=100 name="price_measures_endpoint_url" value="<?php echo esc_attr( get_option('price_measures_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Regions endpoint:</th>
            <td><input type="url" size=100 name="regions_endpoint_url" value="<?php echo esc_attr( get_option('regions_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Sail Types endpoint:</th>
            <td><input type="url" size=100 name="sail_types_endpoint_url" value="<?php echo esc_attr( get_option('sail_types_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Seasons endpoint:</th>
            <td><input type="url" size=100 name="seasons_endpoint_url" value="<?php echo esc_attr( get_option('seasons_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Services Types endpoint:</th>
            <td><input type="url" size=100 name="services_endpoint_url" value="<?php echo esc_attr( get_option('services_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Steering Types endpoint:</th>
            <td><input type="url" size=100 name="steering_type_endpoint_url" value="<?php echo esc_attr( get_option('steering_type_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Yacht builders Types endpoint:</th>
            <td><input type="url" size=100 name="yacht_builders_endpoint_url" value="<?php echo esc_attr( get_option('yacht_builders_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Yacht category Types endpoint:</th>
            <td><input type="url" size=100 name="yacht_category_endpoint_url" value="<?php echo esc_attr( get_option('yacht_category_endpoint_url') ); ?>" /></td>
            </tr>
			
			<tr valign="top">
            <th scope="row">Yachts Models endpoint:</th>
            <td><input type="url" size=100 name="yachts_model_endpoint_url" value="<?php echo esc_attr( get_option('yachts_model_endpoint_url') ); ?>" /></td>
            </tr>
			
        </table>
        
        <?php submit_button(); ?>
    
    </form>
    </div>
    <?php
    }