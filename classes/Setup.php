<?php

namespace Fantrax;

class Setup {

	/**
	 * API URL
	 *
	 * @var string
	 */
	private static $apiurl = '';

	/**
	 * Shortcode Name
	 *
	 * @var string
	 */
	private static $shortcode = 'fantrax_table';

	/**
	 * Setup constructor.
	 */
	private function __construct() {}

	/**
	 * Start up for Fantrax Fantasy ADP
	 * Runs in the WordPress init action
	 *
	 * @since 1.0
	 * @author Tyler Steinhaus
	 */
	static public function init() {
		add_shortcode( self::$shortcode, array( __CLASS__, 'buildShortcodeOutput' ) );
	}

	/**
	 * Build the shortcodes output to the front end
	 * of the website.
	 *
	 * @since 1.0
	 * @author Tyler Steinhaus
	 */
	static public function buildShortcodeOutput( $atts, $content = null ) {

		$atts = shortcode_atts( array(
			'sport' => 'NFL',
			'position' => 'QB',
			'limit' => '100',
			'start' => '0',
			'order' => 'ASC',
			'orderby' => 'player_name'
		), $atts );

		self::buildApiUrl( $parameters );

		$data = self::callApi();

		ob_start();

		require FANTRAX_ABSPATH . 'views/table_output.php';

		return ob_get_clean();

	}

	/**
	 * Build API URL with given parameters
	 *
	 * @since 1.0
	 * @author Tyler Steinhaus
	 */
	static private function buildApiUrl( $parameters ) {

		$encode_parameters = http_build_query( $parameters );

		self::$apiurl = self::$apiurl . $encode_parameters;
	}

	/**
	 * Gather the data from the API so we can pass it
	 * to our shortcodes view.
	 *
	 * @since 1.0
	 * @author Tyler Steinhaus
	 */
	static private function callApi() {
		$api_url = self::$apiurl;

		$request = wp_remote_get( $api_url );

		return $request;
	}


}