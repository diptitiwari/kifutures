<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kifutures' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9&7Qsa|vQ9&bFmL%7$%)}m_p0|>@VBrFLT_; clE!UnW^be0=j7~e#!V}b]N]68$' );
define( 'SECURE_AUTH_KEY',  'A3y4dY=9xI3a^WzVQ,evW<3i7u2:t,ZNlxwOA{Nxb8GO*H>O`7C}-!#A0!:$AL$s' );
define( 'LOGGED_IN_KEY',    'w6T$V{k6X]?Aj/~L&NYO6W(3x5:!<MMtcl0]{A9+]EgU&5NuEndyyN^G]YYtB4e$' );
define( 'NONCE_KEY',        'dORdA6IO!-naa!ih+^Cm?JjRXU=R(B/6hIZkwuWca2vb#ZGdPjDtFmMXKMm{-C{?' );
define( 'AUTH_SALT',        'Hg_<!]3Sm9m`J|6ug+iyd+GCRztNyo`1`z+IeS_V,Iudh%rNMUbNr6TOz*~Y*x+t' );
define( 'SECURE_AUTH_SALT', 'BYo &xn.~ns*t|?h5GMb*,.x.eme:OP3u(J6MR.IK}MlC0j21HHU|3w)qWL0?ENS' );
define( 'LOGGED_IN_SALT',   '#lRATu^GRd!kMTAkEXUSJLORYCiEIaaAwkZ$FqqRD+!Q/v1eEPJjf)ySbY]G&;vi' );
define( 'NONCE_SALT',       'j_--<)>^S^HKmG(#<|33rh[cTI(:O6Oy`M`*yI/|k<SbPZM,J7tF%g[v+MqK$!CW' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
