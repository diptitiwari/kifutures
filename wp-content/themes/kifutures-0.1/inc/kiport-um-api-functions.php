<?php
/**
 * Kiport Ultimate Member API Functions
 *
 * Update local user data with Ultimate Member user data from KiPort server
 *
 * @author Anthony Cullen - Feathered Owl Technology
 * @link: https://www.featheredowl.com
 * @version 0.1
 ******************************************************************************************
 */

/*
$KIFUTURES_THEME_OPTIONS = Array
(
    [um_api_base_url] => https://kiportdev.wpengine.com/um-api/
    [um_api_key] => 12345
    [um_api_token] => 8cfa2282b17de0a598c010f5f0109e7d
    [um_api_users_endpoint] => get.users
    [um_api_institutes_endpoint] => get.institutes
    [um_api_champions_endpoint] => get.champions
    [um_api_coaches_endpoint] => get.coaches
    [te_api_base_url] => https://kiportdev.wpengine.com/wp-json/tribe/events/v1/
    [te_api_events_endpoint] => events
    [option_id] => 5
)
*/

/**
 * API call
 * 
 * @param string $url - url for curl request
 * @param string $query - query args for curl request
 * @return array $arr - json encoded query response
 */
function kifutures_kp_um_api_call($url,$query) {
  //kifutures_write_log("API_CALL\n");
  //kifutures_write_log($url . $query);
  //echo $url . $query;
  global $KIFUTURES_THEME_OPTIONS;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url . '?' . $query);
  curl_setopt($ch, CURLOPT_REFERER, $KIFUTURES_THEME_OPTIONS['um_api_base_url']);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  $output = curl_exec($ch);
  $info = curl_getinfo($ch);
  curl_close($ch);
  $arr = json_decode($output, 1);
  return $arr;
}

/**
 * Get users
 *
 * @param string $type - user type (role)
 * @return array $users - json encoded user data
 */
function kifutures_kp_um_api_get_users( $type='' ) {
  global $KIFUTURES_THEME_OPTIONS;
  
  switch( $type ) {
    case 'coach':
      $ep_str = 'coaches';
      break;
    case 'champion':
      $ep_str = 'champions';
      break;
    case 'institute':
      $ep_str = 'institutes';
      break;
    default:
      $ep_str = '';
  }

  $endpoint = !empty( $type ) ? 'um_api_' . $ep_str . '_endpoint' : 'um_api_users_endpoint';

  $url = $KIFUTURES_THEME_OPTIONS['um_api_base_url'] . $KIFUTURES_THEME_OPTIONS[$endpoint];

  $data = array(
    'um_key' => $KIFUTURES_THEME_OPTIONS['um_api_key'],
    'um_token' => $KIFUTURES_THEME_OPTIONS['um_api_token'],
    'um_number' => '-1'
  );
  $query = http_build_query($data);
  $users = kifutures_kp_um_api_call($url,$query);
  return $users;
}

/**
 * Get user tags
 *
 * @return array $tags - json encoded user tag data
 */
function kifutures_kp_um_api_get_user_tags() {
  global $KIFUTURES_THEME_OPTIONS;
  $url = $KIFUTURES_THEME_OPTIONS['um_api_base_url'] . $KIFUTURES_THEME_OPTIONS['um_api_user_tags_endpoint'];
  $data = array(
    'um_key' => $KIFUTURES_THEME_OPTIONS['um_api_key'],
    'um_token' => $KIFUTURES_THEME_OPTIONS['um_api_token'],
    'um_number' => '-1'
  );
  $query = http_build_query($data);
  $tags = kifutures_kp_um_api_call( $url, $query );
  return $tags;
}

/**
 * Get user user tags
 *
 * @return array $user_user_tags - json encoded user user tag relationship data
 */
function kifutures_kp_um_api_get_user_user_tags() {
  global $KIFUTURES_THEME_OPTIONS;
  $url = $KIFUTURES_THEME_OPTIONS['um_api_base_url'] . $KIFUTURES_THEME_OPTIONS['um_api_user_user_tags_endpoint'];
  $data = array(
    'um_key' => $KIFUTURES_THEME_OPTIONS['um_api_key'],
    'um_token' => $KIFUTURES_THEME_OPTIONS['um_api_token'],
    'um_number' => '-1'
  );
  $query = http_build_query($data);
  $user_user_tags = kifutures_kp_um_api_call( $url, $query );
  return $user_user_tags;
}

