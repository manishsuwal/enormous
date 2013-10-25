<?php
/**
 * enormous functions and definitions
 *
 * @package enormous
 * @since enormous 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since enormous 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 690; /* pixels */

if ( ! function_exists( 'enormous_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since enormous 1.0
 */
function enormous_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/extras.php' );

	/**
	 * Customizer additions
	 */
	require( get_template_directory() . '/inc/customizer.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on enormous, use a find and replace
	 * to change 'enormous' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'enormous', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'mycustomsize', 689, 200, true );

	/**
	* Background image and color customization
	*/
	$args = array(
	'default-color' => 'e9e0d1',
	);
	add_theme_support( 'custom-background', $args );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'enormous' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	* Enable support for Custom Header
	*/
	$args = array(
	'flex-width'    => true,
	'width'         => 1600,
	'flex-height'    => true,
	'height'        => 350,
	);
	add_theme_support( 'custom-header', $args );

}
endif; // enormous_setup
add_action( 'after_setup_theme', 'enormous_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since enormous 1.0
 */
function enormous_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar', 'enormous' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'enormous_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function enormous_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'enormous_scripts' );

/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );


//To link all Post Thumbnails on your website to the Post Permalink
add_filter( 'post_thumbnail_html', 'my_post_image_html', 10, 3 );

function my_post_image_html( $html, $post_id, $post_image_id ) {

  $html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_post_field( 'post_title', $post_id ) ) . '">' . $html . '</a>';
  return $html;

}

add_editor_style('editor-style.css');