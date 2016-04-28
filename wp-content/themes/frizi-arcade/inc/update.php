<?php

/**/
//set_site_transient('update_themes', null);


/* * ****************Change this****************** */
$api_url = 'http://www.arcadepulse.com/api/';
/* * ********************************************* */


/* * *********************Parent Theme************* */
if (function_exists('wp_get_theme')) {
    $theme_data = wp_get_theme(get_option('template'));
    $theme_version = $theme_data->Version;
} else {
    $theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
    $theme_version = $theme_data['Version'];
}
$theme_base = get_option('template');
/* * *********************************************** */

add_filter('pre_set_site_transient_update_themes', 'check_for_update');

function check_for_update($checked_data) {
    global $wp_version, $theme_version, $theme_base, $api_url;

    $request = array(
        'slug' => $theme_base,
        'version' => $theme_version
    );
    // Start checking for an update
    $send_for_check = array(
        'body' => array(
            'action' => 'theme_update',
            'request' => serialize($request),
            'api-key' => md5(get_bloginfo('url'))
        ),
        'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
    );
    $raw_response = wp_remote_post($api_url, $send_for_check);
    if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200)){
        $response = unserialize($raw_response['body']);
    } 
    // Feed the update data into WP updater
    if (!empty($response)){
        update_option('frizi_arcade_update_available', '1');
        update_option('frizi_arcade_new_version', $response['new_version']);
        $checked_data->response[$theme_base] = $response;
    } else {
        update_option('frizi_arcade_update_available', '0');
        update_option('frizi_arcade_new_version', '');
    }
    return $checked_data;
}

// Take over the Theme info screen on WP multisite
add_filter('themes_api', 'my_theme_api_call', 10, 3);

function my_theme_api_call($def, $action, $args) {
    global $theme_base, $api_url, $theme_version, $api_url;

    if ($args->slug != $theme_base)
        return false;

    // Get the current version

    $args->version = $theme_version;
    $request_string = prepare_request($action, $args);
    $request = wp_remote_post($api_url, $request_string);

    if (is_wp_error($request)) {
        $res = new WP_Error('themes_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $request->get_error_message());
    } else {
        $res = unserialize($request['body']);

        if ($res === false)
            $res = new WP_Error('themes_api_failed', __('An unknown error occurred'), $request['body']);
    }

    return $res;
}

if (is_admin()){
    $current = get_transient('update_themes');
    add_action('admin_notices', 'frizi_arcade_update_admin_notice');
    
}
function frizi_arcade_update_admin_notice() {
    global $current_user;
    
    if (current_user_can('manage_options')) {
        $user_id = $current_user->ID;
        $theme_data = wp_get_theme(get_option('template'));
        
        if (get_option('frizi_arcade_update_available') == '1'  && (version_compare( get_option('frizi_arcade_new_version'), $theme_data['Version']) > 0 ) ) {
            
            $stylesheet = $theme_data->get_stylesheet();
            $update_url = wp_nonce_url( admin_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( $stylesheet ) ), 'upgrade-theme_' . $stylesheet );
            echo '<div class="update-nag">
					   	' . sprintf(__('New Arcade Pulse theme update is now available. Update now to version %s . <a href="%s">Click here!</a>.', 'arcade pulse'),get_option('frizi_arcade_new_version'), $update_url) . '
						</div>';
        }
        
    }
}
