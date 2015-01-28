<?php
/**
 * Plugin Name: Sucuri Flush
 * Plugin URI: https://wordpress.org/plugins/sucuri-flush
 * Description: When updating a WordPress page or post, a configurable URL can be called to clear the Sucuri Cache
 * Version: 1.0.0
 * Author: Richard Bevan
 * Author URI: https://www.restdeveloper.com
 * License: A short license name. Example: GPL2
 */

 /*  Copyright 2015 Richard Bevan (rbevan@restdeveloper.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class SucuriFlushSettingsPage
{
	/**
	* Holds the values to be used in the fields callbacks
	*/
	private $options;

	/**
	* Start up
	*/
	public function __construct()
	{
		$this->options = get_option( 'sucuri_flush' );
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'page_init' ) );
		add_action( 'save_post', array( $this, 'flush_sucuri' ) );
	}

	/**
	* Call URL
	*/
	public function flush_sucuri($ID)
	{
		//error_log(print_r($this->options, true));
		wp_remote_get($this->options['url']);
	}

	/**
	* Add options page
	*/
	public function add_plugin_page()
	{
		// This page will be under "Settings"
		add_options_page(
			'Settings Admin', 
			'Sucuri Flush', 
			'manage_options', 
			'my-setting-admin', 
			array( $this, 'create_admin_page' )
		  );
	}

	/**
	* Options page callback
	*/
	public function create_admin_page()
	{
		// Set class property
		?>
		<div class="wrap">
		<?php screen_icon(); ?>
		<h2>Sucuri Flush</h2>           
		<form method="post" action="options.php">
		<?php
		// This prints out all hidden setting fields
		settings_fields( 'sucuri_flush_group' );   
		do_settings_sections( 'my-setting-admin' );
		submit_button(); 
		?>
		</form>
		</div>
		<?php
	}

	/**
	* Register and add settings
	*/
	public function page_init()
	{        
		register_setting(
		'sucuri_flush_group', // Option group
		'sucuri_flush', // Option name
		array( $this, 'sanitize' ) // Sanitize
		);

		add_settings_section(
		'setting_section_id', // ID
		'A URL to call on page or post publish (inc updates)', // Title
		array( $this, 'print_section_info' ), // Callback
		'my-setting-admin' // Page
		);  

		add_settings_field(
		'url', 
		'Url', 
		array( $this, 'url_callback' ), 
		'my-setting-admin', 
		'setting_section_id'
		);      
	}

	/**
	* Sanitize each setting field as needed
	*
	* @param array $input Contains all settings fields as array keys
	*/
	public function sanitize( $input )
	{
		$new_input = array();

		if( isset( $input['url'] ) )
		$new_input['url'] = sanitize_text_field( $input['url'] );

		return $new_input;
	}

	/** 
	* Print the Section text
	*/
	public function print_section_info()
	{
		print 'When a Page or Post is Updated or Saved, the below URL will be called.';
	}

	/** 
	* Get the settings option array and print one of its values
	*/
	public function url_callback()
	{
		printf(
			'<input type="text" id="url" name="sucuri_flush[url]" value="%s" />',
			isset( $this->options['url'] ) ? esc_attr( $this->options['url']) : ''
		);
	}
}

if( is_admin() )
    $my_settings_page = new SucuriFlushSettingsPage();
