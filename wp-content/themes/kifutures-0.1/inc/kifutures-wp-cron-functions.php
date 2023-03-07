<?php
/**
 * Ki Futures WP Cron functions
 * 
 * @version 0.1
 ********************************************************************************
 */

/**
 * Import event data from KiPort
 *
 */
function kifutures_import_kiport_events() {

  require_once( 'kiport-te-api-functions.php' );

  //$params = array( 'start_date' => '2022-05-01' );
  $start_date = date('Y-m-01'); // first day of current month

  //$params = array( 'start_date' => '2022-05-01' );
  $params = array( 'start_date' => $start_date );

  $data = kifutures_kp_te_api_get_events ( $params );

  if(empty($data['events'])) return false;

  $dt = current_time('mysql', 1); // date & time stamp for inserted/updated events

  $total_rows_affected = array(
    'updated' => 0,
    'inserted' => 0
  );

  foreach($data['events'] as $event) {
    $rows_affected = kifutures_kp_te_api_insert_event($event,$dt);
    $total_rows_affected['updated'] = $total_rows_affected['updated'] + $rows_affected['updated'];
    $total_rows_affected['inserted'] = $total_rows_affected['inserted'] + $rows_affected['inserted'];
  }

  $msg = "Total rows updated: " . $total_rows_affected['updated'] . "\n";
  $msg .= "Total rows inserted: " . $total_rows_affected['inserted'] . "\n";

  //echo $msg;
}

/**
 * Add event to wp cron
 *
 */
if (!wp_next_scheduled('kifutures_import_kiport_events_event'))
  wp_schedule_event(time(), 'daily', 'kifutures_import_kiport_events_event');

add_action('kifutures_import_kiport_events_event', 'kifutures_import_kiport_events');

/**
 * Import user data from KiPort
 *
 */
function kifutures_import_kiport_users( $type ) {

  $debug = false; // set to true to enable debug output

  require_once('kiport-um-api-functions.php');

  $data = kifutures_kp_um_api_get_users( $type );

  if( $debug ) {
    kifutures_write_log( "DATA\n" );
    kifutures_write_log( $data );
  }

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

  if( $debug ) {
    kifutures_write_log("MESSAGE\n");
    kifutures_write_log($msg);
  }

  return $msg;
}

/**
 * Wrapper functions for import user data from KiPort
 *
 */
function kifutures_import_kiport_coaches() {
  $msg = kifutures_import_kiport_users( 'coach' );
}

function kifutures_import_kiport_champions() {
  $msg = kifutures_import_kiport_users( 'champion' );
}

function kifutures_import_kiport_institutes() {
  $msg = kifutures_import_kiport_users( 'institute' );
}

/**
 * Add events to wp cron
 *
 */
//if (!wp_next_scheduled('kifutures_import_kiport_users_event')) wp_schedule_event(time(), 'daily', 'kifutures_import_kiport_users_event');
//add_action('kifutures_import_kiport_users_event', 'kifutures_import_kiport_users');

if (!wp_next_scheduled('kifutures_import_kiport_coaches_event'))
  wp_schedule_event(time(), 'daily', 'kifutures_import_kiport_coaches_event');

add_action('kifutures_import_kiport_coaches_event', 'kifutures_import_kiport_coaches');

if (!wp_next_scheduled('kifutures_import_kiport_champions_event'))
  wp_schedule_event(time(), 'daily', 'kifutures_import_kiport_champions_event');

add_action('kifutures_import_kiport_champions_event', 'kifutures_import_kiport_champions');

if (!wp_next_scheduled('kifutures_import_kiport_institutes_event'))
  wp_schedule_event(time(), 'daily', 'kifutures_import_kiport_institutes_event');

add_action('kifutures_import_kiport_institutes_event', 'kifutures_import_kiport_institutes');

function kifutures_import_user_tags() {
}

function kifutures_import_user_user_tags() {
}	