/**
 * Insert/update user data from KiPort server into local kiport_users table
 *
 * @param array $user - user data
 * @param string $type - user type (role)
 * @param string $dt - date/time (MySQL date/time format)
 * @return array - rows inserted | rows updated 
 */
function kifutures_kp_um_api_insert_user($user, $type, $dt) {

  $debug = false;

  global $wpdb;

  if( 'um_ki-futures-institute' == $user['roles'][0] ) {
    $name = !empty( $user['display_name'] ) ? $user['display_name'] : $user['user_login'];
    $job_title_role = '';
  } else {
    $name = !empty( $user['display_name'] ) ? $user['display_name'] : $user['first_name'] . ' ' . $user['last_name'];
    $job_title_role = $user['job_title_role'];
  }

  // assign type-specific user data items to strings, blank if not present
  $pronouns = !empty($user['pronouns']) ? $user['pronouns'] : '';

  // convert term relationship arrays into comma-separated strings, or blank strings if not present
  $languages = !empty($user['languages']) ? serialize( $user['languages'] ) : '';
  $sustainability_interests = !empty($user['sustainability_interests']) ? implode(',', $user['sustainability_interests']) : '';
  $professional_interests = !empty($user['professional_interests']) ? implode(',', $user['professional_interests']) : '';

  // check if user record alerady exists
  $xsql = $wpdb->prepare("SELECT * from " . $wpdb->prefix . "pods_kiport_users WHERE user_id = %d", $user['ID'] );

  $rows_found = $wpdb->query($xsql);

  $rows_updated = $rows_inserted = 0;

  if(1==$rows_found) { // update

    if($debug) echo "UPDATE\n";
    $args = array(
      $name,
      $dt,
      $type,
      $user['first_name'],
      $user['last_name'],
      $pronouns,
      $user['country'],
      $user['city'],
      $languages,
      $job_title_role,
      $sustainability_interests,
      $professional_interests,
      $user['background'],
      $user['profile_pic_normal'],
      $user['account_status'],
      $user['ID']
    );

    $zsql = $wpdb->prepare(
      "UPDATE " . $wpdb->prefix . "pods_kiport_users
       SET name = '%s', modified = '%s', user_type = '%s', first_name = '%s', last_name = '%s', pronouns = '%s', country = '%s', city = '%s', languages = '%s', job_title_role = '%s', sustainability_interests = '%s', professional_interests = '%s', biography = '%s', profile_pic = '%s', account_status = '%s'
       WHERE user_id = %d", $args);

    if($debug) {
      echo "ZSQL\n";
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
      $name,
      $user['ID'],
      $dt,
      $dt,
      $type,
      $user['first_name'],
      $user['last_name'],
      $user['country'],
      $user['city'],
      $pronouns,
      $languages,
      $job_title_role,
      $sustainability_interests,
      $professional_interests,
      $user['background'],
      $user['profile_pic_normal'],
      $user['account_status']
    );

    $zsql = $wpdb->prepare(
      "INSERT INTO " . $wpdb->prefix . "pods_kiport_users
      (name, user_id, created, modified, user_type, first_name, last_name, country, city, pronouns, languages, job_title_role, sustainability_interests, professional_interests, biography, profile_pic, account_status)
      VALUES('%s', %d, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",$args);

    if($debug) {
      echo "INSERT_ZSQL\n";
      echo $zsql;
      echo "\n";
    }

  } // end if(1==$rows_found)
  $rows_inserted = $wpdb->query($zsql); //echo $rows_inserted;


  return array(
    'updated' => $rows_updated,
    'inserted' => $rows_inserted
  );
}

/**
 * Insert/update user tag data from KiPort server into local kiport_user_tags table
 *
 * @param array $tag - user tag data
 * @param string $dt - date/time (MySQL date/time format)
 * @return array - rows inserted | rows updated 
 */
function kifutures_kp_um_api_insert_user_tag($tag, $dt) {

  $debug = false;

  global $wpdb;

  // check if user tag record already exists
  $xsql = $wpdb->prepare("SELECT * from " . $wpdb->prefix . "pods_kiport_user_tags WHERE tag_id = %d", $tag['id']);

  $rows_found = $wpdb->query($xsql);

  $rows_updated = $rows_inserted = 0;

  if(1==$rows_found) { // update

    if($debug) echo "UPDATE\n";
    $args = array(
      $tag['name'],
      $dt,
      $tag['type'],
      $tag['type_abbr'],
      $tag['id']
    );

    $zsql = $wpdb->prepare(
      "UPDATE " . $wpdb->prefix . "pods_kiport_user_tags
       SET name = '%s', modified = '%s', tag_type = '%s', tag_type_abbr = '%s'
       WHERE tag_id = %d", $args);

    if($debug) {
      echo "ZSQL\n";
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
      $tag['name'],
      $tag['id'],
      $dt,
      $dt,
      $tag['type'],
      $tag['type_abbr']
    );

    $zsql = $wpdb->prepare(
      "INSERT INTO " . $wpdb->prefix . "pods_kiport_user_tags
      (name, tag_id, created, modified, tag_type, tag_type_abbr)
      VALUES('%s', '%s', '%s', '%s', '%s', '%s')",$args);

    if($debug) {
      echo "INSERT_ZSQL\n";
      echo $zsql;
      echo "\n";
    }

  } // end if(1==$rows_found)
  $rows_inserted = $wpdb->query($zsql); //echo $rows_inserted;


  return array(
    'updated' => $rows_updated,
    'inserted' => $rows_inserted
  );
}

/**
 * Insert/update user_user_tag relationship data from KiPort server into local kiport_user_user_tag table
 *
 * @param array $tag - user tag data
 * @param string $dt - date/time (MySQL date/time format)
 * @return array - rows inserted | rows updated 
 */
function kifutures_kp_um_api_insert_user_user_tag($user_user_tag, $dt) {

  $debug = false;

  global $wpdb;

  // check if user tag record already exists
  $args = array( $user_user_tag['user_id'], $user_user_tag['tag_id'] );
  $xsql = $wpdb->prepare( "SELECT * from " . $wpdb->prefix . "pods_kiport_user_user_tag WHERE user_id = %d AND tag_id = %d", $args );

  $rows_found = $wpdb->query($xsql);

  $rows_updated = $rows_inserted = 0;

  if(1==$rows_found) { // update

    if($debug) echo "UPDATE\n";

    $args = array(
      $user_user_tag['user_id'] . ' ' . $user_user_tag['tag_id'],
      $dt,
      $user_user_tag['user_id'],
      $user_user_tag['tag_id']
    );

    $zsql = $wpdb->prepare(
      "UPDATE " . $wpdb->prefix . "pods_kiport_user_user_tag
       SET name = '%s', modified = '%s'
       WHERE user_id = %d AND tag_id = %d", $args);

    if($debug) {
      echo "ZSQL\n";
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
      $user_user_tag['user_id'] . ' ' . $user_user_tag['tag_id'],
      $dt,
      $dt,
      $user_user_tag['user_id'],
      $user_user_tag['tag_id']
    );

    $zsql = $wpdb->prepare(
      "INSERT INTO " . $wpdb->prefix . "pods_kiport_user_user_tag
      (name, created, modified, user_id, tag_id)
      VALUES('%s', '%s', '%s', %d, %d)",$args);

    if($debug) {
      echo "INSERT_ZSQL\n";
      echo $zsql;
      echo "\n";
    }

  } // end if(1==$rows_found)
  $rows_inserted = $wpdb->query($zsql); //echo $rows_inserted;

  return array(
    'updated' => $rows_updated,
    'inserted' => $rows_inserted
  );
}

/**
 * Clean out stale user data
 *  run immediately after data import to remove records last updated prior to timestamp of last insert/update
 *
 * @param string $type - user type
 * @param datetime $dt - date/time most recent data insert/update
 * @return int $rows_deleted - no. of rows deleted
 */
function kifutures_delete_stale_users_by_type( $type, $dt ) {

  $debug= true;

  global $wpdb;

  $vars = array(
    $type,
    $dt
  );

  if($debug) {
    kifutures_write_log("DELETE_STALE_USERS\n");
    kifutures_write_log("VARS\n");
    kifutures_write_log( $vars );
  }

  $zsql = $wpdb->prepare("DELETE FROM " . $wpdb->prefix . "pods_kiport_users WHERE user_type = '%s' AND modified < '%s'", $vars);

  if($debug) {
    kifutures_write_log("ZSQL\n");
    kifutures_write_log($zsql, "\n");
  }

  $rows_deleted = $wpdb->query($zsql);

  return $rows_deleted;
}
