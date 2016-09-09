<?php
/**
 * Plugin Name: MLA Society Styles
 * Description: Add brand styles to each society site in the Humanities Commons network.
 */

namespace MLA\Commons\Plugin\SocietyStyles;

function insert_network_logo( $arg ) {
	$main_network = \wp_get_network( \get_main_network_id() );
	$hc_logo_src = \plugins_url() . '/mla-society-styles/assets/hc_july8_smaller.png';

	$html = '<a id="logo-hc" href="https://' . $main_network->domain . '">';
	$html .= "<img src=\"$hc_logo_src\">";
	$html .= '</a>';

	echo $html;
}
if ( \get_network_option( '', 'society_id' ) !== 'hc' ) {
	\add_action( 'open_header',  __NAMESPACE__ . '\\insert_network_logo' );
}

function enqueue_style() {
	\wp_enqueue_style( 'mla_society_styles', \plugins_url() . '/mla-society-styles/css/style.css' );
}
\add_action( 'wp_enqueue_scripts',  __NAMESPACE__ . '\\enqueue_style' );
