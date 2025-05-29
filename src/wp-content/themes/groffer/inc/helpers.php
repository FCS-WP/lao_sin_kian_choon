<?php 
defined( 'ABSPATH' ) || exit;

/*
 * Return fallback plugin version by slug
 * @param string plugin_slug
 * @return string plugin version by slug
 */
function groffer_fallback_plugin_version($plugin_slug = ''){
	$plugins = array(
	    "modeltheme-framework-groffer" => "1.1",
	    "js_composer" => "7.7.2",
	    "revslider" => "6.7.13"
	);

	return $plugins[$plugin_slug];
}


/*
 * Return plugin version by slug from remote json
 * @param string plugin_slug
 * @return string plugin version by slug
 */
function groffer_plugin_version($plugin_slug = ''){

    $request = wp_remote_get('https://modeltheme.com/json/plugin_versions.json');
    $plugin_versions = json_decode(wp_remote_retrieve_body($request), true);

	if( is_wp_error( $request ) ) {
		return groffer_fallback_plugin_version($plugin_slug);
	}else{
    	return $plugin_versions[0][$plugin_slug];
	}

}


function groffer_save_remote_plugin_versions_transient() {
    // Check permissions
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Unauthorized', 403);
    }

    // Check if transient is already set
    $plugin_versions = get_transient('groffer_plugin_versions_cache');
    if ($plugin_versions === false) {
        // Primary JSON URL
        $primary_url = 'https://modeltheme.com/json/plugin_versionss.json';
        // Secondary (GitHub) URL as a fallback
        $secondary_url = 'https://raw.githubusercontent.com/modelthemesnippets/plugins/refs/heads/main/plugin_versions.json';

        // Try fetching from the primary URL
        $request = wp_remote_get($primary_url);
        $source = ''; // Initialize the source variable

        // Check if there was an error with the primary URL
        if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
            // Log the error (optional)
            // error_log('Primary URL failed: ' . ($request instanceof WP_Error ? $request->get_error_message() : 'Invalid response code'));
            // Attempt to fetch from the secondary URL
            $request = wp_remote_get($secondary_url);
            $source = 'Secondary (GitHub) URL'; // Set source to secondary URL
            // If the secondary request fails, send an error response
            if (is_wp_error($request) || wp_remote_retrieve_response_code($request) != 200) {
                wp_send_json_error('Failed to fetch data from both primary and secondary sources');
            }
        } else {
            // If primary URL succeeds, set the source
            $source = 'Primary URL';
        }

        // Decode the JSON response from whichever URL succeeded
        $plugin_versions = json_decode(wp_remote_retrieve_body($request), true);

        // Validate JSON data
        if (empty($plugin_versions) || !is_array($plugin_versions)) {
            wp_send_json_error('Invalid data format');
        }

        // Save the plugin versions as a transient, cached for 24 hours
        set_transient('groffer_plugin_versions_cache', $plugin_versions, 86400);
        // Respond with success, including the source of the data
        wp_send_json_success("Plugin versions saved successfully from $source");
    }

    // Respond with success, including the source of the data
    wp_send_json_success("Plugins versions already added on the transient");
}

// Register the AJAX action for logged-in users only
add_action('wp_ajax_save_remote_plugin_versions', 'groffer_save_remote_plugin_versions_transient');

// Fetch the plugin versions once /day only when accessing the dashboard index.php
function groffer_save_plugin_versions_as_transient_ajax() {
    global $pagenow;
    //if ($pagenow === 'index.php') { ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    data: {
                        action: 'save_remote_plugin_versions',
                        _ajax_nonce: "<?php echo wp_create_nonce('save_remote_plugin_versions_nonce'); ?>"
                    },
                    success: function (response) {
                        if (response.success) {
                            console.log('Plugin versions saved successfully');
                        } else {
                            console.log('Error:', response.data);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log('AJAX error:', error);
                    }
                });
            });
        </script><?php
    //}
}
add_action('admin_footer', 'groffer_save_plugin_versions_as_transient_ajax');