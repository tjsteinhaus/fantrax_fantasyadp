<?php

namespace Fantrax;

class Setup {

	/**
	 * API URL
	 *
	 * @var string
	 */
	private static $apiurl = 'https://www.fantrax.com/fxea/general/getAdp?';

	/**
	 * Shortcode Name
	 *
	 * @var string
	 */
	private static $shortcode = 'fantrax_table';

	/**
	 * Print Friendly URL Parameter
	 *
	 * @var string
	 * @since 1.1
	 */
	public static $print_parameter = 'printfriendly';

	/**
	 * CSV Download URL Parameter
	 *
	 * @var string
	 * @since 1.1
	 */
	public static $csv_parameter = 'csvdownload';

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
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'enqueueScriptsAndStyles' ) );
	}

	/**
	 * Enqueue the styles and scripts that are needed
	 * to output the table
	 *
	 * @since 1.0
	 * @author Tyler Steinhaus
	 */
	static public function enqueueScriptsAndStyles() {
		wp_register_style( 'fantrax-adp-style', FANTRAX_RELPATH . 'assets/css/style.css', null, true );
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
			'position' => '',
			'limit' => '100',
			'start' => '0',
			'order' => 'ADP', // ADP, ADP_PPR, NAME
		), $atts );

		wp_enqueue_style( 'fantrax-adp-style' );

		$url = self::buildApiUrl( $atts );
		$print_url = self::buildPrintUrl( $atts );
		$csv_url = self::buildCsvDownloadUrl( $atts );

		$data = self::callApi( $url );

		if( !$data ) {
			return 'The data doesn\'t exist in the api.';
		}

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
	static protected function buildApiUrl( $parameters ) {

		$encode_parameters = http_build_query( $parameters );

		return self::$apiurl . $encode_parameters;
	}

	/**
	 * Build Print URL with given parameters
	 *
	 * @since 1.1
	 * @author Tyler Steinhaus
	 */
	static private function buildPrintUrl( $parameters ) {
		$encode_parameters = http_build_query( $parameters );

		$permalink = get_permalink();

		if( strpos( $permalink, '?' ) ) {
			return $permalink . '&' . self::$print_parameter . '=true&' . $encode_parameters;
		} else {
			return $permalink . '?' . self::$print_parameter . '=true&' . $encode_parameters;
		}
	}

	/**
	 * Build Print URL with given parameters
	 *
	 * @since 1.1
	 * @author Tyler Steinhaus
	 */
	static private function buildCsvDownloadUrl( $parameters ) {
		$encode_parameters = http_build_query( $parameters );

		$permalink = get_permalink();

		if( strpos( $permalink, '?' ) ) {
			return $permalink . '&' . self::$csv_parameter . '=true&' . $encode_parameters;
		} else {
			return $permalink . '?' . self::$csv_parameter . '=true&' . $encode_parameters;
		}
	}

	/**
	 * Gather the data from the API so we can pass it
	 * to our shortcodes view.
	 *
	 * @since 1.0
	 * @author Tyler Steinhaus
	 */
	static protected function callApi( $api_url ) {

		$request = wp_remote_get( $api_url );
		$body = wp_remote_retrieve_body( $request );

		if( !empty( $body ) ) {

			$request = json_decode( $request['body'] );

			return $request;
		} else {
			return false;
		}
	}


}