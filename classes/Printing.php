<?php
/**
 * Print Friendly
 *
 * @since 1.1
 */

namespace Fantrax;

class Printing extends Setup {

	/**
	 * Setup constructor.
	 */
	private function __construct() {}

	/**
	 * Init
	 *
	 * @since 1.0
	 */
	public static function init() {
		add_action( 'parse_request', array( __CLASS__, 'render' ) );
	}

	/**
	 * Renders the table in a basic format for printing
	 *
	 * @since 1.1
	 *
	 * @param $request
	 */
	public static function render( $request ) {
		$print = $_REQUEST[self::$print_parameter];

		if( $print == 'true' ) {
			wp_enqueue_style( 'fantrax-adp-style' );

			$atts = array(
				'sport' => esc_attr( $_REQUEST['sport'] ),
				'position' => esc_attr( $_REQUEST['position'] ),
				'limit' => esc_attr( $_REQUEST['limit'] ),
				'start' => esc_attr( $_REQUEST['start'] ),
				'order' => esc_attr( $_REQUEST['order'] )
			);

			$url = self::buildApiUrl( $atts );

			$data = self::callApi( $url );

			if( !$data ) {
				echo 'The data doesn\'t exist in the api.';
				die();
			}


			require FANTRAX_ABSPATH . 'views/print_output.php';
			die();
		}
	}

}