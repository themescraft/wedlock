<?php
/**
 * Wedlock functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Wedlock
 */

if ( ! function_exists( 'wedlock_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function wedlock_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Wedlock, use a find and replace
	 * to change 'wedlock' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'wedlock', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	/*
	 * Enable support for site logo.
	 */
	add_image_size( 'logo', 270, 60 );
	add_theme_support( 'custom-logo', array( 'size' => 'logo', 'flex-height' => true, 'flex-width'  => true, 'header-text' => array( 'site-title', 'site-description' ) ) );

	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'wedlock' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'wedlock_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif;
add_action( 'after_setup_theme', 'wedlock_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wedlock_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wedlock_content_width', 640 );
}
add_action( 'after_setup_theme', 'wedlock_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wedlock_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'wedlock' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'wedlock_widgets_init' );


if ( ! function_exists( 'wedlock_fonts_url' ) ) :
/**
 * Register Google fonts for Wedlock.
 *
 * Create your own wedlock_fonts_url() function to override in a child theme.
 *
 * @since Wedlock 1.0.2
 *
 * @return string Google fonts URL for the theme.
 */
function wedlock_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'cyrillic,latin,latin-ext';
	
	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Cinzel: on or off', 'wedlock' ) ) {
		$fonts[] = 'Cinzel:400,700';
	}
	/* translators: If there are characters in your language that are not supported by Open Sans, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'PT Sans font: on or off', 'wedlock' ) ) {
		$fonts[] = 'PT+Sans:400,400italic,700,700italic';
	}
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}
	return $fonts_url;
}
endif;



/**
 * Enqueue scripts and styles.
 */
function wedlock_scripts() {
	//Stylesheets
	wp_enqueue_style( 'wedlock-style', get_stylesheet_uri() );
	wp_enqueue_style( 'gumby-style', get_template_directory_uri() . '/css/gumby.css', array(), '20151215', false );
	wp_enqueue_style( 'wedlock-fonts', wedlock_fonts_url(), array(), null);  

	// Default Scripts Included and Registered by WordPress
	wp_enqueue_script( 'jquery' );	
	wp_enqueue_script( 'masonry' );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	//Modernizr Gumbuy-build
	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/libs/modernizr.js', array('jquery' ), '20151215', false );

	//Gumby library
	wp_enqueue_script( 'gumby', get_template_directory_uri() . '/js/libs/gumby.js', array(), '20151215', true );	
	wp_enqueue_script( 'gumby-fixed', get_template_directory_uri() . '/js/libs/ui/gumby.fixed.js', array(), '20151215', true );
	wp_enqueue_script( 'gumby-toggleswitch', get_template_directory_uri() . '/js/libs/ui/gumby.toggleswitch.js', array(), '20151215', true );
	wp_enqueue_script( 'gumby-navbar', get_template_directory_uri() . '/js/libs/ui/gumby.navbar.js', array(), '20151215', true );
	wp_enqueue_script( 'gumby-init', get_template_directory_uri() . '/js/libs/gumby.init.js', array('jquery'), '20151215', true );
	wp_enqueue_script( 'gumby-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '20151215', true );

}
add_action( 'wp_enqueue_scripts', 'wedlock_scripts' );

/**
 * TGMPA
 */
require get_template_directory() . '/inc/tgmpa-init.php';

/**
 *
 * Implement the Custom Walker.
 */
require get_template_directory() . '/inc/custom-menu-walker.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
