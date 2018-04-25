<?php
add_filter( 'c5_fw_tgmpa', 'c5_fw_base_plugins' );
function c5_fw_base_plugins($plugins)
{
    $base_url ='https://s3-us-west-2.amazonaws.com/code125/';

    $plugins[] = array(
        'name'               => 'Code125 Theme Updates and Support',
        'slug'               => 'c5-updates-support',
        'source'             => $base_url . 'plugins/c5-updates-support-1.3.0.zip',
        'required'           => true,
        'version'            => '1.3.0',
        'force_activation'   => true,
        'force_deactivation' => true,
    );

    $plugins[] = array(
        'name'               => 'Code125 Custom Post Types',
        'slug'               => 'advanced-cpt',
        'source'             => $base_url . 'plugins/advanced-cpt-1.1.1.zip',
        'required'           => false,
        'version'            => '1.1.1',
        'force_activation'   => false,
        'force_deactivation' => true,
    );

    $plugins[] = array(
        'name'               => 'Yoast SEO', // The plugin name.
        'slug'               => 'wordpress-seo', // The plugin slug (typically the folder name).
        'required'           => false, // If false, the plugin is only 'recommended' instead of required.
    );
    return $plugins;
}

add_action( 'tgmpa_register', 'code125_register_required_plugins' );

function code125_register_required_plugins() {
	$plugins = array();
    $plugins = apply_filters( 'c5_fw_tgmpa', $plugins );

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'code125',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}
