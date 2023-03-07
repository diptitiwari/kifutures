<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package kifutures-0.1
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function kifutures_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'kifutures_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function kifutures_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'kifutures_pingback_header' );

/**
 * Create JSON-encoded array containing country select options
 *
 * @param string $template - page template slug
 * @return array - JSON-encoded array of option value/label pairs
 */
function kifutures_build_countries_json_array( $template ) {
  global $wpdb;

  if( 'coaches-template.php' == $template ) {
    $types_sql = "= 'coach'";
  } else {
    $types_sql = "IN('institute', 'champion')";
  } 

  $sql = "SELECT DISTINCT country
	    FROM {$wpdb->prefix}pods_kiport_users
            WHERE user_type {$types_sql}
            ORDER BY country";

  $results = $wpdb->get_results( $sql );
  //print_r( $results );

  $countries = array();
  if( $results ) {
    $i = 0;
    foreach( $results as $result ) {
      if( '' == $result->country ) continue;
      $i++;
      $opt = array( 'value' => $result->country, 'label' => $result->country );
      $countries[] = $opt; 
    }
  }
        
  return json_encode( $countries );
}

/**
 * Create JSON-encoded array containing languages select options
 *
 * @param string $template - page template slug
 * @return array - JSON-encoded array of option value/label pairs
 */
function kifutures_build_languages_json_array( $template ) {
  global $wpdb;

  if( 'coaches-template.php' == $template ) {
    $types_sql = "= 'coach'";
  } else {
    $types_sql = "IN('institute', 'champion')";
  }

  $sql = "SELECT DISTINCT languages FROM {$wpdb->prefix}pods_kiport_users WHERE user_type {$types_sql}";

  $results = $wpdb->get_results( $sql );

  $languages = array();
  if( $results ) {
    $i = 0;
    foreach( $results as $result ) {
      if( '' == $result->languages ) continue;
      $i++;
      $us_langs = unserialize( $result->languages );

      foreach( $us_langs as $us_lang ) {
        $opt = array( 'value' => $us_lang, 'label' => $us_lang );
	if( !in_array( $opt, $languages ) ) $languages[] = $opt;
      }
    }
  }
  array_multisort( $languages );

  return json_encode( $languages );
}

/**
 * Create JSON-encoded array containing sustainability/professional interests select options
 *
 * @param string $template - page template slug
 * @return array - JSON-encoded array of option value/label pairs
 */
function kifutures_build_interests_json_array( $template, $arena ) {
  global $wpdb;

  if( 'coaches-page.php' == $template ) {
    $types_sql = "= 'coach'";
  } else {
    $types_sql = "IN('institute', 'champion')";
  }

  if( 'sustainability' == $arena ) {
    $tag_type_abbr = 's';
  } else {
    $tag_type_abbr = 'p';
  }

    $sql = "
SELECT
  pkut.tag_id,
  pkut.name
FROM {$wpdb->prefix}pods_kiport_user_tags AS pkut
  LEFT JOIN
    {$wpdb->prefix}pods_kiport_user_user_tag AS pkuut ON pkut.tag_id = pkuut.tag_id
  LEFT JOIN
    {$wpdb->prefix}pods_kiport_users AS pku ON pkuut.user_id = pku.user_id
  WHERE 1=1
    AND pkut.tag_type_abbr = '{$tag_type_abbr}'
  GROUP BY pkut.tag_id
  ORDER BY pkut.name";

  $interests = array(); 

  $results = $wpdb->get_results( $sql );

  if( $results ) {
    foreach( $results as $result ) {
      $opt = array( 'value' => $result->tag_id, 'label' => $result->name );
      $interests[] = $opt;  
    }
  }

  return json_encode( $interests );
}

/**
 * Create JSON-encoded array containing user types select options
 *
 * @param string $template - page template slug
 * @return array - JSON-encoded array of option value/label pairs
 */
function kifutures_build_user_types_json_array( $template ) {
  global $wpdb;

  if( 'the-network-page.php' == $template ) {
    $types_sql = "IN('institute', 'champion')";
  } else {
    $types_sql = "IN('coach')";
  }

    $sql = "
SELECT DISTINCT pku.user_type
FROM {$wpdb->prefix}pods_kiport_users AS pku
  WHERE 1=1
    AND pku.user_type {$types_sql}
  ORDER BY pku.user_type";

  $user_types = array();

  $results = $wpdb->get_results( $sql );

  if( $results ) {
    foreach( $results as $result ) {
      $opt = array( 'value' => $result->user_type, 'label' => ucwords( $result->user_type ) );
      $user_types[] = $opt;
    }
  }

  return json_encode( $user_types );
}
