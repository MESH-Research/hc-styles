<?php

namespace Humanities_Commons\Plugin\HC_Styles;

use \Humanities_Commons;

class Badges {

	const MIN_IMG_WIDTH = 50; // img tags with a width less than this will not get badges

	function __construct() {

		wp_register_style( 'hc-styles', plugins_url( '/hc-styles/css/badges.css' ) );

		add_filter( 'bp_init', [ $this, 'init' ] );

	}

	function add_member_badges( $img ) {
		/**
		 * member profile requires bp_get_displayed_user*()
		 * member directory requires bp_get_member*()
		 */
		if ( $user = bp_get_displayed_user() ) {
			$user_id = $user->id;
		} else {
			$user_id = bp_get_member_user_id();
		}

		return $this->add_badges( bp_get_member_type( $user_id, false ), $img );
	}

	function add_group_badges( $img ) {
		// group_id for directory, current_group_id for single
		$group_id = bp_get_group_id();
		if ( empty( $group_id ) ) {
			$group_id = bp_get_current_group_id();
		}

		return $this->add_badges( bp_groups_get_group_type( $group_id, false ), $img );
	}

	function add_blog_badges( $img ) {
		$blog_details = get_blog_details( [ 'blog_id' => bp_get_blog_id() ] );
		$society_id = get_network_option( $blog_details->site_id, 'society_id' );

		// expect get_network_option() to return a string, so cast to array for add_badges() loop compatibility
		return $this->add_badges( (array) $society_id, $img );
	}

	/**
	 * helper function used in member, group, & blog contexts
	 */
	function add_badges( $types, $img ) {
		preg_match( '/width="(\d+)"/', $img, $img_width );

		if ( isset( $img_width[1] ) && $img_width[1] < self::MIN_IMG_WIDTH ) {
			return $img;
		}

		$badges = '';

		if ( $types ) {
			foreach ( $types as $type ) {
				$url = ( defined( 'HC_SITE_URL' ) ) ? HC_SITE_URL : get_blogaddress_by_id( \Humanities_Commons::$main_site->blog_id );

				if ( $type !== 'hc' ) {
					$url = 'https://' . $type . '.' . str_replace( 'https://', '', $url );
				}

				$badges .= "<a class=\"society-badge-wrap\" href=\"$url\"><span class=\"society-badge $type\"></span></a>";
			}
		}

		return $badges . $img;
	}

	function enqueue_style() {
		wp_enqueue_style( 'hc-styles' );
	}

	function init() {

		if ( bp_is_members_directory() || bp_is_user_profile() ) {

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
			add_filter( 'bp_member_avatar', [ $this, 'add_member_badges' ] );

		} else if ( bp_is_groups_directory() || bp_is_group() ) {

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
			add_filter( 'bp_get_group_avatar', [ $this, 'add_group_badges' ] );

		} else if ( bp_is_blogs_directory() ) {

			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_style' ] );
			add_filter( 'bp_get_blog_avatar', [ $this, 'add_blog_badges' ], 20 );

		}

	}

}
