<?php

/**
 * kifutures-0.1 functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package kifutures
 * @version 0.1
 */

if (!defined('_S_VERSION')) {
  // Replace the version number of the theme on each release.
  define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function kifutures_setup()
{
  /*
   * Make theme available for translation.
   * Translations can be filed in the /languages/ directory.
   * If you're building a theme based on kifutures-0.1, use a find and replace
   * to change 'kifutures' to the name of your theme in all the template files.
   */
  load_theme_textdomain('kifutures', get_template_directory() . '/languages');

  // Add default posts and comments RSS feed links to head.
  add_theme_support('automatic-feed-links');

  /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
  add_theme_support('title-tag');

  /*
   * Enable support for Post Thumbnails on posts and pages.
   *
   * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
   */
  add_theme_support('post-thumbnails');

  // This theme uses wp_nav_menu() in one location.
  register_nav_menus(
    array(
      'menu-1' => esc_html__('Primary', 'kifutures'),
      'FM-1' => __('Footer Menu 1'),
      'FM-2' => __('Footer Menu 2'),
      'footer-social' => __('Footer Social Media'),
    )
  );

  /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
  add_theme_support(
    'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
    )
  );

  // Set up the WordPress core custom background feature.
  add_theme_support(
    'custom-background',
    apply_filters(
      'kifutures_custom_background_args',
      array(
        'default-color' => 'ffffff',
        'default-image' => '',
      )
    )
  );

  // Add theme support for selective refresh for widgets.
  add_theme_support('customize-selective-refresh-widgets');

  /**
   * Add support for core custom logo.
   *
   * @link https://codex.wordpress.org/Theme_Logo
   */
  add_theme_support(
    'custom-logo',
    array(
      'height'      => 250,
      'width'       => 250,
      'flex-width'  => true,
      'flex-height' => true,
    )
  );
}
add_action('after_setup_theme', 'kifutures_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function kifutures_content_width()
{
  $GLOBALS['content_width'] = apply_filters('kifutures_content_width', 640);
}
add_action('after_setup_theme', 'kifutures_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function kifutures_widgets_init()
{
  register_sidebar(
    array(
      'name'          => esc_html__('Sidebar', 'kifutures'),
      'id'            => 'sidebar-1',
      'description'   => esc_html__('Add widgets here.', 'kifutures'),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}
add_action('widgets_init', 'kifutures_widgets_init');

/**
 * Get all fields from a custom settings pod
 * 
 * @param int $pod - pod ID
 * @return object $fields - pod fields
 */
function kifutures_get_pods_custom_settings($pod)
{

  if (!function_exists('pods')) return;
  //echo "XXX", $pod; // uncomment for debugging
  $fields = pods($pod);
  //echo "FIELDS\n"; print_r($fields);
  $fields = $fields->row;
  return $fields;
}

/**
 * Set global variables used in theme
 *
 * @return void
 */
add_action('after_setup_theme', 'kifutures_set_global_vars', 15);

function kifutures_set_global_vars()
{

  if (!function_exists('pods')) return;

  global $KIFUTURES_THEME_OPTIONS;

  $KIFUTURES_THEME_OPTIONS = kifutures_get_pods_custom_settings('kifutures_theme_options');
}

/**
 * Add inline JS to <head> to set various window.<something> vars to <head>
 * 
 * @return void
 */
add_action('wp_head', 'kifutures_echo_head_js_data_vars');

function kifutures_echo_head_js_data_vars()
{
  global $post, $page_template_slug;

  $page_template_slug = str_replace('template/', '', get_page_template_slug());

  $templates = array(
    'coaches-page.php',
    'the-network-page.php'
  );

  if (!in_array($page_template_slug, $templates)) return;

  $output  = '<script type="text/javascript">' . "\n";

  switch ($page_template_slug) {
    case 'coaches-page.php':
      $output .= 'window.countries = ' . kifutures_build_countries_json_array($page_template_slug) . ';' . "\n";
      $output .= 'window.languages = ' . kifutures_build_languages_json_array($page_template_slug) . ';' . "\n";
      $output .= 'window.sustainability_interests = ' . kifutures_build_interests_json_array($page_template_slug, 'sustainability') . ';' . "\n";
      $output .= 'window.professional_interests = ' . kifutures_build_interests_json_array($page_template_slug, 'professional') . ';' . "\n";
      break;

    case 'the-network-page.php':
      $output .= 'window.countries = ' . kifutures_build_countries_json_array($page_template_slug) . ';' . "\n";
      $output .= 'window.user_types = ' . kifutures_build_user_types_json_array($page_template_slug) . ';' . "\n";
      break;
  }

  $output .= '</script>' . "\n";

  echo $output;
}

/**
 * Enqueue scripts and styles.
 */
function kifutures_scripts()
{
  wp_enqueue_style('kifutures-style', get_stylesheet_uri(), array(), _S_VERSION);
  wp_style_add_data('kifutures-style', 'rtl', 'replace');
  wp_enqueue_script('kifutures-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);

  // 3D Party JS
  wp_enqueue_script('kifutures-moment_js', get_template_directory_uri() . '/js/vendor/moment.js', array('jquery'), '1.0.1', true);

  // Custom JS
  wp_enqueue_script('kifutures-global_js', get_template_directory_uri() . '/js/app/global.js', array('jquery'), '1.0.1', true);
  wp_enqueue_script('kifutures-events_js', get_template_directory_uri() . '/js/app/events-page.js', array('jquery'), '1.0.1', true);
  wp_enqueue_script('kifutures-coache_js', get_template_directory_uri() . '/js/app/coache-page.js', array('jquery'), '1.0.1', true);

  if (is_singular() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', 'kifutures_scripts');

/**
 * Enqueue theme override style
 */
add_action('wp_enqueue_scripts', 'kifutures_theme_styles', 999);

function kifutures_theme_styles()
{
  wp_enqueue_style('kifutures-main-style', get_template_directory_uri() . '/css/main.css', array('kifutures-style'), '0.1');
}

/**
 * Add theme-specific class to body classes
 *
 */
add_filter('body_class', 'kifutures_body_class');

function kifutures_body_class($classes)
{
  $classes[] = 'kifutures';

  return $classes;
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
  require get_template_directory() . '/inc/jetpack.php';
}

/**
 * WP Cron functions.
 */
require get_template_directory() . '/inc/kifutures-wp-cron-functions.php';

/**
 * Register custom JSON API routes
 *
 */
add_action('rest_api_init', function () {
  include_once 'inc/kifutures-wp-json-api-controller.php';
  $KIFUTURES_JSON_API_Controller = new KIFUTURES_JSON_API_Controller();
  $KIFUTURES_JSON_API_Controller->register_routes();
});

/**
 * Write to WP error log
 *
 */
if (!function_exists('kifutures_write_log')) {
  function kifutures_write_log($log)
  {
    if (is_array($log) || is_object($log)) {
      error_log(print_r($log, true));
    } else {
      error_log($log);
    }
  }
}