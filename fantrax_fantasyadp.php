<?php
/*
Plugin Name: Fantrax Fantasy ADP
Plugin URI: https://fantrax.com
Description: Allows Fantrax to embed tables with sports data from their api
Version: 1.1
Author: Tyler Steinhaus
Author URI: https://tylersteinhaus.com
Author email: tjsteinhaus@gmail.com
Text Domain: fantrax_fantasyadp
*/

namespace Fantrax;

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

// Define certain plugin variables as constants.
define( 'FANTRAX_ABSPATH', plugin_dir_path( __FILE__ ) );
define( 'FANTRAX_RELPATH', plugin_dir_url( __FILE__ ) );
define( 'FANTRAX__FILE__', __FILE__ );
define( 'FANTRAX_BASENAME', plugin_basename( FANTRAX__FILE__ ) );

require FANTRAX_ABSPATH . 'classes/Setup.php';
require FANTRAX_ABSPATH . 'classes/Printing.php';
require FANTRAX_ABSPATH . 'classes/CSV.php';


add_action( 'init', array( '\Fantrax\Setup', 'init' ) );
add_action( 'init', array( '\Fantrax\Printing', 'init' ) );
add_action( 'init', array( '\Fantrax\CSV', 'init' ) );