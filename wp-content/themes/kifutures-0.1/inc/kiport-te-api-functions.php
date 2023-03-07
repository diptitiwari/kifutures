<?php
/**
 * Kiport Tribe Events API Functions
 *
 * Update local user data with Tribe Events event data from KiPort server
 *
 * @author Anthony Cullen - Feathered Owl Technology
 * @link: https://www.featheredowl.com
 * @version 0.1
 * @global $KIFUTURES_THEME_OPTIONS - Ki Futures theme options, set in functions.php
 ******************************************************************************************
 */

/**
 * API call
 * 
 * @param string $url - url for curl request
 * @param string $query - query args for curl request
 * @return array $arr - json encoded query response
 */
function kifutures_kp_te_api_call($url,$query) {
  //echo $url . $query;
  global $KIFUTURES_THEME_OPTIONS;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
  curl_setopt($ch, CURLOPT_REFERER, $KIFUTURES_THEME_OPTIONS['te_api_base_url']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  $info = curl_getinfo($ch);
  curl_close($ch);
  $arr = json_decode($output, 1);
  return $arr;
}

/**
 * Get events
 *
 * @return array $events - json encoded events data
 */
function kifutures_kp_te_api_get_events( $params=array() ) {
  global $KIFUTURES_THEME_OPTIONS;

  $url = $KIFUTURES_THEME_OPTIONS['te_api_base_url'] . $KIFUTURES_THEME_OPTIONS['te_api_events_endpoint'];
  $query = http_build_query( $params );

  $events = kifutures_kp_te_api_call( $url, $query );

  return $events;
}

/**
 * Insert/update event data from KiPort server into local kiport_events table
 *
 * @param array $event - event data
 * @param string $dt - current date/time
 * @return array - rows inserted | rows updated 
 */
function kifutures_kp_te_api_insert_event($event, $dt) {

  $debug = false;

  if($debug) {
    echo "EVENT\n";
    print_r( $event );
    echo "\n";
  }

  global $wpdb;

  if(!empty($event['categories'])) {
    $category = $event['categories'][0]['name']; // first category only
    $category_slug = $event['categories'][0]['slug'];
  } else {
    $category = $category_slug = '';
  }

  if( !empty( $event['hosts'] ) ) {
    $host_ids = array();
    foreach( $event['hosts'] as $host ) {
      $host_ids[] = $host['id'];
    }
    $host_ids = implode( ',', $host_ids );
  } else {
    $host_ids = '';
  }

  $xsql = $wpdb->prepare( "SELECT * from " . $wpdb->prefix . "pods_kiport_events WHERE event_id = %d", $event['id'] );

  if($debug) echo $xsql;

  $rows_found = $wpdb->query($xsql);

  $rows_updated = $rows_inserted = 0;

  if(1==$rows_found) { // update

    if($debug) echo "UPDATE\n";
    
    $args = array(
      $event['title'],
      $dt,
      $event['title'],
      $event['description'],
      $event['start_date'],
      $event['end_date'],
      $category,
      $category_slug,
      $host_ids,
      $event['id']
    );

    $zsql = $wpdb->prepare(
      "UPDATE " . $wpdb->prefix . "pods_kiport_events
       SET name = '%s', modified = '%s', event_title = '%s', description = '%s', start_date = '%s', end_date = '%s', event_category = '%s', category_slug = '%s', hosts = '%s'
       WHERE event_id = %d", $args);

    if($debug) {
      echo "UPDATE_ZSQL\n";
      echo $zsql;
      echo "\n";
    }

    $rows_updated = $wpdb->query($zsql);

    if($debug) {
      echo "ROWS_UPDATED\n";
      echo $rows_updated;
      echo "\n";
    }

  } else { // insert

    if($debug) echo "INSERT\n";

    $args = array(
      $event['title'],
      $event['id'],
      $dt,
      $dt,
      $event['title'],
      $event['description'],
      $event['start_date'],
      $event['end_date'],
      $category,
      $category_slug,
      $host_ids
    );
    
    $zsql = $wpdb->prepare(
      "INSERT INTO " . $wpdb->prefix . "pods_kiport_events
       (name, event_id, created, modified, event_title, description, start_date, end_date, event_category, category_slug, hosts)
       VALUES(%d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s')",$args);

    if($debug) {
      echo "INSERT_ZSQL\n";
      echo $zsql;
      echo "\n";
    }

    $rows_inserted = $wpdb->query($zsql);

  } // end if(1==$rows_found)

  return array(
    'updated' => $rows_updated,
    'inserted' => $rows_inserted
  );

}
