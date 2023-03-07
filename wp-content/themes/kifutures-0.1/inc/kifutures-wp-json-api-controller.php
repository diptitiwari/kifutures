<?Php
/**
 * WP-JSON API Controller for Ki Futures theme
 *
 * @author Anthony Cullen
 * @since 1.0
 * @link https://kifutures.org
 ****************************************************************************************************
 */
class KIFUTURES_JSON_API_Controller {

  /**
   * Register routes
   *
   */
  public function register_routes() {

    $namespace = 'kifutures/v1';

    register_rest_route(
      $namespace, '/' . 'get_users', [
        array(
          'methods' => 'GET',
          'callback' => array($this,'get_users'),
          'permission_callback' => array($this,'get_users_permissions_check'),
          'args' => $this->get_endpoint_args('get_users')
        )
      ]
    );

    register_rest_route(
      $namespace, '/' . 'get_events', [
        array(
          'methods' => 'GET',
          'callback' => array($this,'get_events'),
          'permission_callback' => array($this,'get_events_permissions_check'),
          'args' => $this->get_endpoint_args('get_events')
        )
      ]
    );

  } // end function register_routes()

 /**
   * Argument Schema - get arguments for endpoints
   *
   * @param string $endpoint - endpoint
   * @return array $args - arguments for endpoint
   */
  function get_endpoint_args($endpoint) {
    $debug = false;

    $args = array();

    // common args

    $endpoints = array(
      'get_users',
      'get_events'
    );

    if(in_array($endpoint, $endpoints)) {
      $args = array_merge($args, array(
        'per_page' => array(
          'required' => false,
          'type' => 'string',
          'description' => 'Items per page (pagination size)',
          'validate_callback' => array($this,'validate_per_page_parameter'),
          'sanitize_callback' => array($this,'sanitize_string_parameter')
        ),
        'page' => array(
          'required' => false,
          'type' => 'string',
          'description' => 'Page (pagination page)',
          'validate_callback' => array($this,'validate_page_parameter'),
          'sanitize_callback' => array($this,'sanitize_string_parameter')
        )
      ));
    }

    // endpoint-specific args

    switch($endpoint) {
      case 'get_users':
        $args = array_merge($args, array(
          'types' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'User types',
            'validate_callback' => array($this,'validate_user_types_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'countries' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Countries',
            'validate_callback' => array($this,'validate_countries_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'languages' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Languages',
            'validate_callback' => array($this,'validate_languages_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'sustainability_interests' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Sustainability interests',
            'validate_callback' => array($this,'validate_sustainability_interests_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'professional_interests' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Professional interests',
            'validate_callback' => array($this,'validate_professional_interests_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'search' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Search',
            'validate_callback' => array($this,'validate_search_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'order_by' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Sort order',
            'validate_callback' => array($this,'validate_order_by_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          )
        ));
        break;
      case 'get_events':
        $args = array_merge($args, array(
          'categories' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Event categories',
            'validate_callback' => array($this,'validate_event_categories_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'start_date' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Start date',
            'validate_callback' => array($this,'validate_start_date_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ),
          'end_date' => array(
            'required' => false,
            'type' => 'string',
            'description' => 'Start date',
            'validate_callback' => array($this,'validate_end_date_parameter'),
            'sanitize_callback' => array($this,'sanitize_string_parameter')
          ) 
        ));
      default:
    } // end switch($endpoint)

    if($debug) {
      echo "GET_ARGS\n";
      echo "ENDPOINT\n";
      echo $endpoint, "\n";
      echo "ARGS\n";
      print_r($args);
      echo "\n";
    }

    return $args;
  } // end function get_endpoint_args()

  /**
   * Check permissions.
   *
   * As of v0.1, all endpoints are accessible to non-loged in users, so these functions simply return true.
   *
   * @param WP_REST_Request $request Current request object.
   * @return bool
   */
  public function get_users_permissions_check($request) {
    return true;
  }

  public function get_events_permissions_check($request) {
    return true;
  }

  /**
   * Validate
   *
   * @param WP_REST_Request $request Current request object.
   * @return bool
   */
  function validate_int_parameter($request) {
    return true;
  }

  function validate_per_page_parameter($request) {
    return true;
  }

  function validate_page_parameter($request) {
    return true;
  }

  function validate_user_types_parameter($request) {
    return true;
  }

  function validate_countries_parameter($request) {
    return true;
  }

  function validate_search_parameter($request) {
    return true;
  }

  function validate_languages_parameter($request) {
    return true;
  }

  function validate_sustainability_interests_parameter($request) {
    return true;
  }

  function validate_professional_interests_parameter($request) {
    return true;
  }

  function validate_event_categories_parameter($request) {
    return true;
  }

  function validate_start_date_parameter($request) {
    return true;
  }

  function validate_end_date_parameter($request) {
    return true;
  }

  /**
   * Sanitize string parameter
   *
   * @param mixed $value - Value of the parameter
   * @param WP_REST_Request $request - Current request object
   * @param string $param - Name of parameter ('something')
   */
  function sanitize_string_parameter($value, $request, $param) {
    $debug = false;

    if($debug) {
      ob_start();
      echo "SANITIZE_STRING_PARAMETER\n";
    }

    if($debug) {
      $contents = ob_get_contents();
      ob_end_clean();
      error_log($contents);
    }

    $attributes = $request->get_attributes();

    if(isset($attributes['args'][$param])) {
      $argument = $attributes['args'][$param];
      // Check to make sure our argument is a string.
      if ('string' === $argument['type'] ) {
        return sanitize_text_field($value);
      }
    } else {
      // This code won't execute because we have specified this argument as required.
      // If we reused this validation callback and did not have required args then this would fire.
      return new WP_Error('rest_invalid_param', sprintf( esc_html__('%s was not registered as a request argument.', 'kifutures'), $param), array('status' => 400));
    }

    // If we got this far then something went wrong don't use user input.
    return new WP_Error('rest_api_sad', esc_html__('Something went terribly wrong.', 'kifutures' ), array('status' => 500));
  } // end function sanitize_string_parameter()

  /**
   * Sanitize integer parameter
   *
   * @param mixed $value - Value of the parameter
   * @param WP_REST_Request $request - Current request object
   * @param string $param - Name of parameter ('group')
   */
  function sanitize_int_parameter($value, $request, $param) {
    $debug = false;

    if($debug) {
      //ob_start();
      echo "SANITIZE_INTEGER_PARAMETER\n";
    }

    //if($debug) {
    //  $contents = ob_get_contents();
    //  ob_end_clean();
    //  error_log($contents);
    //}

    $attributes = $request->get_attributes();

    if(isset($attributes['args'][$param])) {
      $argument = $attributes['args'][$param];
      echo "ARGUMENT\n";
      print_r($argument);
      // Check to make sure our argument is an integer
      if('int' === $argument['type'] ) {
        $value = (int) $value;
        if($value > 0) return $value;
      }
    } else {
      // This code won't execute because we have specified this argument as required.
      // If we reused this validation callback and did not have required args then this would fire.
      return new WP_Error('rest_invalid_param', sprintf( esc_html__('%s was not registered as a request argument.', 'kifutures'), $param), array('status' => 400));
    }

    // If we got this far then something went wrong don't use user input.
    return new WP_Error('rest_api_sad', esc_html__('Something went terribly wrong.', 'kifutures' ), array('status' => 500));
  } // end function sanitize_int_parameter()

  /**
   * Initialise var_sql array used in endpoint SQL queries
   *
   * @param string $endpoint - Endpoint
   * @return array $var_sql - Variable SQL
   */
  public function initialize_var_sql($endpoint) {
    global $wpdb;

    $var_sql = array();

    switch($endpoint) {
      case 'get_users':
        $var_sql['user_types'] = array(
          'chosen' => array(),
          'sql' =>  '',
          'vars' => array()
        );
        $var_sql['countries'] = array(
          'chosen' => array(),
          'sql' =>  '',
          'vars' => array()
        );
        $var_sql['languages'] = array(
          'chosen' => array(),
          'sql' =>  '',
          'vars' => array()
        );
        $var_sql['sustainability_interests'] = array(
          'chosen' => array(),
          'sql' =>  '',
          'join_sql' => "
      LEFT JOIN
        {$wpdb->prefix}pods_kiport_user_user_tag AS pkuust ON pku.user_id = pkuust.user_id
      LEFT JOIN
        {$wpdb->prefix}pods_kiport_user_tags AS pkust ON pkuust.tag_id = pkust.tag_id",
          'vars' => array()
        );
        $var_sql['professional_interests'] = array(
          'chosen' => array(),
          'sql' =>  '',
          'join_sql' => "
      LEFT JOIN
        {$wpdb->prefix}pods_kiport_user_user_tag AS pkuupt ON pku.user_id = pkuupt.user_id
      LEFT JOIN
        {$wpdb->prefix}pods_kiport_user_tags AS pkupt ON pkuupt.tag_id = pkupt.tag_id",
          'vars' => array()
        );
        $var_sql['interests'] = array(
          'sql' =>  '',
	  'vars' => array(),
	  'join_sql' => ''
        );
        $var_sql['search'] = array(
          'chosen' => array(),
          'sql' =>  '',
          'vars' => array()
        );
        $var_sql['sort_order'] = array(
          'chosen' => '',
	  'sql' =>  ''
        );
        break;
      case 'get_events':
        $var_sql['categories'] = array(
          'chosen' => array(),
          'sql' => '',
          'vars' => array()
        );
        $var_sql['start_date'] = array(
          'sql' => '',
          'vars' => array()
        );
        $var_sql['end_date'] = array(
          'sql' => '',
          'vars' => array()
        );
        break;
      default:
    } // end switch($endpoint)

    return $var_sql;
  } // end function initialize_var_sql()

  /**
   * Build user types variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_user_types_var_sql( $params, $var_sql, $alias ) {
    $debug = false;
    global $wpdb;

    if(!empty($params['types'])) {
      $var_sql['user_types']['chosen'] = explode(',', $params['types']);
      $vars = $placeholders = array();

      foreach ($var_sql['user_types']['chosen'] as $type) {
        $vars[] = $type;
      }

      if(!empty($vars)) {
        $placeholders = array_fill(0, count($vars), '%s');
        $format = implode(', ', $placeholders);
        $var_sql['user_types']['sql'] = "AND {$alias}.user_type IN(" . $format . ")";
        $var_sql['user_types']['sql_escaped'] = $wpdb->prepare($var_sql['user_types']['sql'],$vars);
	$var_sql['user_types']['vars'] = $vars;
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  }

  /**
   * Build countries variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_countries_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    if(!empty($params['countries'])) {
      $var_sql['countries']['chosen'] = explode(',', $params['countries']);
      $vars = $placeholders = array();

      foreach ($var_sql['countries']['chosen'] as $country) {
        $vars[] = $country;
      }

      if(!empty($vars)) {
        $placeholders = array_fill(0, count($vars), '%s');
        $format = implode(', ', $placeholders);
        $var_sql['countries']['sql'] = "AND {$alias}.country IN(" . $format . ")";
	$var_sql['countries']['sql_escaped'] = $wpdb->prepare($var_sql['countries']['sql'],$vars);
	$var_sql['countries']['vars'] = $vars;
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_countries_var_sql()

  /**
   * Build languages variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_languages_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    if(!empty($params['languages'])) {
      $var_sql['languages']['chosen'] = explode(',', $params['languages']);
      $vars = $placeholders = array();

      foreach ($var_sql['languages']['chosen'] as $language) {
        $vars[] = $language;
      }

      if(!empty($vars)) {
        $var = implode( '|', $vars );
        $var_sql['languages']['sql'] = "AND {$alias}.languages REGEXP '%s'";
        $var_sql['languages']['sql_escaped'] = $wpdb->prepare( $var_sql['languages']['sql'], $var );
        $var_sql['languages']['vars'] = array( $var );
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_countries_var_sql()

  /**
   * Build sustainability interests variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_sustainability_interests_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    if(!empty($params['sustainability_interests'])) {
      $var_sql['sustainability_interests']['chosen'] = explode(',', $params['sustainability_interests']);
      $vars = $placeholders = array();

      foreach ($var_sql['sustainability_interests']['chosen'] as $sustainability_interest) {
        $vars[] = $sustainability_interest;
      }

      if(!empty($vars)) {
        $placeholders = array_fill(0, count($vars), '%d');
        $format = implode(', ', $placeholders);
        //$var_sql['sustainability_interests']['sql'] = "AND {$alias}.sustainability_interest IN(" . $format . ")";
        $var_sql['sustainability_interests']['sql'] = "AND {$alias}.tag_id IN(" . $format . ")";
        $var_sql['sustainability_interests']['sql_escaped'] = $wpdb->prepare($var_sql['sustainability_interests']['sql'],$vars);
        $var_sql['sustainability_interests']['vars'] = $vars;
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_sustainability_interests_var_sql()

  /**
   * Build professional interests variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_professional_interests_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    if(!empty($params['professional_interests'])) {
      $var_sql['professional_interests']['chosen'] = explode(',', $params['professional_interests']);
      $vars = $placeholders = array();

      foreach ($var_sql['professional_interests']['chosen'] as $professional_interest) {
        $vars[] = $professional_interest;
      }

      if(!empty($vars)) {
        $placeholders = array_fill(0, count($vars), '%s');
        $format = implode(', ', $placeholders);
	//$var_sql['professional_interests']['sql'] = "AND {$alias}.professional_interest IN(" . $format . ")";
	$var_sql['professional_interests']['sql'] = "AND {$alias}.tag_id IN(" . $format . ")";
        $var_sql['professional_interests']['sql_escaped'] = $wpdb->prepare($var_sql['professional_interests']['sql'],$vars);
        $var_sql['professional_interests']['vars'] = $vars;
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_professional_interests_var_sql()

  /**
   * Build interests variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_interests_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    //$im = (isset( $params['sustainability_interests'] ) ? 1 : 0) + ( isset( $params['professional_interests'] ) ? 2 : 0); // interests mask
    $im = ( !empty( $params['sustainability_interests'] ) ? 1 : 0) + ( !empty( $params['professional_interests'] ) ? 2 : 0); // interests mask

    $svars = $pvars = $placeholders = array();

    if(!empty($params['sustainability_interests'])) {
      $var_sql['sustainability_interests']['chosen'] = explode(',', $params['sustainability_interests']);

      foreach ($var_sql['sustainability_interests']['chosen'] as $sustainability_interest) {
        $svars[] = $sustainability_interest;
      }
      $splaceholders = array_fill(0, count($svars), '%d');
      $sformat = implode(', ', $splaceholders);
    }

    if(!empty($params['professional_interests'])) {
      $var_sql['professional_interests']['chosen'] = explode(',', $params['professional_interests']);

      foreach ($var_sql['professional_interests']['chosen'] as $professional_interest) {
        $pvars[] = $professional_interest;
      }
      $pplaceholders = array_fill(0, count($pvars), '%d');
      $pformat = implode(', ', $pplaceholders);
    }

    switch( $im ) {
      case 1: // sustainability interests only
        if( !empty( $svars )) {
          //$var_sql['interests']['sql'] = "AND {$alias}.tag_id IN(" . $sformat . ")";
          $var_sql['interests']['sql'] = "AND pkust.tag_id IN(" . $sformat . ")";
          $var_sql['interests']['join_sql'] = $var_sql['sustainability_interests']['join_sql'];
        }  
        break;
      case 2: // professional interests only
        if( !empty( $pvars )) {
          //$var_sql['interests']['sql'] = "AND {$alias}.tag_id IN(" . $pformat . ")";
          $var_sql['interests']['sql'] = "AND pkupt.tag_id IN(" . $pformat . ")";
          $var_sql['interests']['join_sql'] = $var_sql['professional_interests']['join_sql'];
        }
        break;
      case 3: // sustainability & professional interests
	if( !empty( $svars ) && !empty( $pvars ) ) {      
          //$var_sql['interests']['sql'] = "AND ( {$alias}.tag_id IN(" . $sformat . ") OR {$alias}.tag_id IN(" . $pformat . ") )";
          $var_sql['interests']['sql'] = "AND ( pkust.tag_id IN(" . $sformat . ") AND pkupt.tag_id IN(" . $pformat . ") )";
	  $var_sql['interests']['join_sql'] = $var_sql['sustainability_interests']['join_sql'] . $var_sql['professional_interests']['join_sql'];
	}
        break;
      default:
        $var_sql['interests']['sql'] = '';
    } // end switch( $im )

    $vars = array_merge( $svars, $pvars );

    if(!empty($vars)) {
      $var_sql['interests']['sql_escaped'] = $wpdb->prepare($var_sql['interests']['sql'], $vars);
      $var_sql['interests']['svars'] = $svars;
      $var_sql['interests']['pvars'] = $pvars;
      $var_sql['interests']['vars'] = $vars;
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_interests_var_sql()

  /**
   * Build search variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_search_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    if(!empty($params['search'])) {
      $var_sql['search']['chosen'] = explode(',', $params['search']);
      $vars = $placeholders = array();

      foreach ($var_sql['search']['chosen'] as $search) {
        $vars[] = $search;
      }

      if(!empty($vars)) {
        $var = implode( '|', $vars );
        $var_sql['search']['sql'] = "AND {$alias}.biography REGEXP '%s'";
        $var_sql['search']['sql_escaped'] = $wpdb->prepare( $var_sql['search']['sql'], $var );
        $var_sql['search']['vars'] = array( $var );
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_search_var_sql()

  /**
   * Build start/end date variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_start_end_date_var_sql($params,$var_sql,$alias) {

    global $wpdb;

    if(isset($params['start_date'])) {
      $var_sql['start_date']['sql'] = "AND {$alias}.start_date >= %s ";
      $var_sql['start_date']['vars'][] = $params['start_date'];
      $var_sql['start_date']['sql_escaped'] = $wpdb->prepare($var_sql['start_date']['sql'], $params['start_date']);
    }

    if(isset($params['end_date'])) {
      $var_sql['end_date']['sql'] = "AND {$alias}.end_date <= %s ";
      $var_sql['end_date']['vars'][] = $params['end_date'];
      $var_sql['end_date']['sql_escaped'] = $wpdb->prepare($var_sql['end_date']['sql'], $params['end_date']);
    }

    return $var_sql;
  } // end function build_start_end_date_var_sql()

  /**
   * Build event categories variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_event_categories_var_sql($params, $var_sql, $alias) {
    $debug = false;

    global $wpdb;

    if(!empty($params['categories'])) {
      $var_sql['categories']['chosen'] = explode(',', $params['categories']);
      $vars = $placeholders = array();

      foreach ($var_sql['categories']['chosen'] as $category) {
        $vars[] = $category;
      }

      if(!empty($vars)) {
        $placeholders = array_fill(0, count($vars), '%s');
        $format = implode(', ', $placeholders);
        $var_sql['categories']['sql'] = "AND {$alias}.category_slug IN(" . $format . ")";
        $var_sql['categories']['sql_escaped'] = $wpdb->prepare($var_sql['categories']['sql'],$vars);
        $var_sql['categories']['vars'] = $vars;
      }
    }

    if($debug) {
      print_r($var_sql);
    }
    return $var_sql;
  } // end function build_event_categories_var_sql()

  /**
   * Build sort order variable SQL
   *
   * @param array $params - Request params
   * @param array $var_sql - Variable SQL
   * @param string $alias - Table alias
   * @return string $var_sql - Modified variable SQL
   */
  public function build_sort_order_var_sql($params, $var_sql, $alias) {
    $debug = false;
    global $wpdb;

    $var_sql['sort_order']['chosen'] = !empty($params['order_by']) ? $params['order_by'] : '';

    switch($var_sql['sort_order']['chosen']) {
      case 'date_desc':
        $var = "name DESC";
        break;
      case 'name_asc':
        $var = "name ASC";
        break;
      default:
        $var = "start_date ASC";
    }

    $var_sql['sort_order']['sql'] = "ORDER BY '%s'";
    $var_sql['sort_order']['var'] = $var;
    $var_sql['sort_order']['sql_escaped'] = str_replace('\'','',$wpdb->prepare($var_sql['sort_order']['sql'],$var));

    if($debug) {
      print_r($var_sql);
      print_r($vars);
    }

    return $var_sql;

  } // end function build_sort_order_var_sql()

  /**
   * Get KiPort user
   *
   * @return array
   */
  public function get_kiport_user( $user_id ) {

    $debug = false;
  
    global $wpdb;

    $sql = "SELECT * FROM {$wpdb->prefix}pods_kiport_users WHERE user_id = %d";

    $zsql = $wpdb->prepare( $sql, $user_id );

    if( $debug ) echo $zsql;

    $results = $wpdb->get_results( $zsql, ARRAY_A );

    if( $debug ) print_r( $results );

    if( $results ) {
      return $results[0];
    } else {
      return $results;
    }

  }	  

  /**
   * Get users.
   *
   * @return array
   */
  public function get_users($request) {
    $debug = false; // set to true to enable debug messages/output

    if($debug) {
      ob_start();
      echo "START\n";
    }

    global $wpdb, $KIFUTURES_THEME_OPTIONS, $KIFUTURES_PODS_IDS;

    // Response data array defaults.
    $response = array(
      'count_total' => 0,      // Total users count
      'count'       => 0,      // Current response users count
      'pages'       => 0,      // Total pages count
      'users'       => array() // Users data
    );

    if($debug) {
      echo "REQUEST\n";
      print_r($request);
      echo "\n";
    }

    $params = $request->get_params();

    if($debug) {
      echo "PARAMS\n";
      print_r($params);
      echo "\n";
    }

    $var_sql = $this->initialize_var_sql('get_users');

    if($debug) {
      echo "VAR_SQL_INITIAL\n";
      print_r($var_sql);
      echo "\n";
    }

    $pfx = 'pku'; // table prefix

    $vars = array();

    // Types
    $var_sql = $this->build_user_types_var_sql($params,$var_sql, $pfx);

    // Countries
    $var_sql = $this->build_countries_var_sql($params,$var_sql, $pfx);

    // Languages
    $var_sql = $this->build_languages_var_sql($params,$var_sql, $pfx);

    // Sustainability interests
    //$var_sql = $this->build_sustainability_interests_var_sql($params,$var_sql, 'pkut');

    // Professional interests
    //$var_sql = $this->build_professional_interests_var_sql($params,$var_sql, 'pkut');

    // Sustainability / professional interests
    $var_sql = $this->build_interests_var_sql( $params, $var_sql, 'pkut');

    // Search
    $var_sql = $this->build_search_var_sql($params,$var_sql, $pfx);

    // Sort order
    $var_sql = $this->build_sort_order_var_sql($params,$var_sql, $pfx);

    // Results per page.
    $var_sql['per_page'] = isset($params['per_page']) ? abs(intval($params['per_page'])) : 12;

    // Current page number.
    $var_sql['page'] = isset($params['page']) ? abs(intval($params['page'])) : 1;

    // Offset for SQL: LIMIT offset, rows.
    $var_sql['limit_offset'] = $var_sql['per_page'] * ($var_sql['page'] - 1);

    if($debug) {
      echo "VAR_SQL_FINAL\n";
      print_r($var_sql);
      echo "\n";
      echo "VARS_FINAL\n";
      print_r($vars);
      echo "\n";
    }

    $sql_query = "
SELECT
    SQL_CALC_FOUND_ROWS
    {$pfx}.user_id,
    {$pfx}.name,
    {$pfx}.pronouns,
    {$pfx}.city,
    {$pfx}.country,
    {$pfx}.languages,
    {$pfx}.biography,
    {$pfx}.user_type,
    {$pfx}.sustainability_interests,
    {$pfx}.professional_interests,
    {$pfx}.job_title_role,
    {$pfx}.profile_pic
FROM
    wp_pods_kiport_users AS {$pfx}
    {$var_sql['interests']['join_sql']}
WHERE 1=1
    {$var_sql['user_types']['sql']}
    {$var_sql['countries']['sql']}
    {$var_sql['languages']['sql']}
    {$var_sql['interests']['sql']}
    {$var_sql['search']['sql']}
GROUP BY {$pfx}.user_id
{$var_sql['sort_order']['sql']}
LIMIT %d, %d
";

    $vars = array_merge(
      $var_sql['user_types']['vars'],
      $var_sql['countries']['vars'],
      $var_sql['languages']['vars'],
      $var_sql['interests']['vars'],
      $var_sql['search']['vars'],
      array(
        $var_sql['sort_order']['var'],
        $var_sql['limit_offset'],
        $var_sql['per_page']
      )
    );

    $sql_query_escaped = $wpdb->prepare( $sql_query, $vars );

    if($debug) {
      echo "SQL_QUERY\n";
      echo $sql_query;
      echo "\n";
      echo "VARS\n";
      print_r($vars);
      echo "\n";
      echo "SQL_QUERY_ESCAPED\n";
      echo $sql_query_escaped;
      echo "\n";
    }

    $users_db = $wpdb->get_results($sql_query_escaped);

    if($debug) {
      echo "USERS_DB\n";
      print_r($users_db);
    }

    $response['count_total'] = $wpdb->get_results("SELECT FOUND_ROWS() AS count")[0]->count;
    $metadesc_count = $response['count_total'];
    $response['pages']       = ceil($response['count_total'] / $var_sql['per_page']);
    $response['count']       = count($users_db);

    if($debug) {
      echo "RESPONSE\n";
      print_r($response);
    }

    $loop = 0;

    foreach($users_db as $user_data) {

      $sustainability_interests = $professional_interests = array();

      if( !empty( $user_data->sustainability_interests ) ) {
        $sql = "SELECT pkut.tag_id, pkut.name
		  FROM {$wpdb->prefix}pods_kiport_user_user_tag AS pkuut
                    LEFT JOIN {$wpdb->prefix}pods_kiport_user_tags AS pkut ON pkuut.tag_id = pkut.tag_id
                  WHERE pkuut.user_id = %d AND pkut.tag_type_abbr = 's'";
        $zsql = $wpdb->prepare( $sql, $user_data->user_id );
	$results = $wpdb->get_results( $zsql );
	if( $debug ) {
          echo "SUSTAINABILITY_INTERESTS\n";
	  print_r( $results );
	  echo "\n";
        }

        if( !empty( $results ) ) {
          $sustainability_interests = array();
          foreach( $results as $result ) {
            $sustainability_interests[] = array( 'id' => (int) $result->tag_id, 'name' => $result->name );
          }
        }

      }

      if( !empty( $user_data->professional_interests ) ) {
        $sql = "SELECT pkut.tag_id, pkut.name
                  FROM {$wpdb->prefix}pods_kiport_user_user_tag AS pkuut
                    LEFT JOIN {$wpdb->prefix}pods_kiport_user_tags AS pkut ON pkuut.tag_id = pkut.tag_id
                  WHERE pkuut.user_id = %d AND pkut.tag_type_abbr = 'p'";
        $zsql = $wpdb->prepare( $sql, $user_data->user_id );
        $results = $wpdb->get_results( $zsql );
        if( $debug ) {
          echo "PROFESSIONAL_INTERESTS\n";
          print_r( $results );
          echo "\n";
        }

        if( !empty( $results ) ) {
          $professional_interests = array();
          foreach( $results as $result ) {
            $professional_interests[] = array( 'id' => (int) $result->tag_id, 'name' => $result->name );
          }
        }

      }
     
      $response['users'][] = array(
        'id' => (int) $user_data->user_id,
        'name' => $user_data->name,
        'pronouns' => $user_data->pronouns,
        'type' => $user_data->user_type,
        'country' => $user_data->country,
	'city' => $user_data->city,
        'languages' => unserialize( $user_data->languages ),
        'job_title_role' => $user_data->job_title_role,
        'biography' => $user_data->biography,
        'sustainability_interests' => $sustainability_interests,	
        'professional_interests' => $professional_interests,	
        'profile_pic' => $user_data->profile_pic
      );
      if($debug) $loop++;
    } // end foreach ($users_db as $user_data)

    //DEBUG
    if($debug) {
      echo "DEBUG\n";
      echo $sql_query_escaped;
      $response['debug'] = $sql_query_escaped;
    }

    /*
    if($debug) {
      $contents = ob_get_contents();   // put the buffer into a variable
      ob_end_clean();                  // end capture
      error_log($contents);            // Write to wp-content/debug.log (enable debug mode to see it).
    }
    */

    return $response;
  }

  /**
   * Get events
   *
   * @return array
   */
  public function get_events($request) {
    $debug = false; // set to true to enable debug messages/output

    if($debug) {
      ob_start();
      echo "START\n";
    }

    global $wpdb, $KIFUTURES_THEME_OPTIONS, $KIFUTURES_PODS_IDS;

    // Response data array defaults.
    $response = array(
      'count_total' => 0,      // Total events count
      'count'       => 0,      // Current response events count
      'pages'       => 0,      // Total pages count
      'events'      => array() // Events data
    );

    if($debug) {
      echo "REQUEST\n";
      print_r($request);
      echo "\n";
    }

    $params = $request->get_params();

    if($debug) {
      echo "PARAMS\n";
      print_r($params);
      echo "\n";
    }

    $var_sql = $this->initialize_var_sql('get_events');

    if($debug) {
      echo "VAR_SQL_INITIAL\n";
      print_r($var_sql);
      echo "\n";
    }

    $pfx = 'pke'; // table prefix

    $vars = array();

    // Categories
    $var_sql = $this->build_event_categories_var_sql($params,$var_sql, $pfx);

    // Start/end date
    $var_sql = $this->build_start_end_date_var_sql($params,$var_sql, $pfx);

    // Sort order
    $var_sql = $this->build_sort_order_var_sql($params,$var_sql, $pfx);

    // Results per page.
    $var_sql['per_page'] = isset($params['per_page']) ? abs(intval($params['per_page'])) : 12;

    // Current page number.
    $var_sql['page'] = isset($params['page']) ? abs(intval($params['page'])) : 1;

    // Offset for SQL: LIMIT offset, rows.
    $var_sql['limit_offset'] = $var_sql['per_page'] * ($var_sql['page'] - 1);

    if($debug) {
      echo "VAR_SQL_FINAL\n";
      print_r($var_sql);
      echo "\n";
      echo "VARS_FINAL\n";
      print_r($vars);
      echo "\n";
    }

    $sql_query = "
SELECT
    SQL_CALC_FOUND_ROWS
    {$pfx}.*
FROM
    wp_pods_kiport_events AS {$pfx}
WHERE 1=1
    {$var_sql['categories']['sql']}
    {$var_sql['start_date']['sql']}
    {$var_sql['end_date']['sql']}
GROUP BY {$pfx}.event_id
{$var_sql['sort_order']['sql']}
LIMIT %d, %d
";

      /* $vars = array(
        $var_sql['limit_offset'],
        $var_sql['per_page']
      ); */

    $vars = array_merge(
      $var_sql['categories']['vars'],
      $var_sql['start_date']['vars'],
      $var_sql['end_date']['vars'],
      array(
        $var_sql['sort_order']['var'],
        $var_sql['limit_offset'],
        $var_sql['per_page']
      )
    );

    $sql_query_escaped = $wpdb->prepare($sql_query,$vars);

    if($debug) {
      echo "SQL_QUERY\n";
      echo $sql_query;
      echo "\n";
      echo "VARS\n";
      print_r($vars);
      echo "\n";
      echo "SQL_QUERY_ESCAPED\n";
      echo $sql_query_escaped;
      echo "\n";
    }

    $events_db = $wpdb->get_results($sql_query_escaped);

    if($debug) {
      echo "EVENTS_DB\n";
      print_r($events_db);
    }

    $response['count_total'] = $wpdb->get_results("SELECT FOUND_ROWS() AS count")[0]->count;
    $metadesc_count = $response['count_total'];
    $response['pages']       = ceil($response['count_total'] / $var_sql['per_page']);
    $response['count']       = count($events_db);

    if($debug) {
      echo "RESPONSE\n";
      print_r($response);
    }

    $loop = 0;

    foreach($events_db as $event_data) {

      // get event host details if >0  hosts exist for event
      $hosts = array();

      if( !empty( $event_data->hosts ) ) {
        $host_ids = explode(',', $event_data->hosts );
        foreach( $host_ids as $host_id ) {
  	  $host = $this->get_kiport_user( $host_id );
	  if(!empty( $host ) ) {
            $host['id'] = (int) $host['id'];
            $host['user_id'] = (int) $host['user_id'];
	    $hosts[] = $host;
	  }
        } 
      } 
      
      $response['events'][] = array(
        'id' => (int) $event_data->id,
        'name' => $event_data->event_title,
        'event_id' => (int) $event_data->event_id,
        'start_date' => $event_data->start_date,
        'end_date' => $event_data->end_date,
        'category' => $event_data->event_category,
        'category_slug' => $event_data->category_slug,
        'description' => $event_data->description,
        'hosts' => $hosts
      );

      if($debug) $loop++;
    } // end foreach ($events_db as $event_data)

    //DEBUG
    if($debug) {
      echo "DEBUG\n";
      echo $sql_query_escaped;
      $response['debug'] = $sql_query_escaped;
    }

    /*
    if($debug) {
      $contents = ob_get_contents();   // put the buffer into a variable
      ob_end_clean();                  // end capture
      error_log($contents);            // Write to wp-content/debug.log (enable debug mode to see it).
    }
    */

    return $response;
  } // end function get_events()

} // end class KIFUTURES_JSON_API_Controller
