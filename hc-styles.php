<?php
/**
 * Plugin Name: HC Styles
 * Plugin URI: https://github.com/mlaa/hc-styles
 * Description: Styles, templates, badges and more for Humanities Commons.
 *
 * Depends on the humanities-commons plugin: https://github.com/mlaa/humanities-commons
 */

namespace Humanities_Commons\Plugin\HC_Styles;

require_once( __DIR__ . '/vendor/autoload.php' );

// initialize badges by instantiating
$Badges = new Badges;

// initialize template override functionality by instantiating
$Template = new Template;

$theme = wp_get_theme();

$theme_name = strtolower( $theme->get( 'Name' ) );

if('dispatch' === $theme_name ) {
  wp_register_style( 'hc-styles-dispatch', plugins_url( '/hc-styles/css/dispatch-override.css' ) );
  wp_enqueue_style( 'hc-styles-dispatch' );
}
