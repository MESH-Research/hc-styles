<?php

namespace Humanities_Commons\Plugin\HC_Styles;

use \Humanities_Commons;
use \RecursiveDirectoryIterator;
use \RecursiveIteratorIterator;
use \RecursiveRegexIterator;
use \RegexIterator;

class Template {

	/**
	 * paths to commonly used directories
	 */
	public static $plugin_dir;
	public static $plugin_templates_dir;

	function __construct() {

		self::$plugin_dir = \plugin_dir_path( realpath( __DIR__ ) );
		self::$plugin_templates_dir = \trailingslashit( self::$plugin_dir . 'templates' );

		add_filter( 'load_template', [ $this, 'filter_load_template' ] );

	}


	public function filter_load_template( $path ) {
		$iterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( self::$plugin_templates_dir ) );
		$template_files = new RegexIterator( $iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH );

		foreach( $template_files as $name => $object ){
			$our_slug = str_replace( self::$plugin_templates_dir, '', $name );

			if ( strpos( $path, $our_slug ) !== false ) {
				return $name;
			}
		}

		return $path;
	}

}
