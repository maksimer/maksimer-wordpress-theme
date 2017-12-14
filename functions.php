<?php
	/*
	 * Theme setup
	*/
	function maksimer_theme_setup() {
		// Load textdomain
		load_theme_textdomain( 'maksimer_lang', get_template_directory() . '/assets/languages' );

		// Declare theme support
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'menus' );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-logo', array(
			'height'      => 80,
			'width'       => 200,
			'flex-height' => true,
			'flex-width'  => true,
		) );

		add_editor_style();

		// Changes default images values
		update_option( 'image_default_align', 'none' );
		update_option( 'image_default_link_type', 'none' );
		update_option( 'image_default_size', 'large' );

		set_post_thumbnail_size( 300, 300, true );
		// add_image_size( 'example', 220, 220, array( 'left', 'top' ) );

		// Register menus
		register_nav_menus( array(
			'main-menu' => __( 'Main menu', 'maksimer_lang' ),
		) );
	}
	add_action( 'after_setup_theme', 'maksimer_theme_setup' );





	/*
	 * Customizing the admin sidebar
	*/
	function maksimer_customize_sidebar_menu() {
		remove_menu_page( 'index.php' );
		remove_menu_page( 'separator1' );
		remove_menu_page( 'upload.php' );
		remove_menu_page( 'edit-comments.php' );
		remove_submenu_page( 'themes.php', 'customize.php' );
		remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
		add_management_page( __( 'Updates', 'maksimer_lang' ), __( 'Updates', 'maksimer_lang' ), 'update_core', 'update-core.php' );

		if ( ! current_user_can( 'administrator' ) ) {
			remove_menu_page( 'wpcf7' );
			remove_menu_page( 'tools.php' );
			remove_menu_page( 'edit.php?post_type=acf-field-group' );
			remove_menu_page( 'themes.php' );
			add_menu_page( __( 'Menu' ), __( 'Menu' ), 'edit_theme_options', 'nav-menus.php', '', 'dashicons-menu', 60 );
		}
	}
	add_action( 'admin_menu', 'maksimer_customize_sidebar_menu' );





	/*
	 * Enqueue's all the scripts
	*/
	function maksimer_enqueue_scripts() {
		wp_enqueue_style( 'style', get_stylesheet_uri(), false, filemtime( get_theme_file_path( 'style.css' ) ), 'all' );
		wp_enqueue_script( 'maksimer', get_theme_file_uri( 'assets/js/min/maksimer.min.js' ), array( 'jquery' ), filemtime( get_theme_file_path( 'assets/js/min/maksimer.min.js' ) ) );

		if ( ! is_admin() ) {
			wp_enqueue_script( 'analytics', get_theme_file_uri( 'assets/js/originals/analytics.js' ), array( 'jquery' ), filemtime( get_theme_file_path( 'assets/js/originals/analytics.js' ) ), true );
		}
	}
	add_action( 'wp_enqueue_scripts', 'maksimer_enqueue_scripts', 11 );





	/*
	 * Enqueue admin-scripts
	*/
	function maksimer_admin_enqueue() {
		if ( is_admin() ) {
			wp_enqueue_style( 'maksimer_admin_css', get_template_directory_uri() . '/assets/css/admin.css' );
		}
	}
	add_action( 'admin_enqueue_scripts', 'maksimer_admin_enqueue' );





	/*
	 * Change yoast metabox priority
	*/
	function maksimer_wpseo_metabox_priority() {
		return 'low';
	}
	add_filter( 'wpseo_metabox_prio', 'maksimer_wpseo_metabox_priority' );





	/*
	 * Manage the admin bar, front-end
	*/
	function maksimer_admin_bar() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu( 'widgets' );
		$wp_admin_bar->remove_menu( 'wpseo-menu' );
		$wp_admin_bar->remove_menu( 'wp-logo' );
		$wp_admin_bar->remove_menu( 'dashboard' );
		$wp_admin_bar->remove_menu( 'themes' );
		$wp_admin_bar->remove_menu( 'menus' );
		$wp_admin_bar->remove_menu( 'comments' );
		$wp_admin_bar->remove_menu( 'new-user' );
		$wp_admin_bar->remove_menu( 'new-media' );
	}
	add_action( 'wp_before_admin_bar_render', 'maksimer_admin_bar' );





	/*
	 * Modify the customizer (remove css editor)
	*/
	function maksimer_customize_register( $wp_customize ) {
		$wp_customize->remove_control( 'custom_css' );
	}
	add_action( 'customize_register', 'maksimer_customize_register' );





	/*
	 * Work-around for Microsoft Edge bug squeezing images
	 *
	 *  https://developer.microsoft.com/en-us/microsoft-edge/platform/issues/7778808/
	*/
	function maksimer_edge_browser_fix() {
		global $is_edge;
		if( $is_edge ){
			add_filter( 'wp_calculate_image_srcset', '__return_false' );
		}
	}
	add_action( 'init', 'maksimer_edge_browser_fix' );
