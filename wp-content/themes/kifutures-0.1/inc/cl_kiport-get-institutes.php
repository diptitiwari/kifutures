#!/usr/bin/php
<?php
/**
 * Wrapper to run kiport UM data import from CLI
 *
 */

//set up WP environment 
function kifutures_get_wordpress_base_path() {
  $dir = dirname(__FILE__);
  do {
    if( file_exists($dir."/wp-config.php") ) {
      return $dir;
    }
  } while( $dir = realpath("$dir/..") );
  return null;
}

define( 'XBASE_PATH', kifutures_get_wordpress_base_path()."/" );
define('WP_USE_THEMES', false);
global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;

require(XBASE_PATH . 'wp-load.php');

$cron  = get_option('cron');

require_once('kiport-um-api-functions.php');

$type = 'institute';

$data = kifutures_kp_um_api_get_users( $type );
//print_r($data);
//exit;

if(empty($data)) return false;

$dt = current_time('mysql', 1); // date & time stamp for inserted/updated events

$total_rows_affected = array(
  'updated' => 0,
  'inserted' => 0
);

foreach($data as $user) {
  $rows_affected = kifutures_kp_um_api_insert_user($user, $type, $dt);
  $total_rows_affected['updated'] = $total_rows_affected['updated'] + $rows_affected['updated'];
  $total_rows_affected['inserted'] = $total_rows_affected['inserted'] + $rows_affected['inserted'];
}

$msg = "Total rows updated: " . $total_rows_affected['updated'] . "\n";
$msg .= "Total rows inserted: " . $total_rows_affected['inserted'] . "\n";

$rows_deleted = kifutures_delete_stale_users_by_type( $type, $dt );
$msg .= "Stale rows deleted: " . $rows_deleted . "\n";

echo $msg;
