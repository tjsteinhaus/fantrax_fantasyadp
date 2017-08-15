<?php
/**
 * Fantrax CSV ADP Download
 *
 * @since 1.1
 */

namespace Fantrax;

class CSV extends Setup {

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
	 * Renders the page in a csv format for download
	 *
	 * @since 1.1
	 *
	 * @param $request
	 */
	public static function render( $request ) {
		$csv = $_REQUEST[self::$csv_parameter];

		if( $csv == 'true' ) {
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

			self::set_headers();

			$csv = '"Rank","Player","Position","ADP"' . "\r\n";
			if( !empty( $data ) ) {
				$i = ( $atts['start'] == 0 ) ? 1 : $atts['start'];
				foreach( $data as $player ) {
					if( in_array( $atts['order'], array( 'NAME', 'ADP', 'name', 'adp' ) ) && !empty( $player->ADP ) ) {
						$csv .= '"'.$i.'",';
						$csv .= '"'.$player->name.'",';
						$csv .= '"'.$player->pos.'",';
						$csv .= '"'.$player->ADP.'"';
						$csv .= "\r\n";
						$i++;
					} elseif( in_array( $atts['order'], array( 'NAME', 'ADP_PPR', 'name', 'adp_ppr' ) ) && !empty( $player->ADP_PPR ) ) {
						$csv .= '"'.$i.'",';
						$csv .= '"'.$player->name.'",';
						$csv .= '"'.$player->pos.'",';
						$csv .= '"'.$player->ADP_PPR.'",';
						$csv .= "\r\n";
						$i++;
					}
				}
			}

			print mb_convert_encoding($csv, 'UTF-16LE', 'UTF-8');

			die();
		}
	}

	/**
	 * Set the headers that are required so the user
	 * can download the csv file.
	 *
	 * @since 1.1
	 */
	private static function set_headers() {
		header('Content-Encoding: UTF-8');
		header("Content-type: text/csv; charset=UTF-8");
		header("Content-Disposition: attachment; filename=adp.csv");
		header("Pragma: no-cache");
		header("Expires: 0");
	}
}