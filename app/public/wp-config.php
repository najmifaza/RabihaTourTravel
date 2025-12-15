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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'P7#UH%#%:;((:Jf|cDSF3Wj<G2:nN,lLleDjxmr>dHBm x;IIP| [*E+94*g9]a+' );
define( 'SECURE_AUTH_KEY',   ':c6Fw@VK9loV5G~*5EO&c:+U1vRI*5hx,*$wXrrcuR&J>E-N*DeNs>5s$an~P|0o' );
define( 'LOGGED_IN_KEY',     '*C[=vW &]^C.ZD&*DGO|9Pn`mYt)-Zu~}7yCanl#CQJCEa2hT!.g1v(@,LihAMVz' );
define( 'NONCE_KEY',         'Xy|4GVT/rliqT8eyXKq`@x#wuAWks<9qcjbOC=bn0I+G{j6n&EM?d&=D)&P0wqJ;' );
define( 'AUTH_SALT',         ')U>:#>3V A-75Z(Ez_OH=NH8Q31r=ND&5$~z5oV%8d.#&W#7`m9l9#31zTNo`05 ' );
define( 'SECURE_AUTH_SALT',  'Q`KrLvJgrtsmiMUx)Y_P= 1&oOvO|8eQ/VE9}`yawUnePEmdBkPCXA-zj)3G-<`M' );
define( 'LOGGED_IN_SALT',    '*=:F`9_obNw|E;T+ga{Vme|q[}+NA,4t}YPd}5O$Zf%,9nMlM!8:>x9m3b]rIX~F' );
define( 'NONCE_SALT',        'J%O=+1UYaJ-a[m3U%FF2MKJ9N]$s]#pW1@-A!p:Qa9m32abWd8WHJne7.]hR3+J!' );
define( 'WP_CACHE_KEY_SALT', ',w:7G^c3up#bq8&D6xW,]{>Xy.2:kP(^s803)^}9u5Lro+yaV]O)V5{hszzgOv!S' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
