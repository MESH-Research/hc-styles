<?php
/**
 * Plugin Name: HC Styles
 * Plugin URI: https://github.com/mlaa/hc-styles
 * Description: Styles, templates, badges and more for Humanities Commons.
 *
 * Depends on the humanities-commons plugin: https://github.com/mlaa/humanities-commons
 */

namespace Humanities_Commons\Plugin\HC_Styles;

if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require( __DIR__ . '/vendor/autoload.php' );
} else {
	// TODO throw exception and/or provide autoloader. composer isn't here so we can't autoload without providing our own
}
//require_once 'autoload.php';

$Badges = new Badges;

add_filter( 'bp_init', [ $Badges, 'init' ] );
