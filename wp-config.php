<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'movilPublicidad');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '1Gataprisila');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '%?78,+o}:CLs)@gzp$e-C6Lq>lD9JSH>C ^nELICV6L)f,dT/y,7@07~v{^.FNiW');
define('SECURE_AUTH_KEY',  '0K IZM_km4]:Kt],tslcm:qcD}iNZk}ND4suWkK$qwS$ll9/yjm[:/(r5s<Z^a!7');
define('LOGGED_IN_KEY',    'vD`7P/mu8ThT_.#I%ii&&}@T21AQeB=OUtSHZ*SQBN?pBv@..it};V6%`|n=DL4H');
define('NONCE_KEY',        '6MQFS%Pk1H &5-#^d{|2UOEfrdJND,}J?3ddVyUP|Z2VdijM{@d&tpY&kydHGiU!');
define('AUTH_SALT',        '49SA*-Q?c-7m_Z$MQ!]4ZlzUdm:1sP=Q1q%.ByD^=a=hCKES,0TBK)0f4XJi9siW');
define('SECURE_AUTH_SALT', 'YDIMM>EK!zb#A[8B7q`BO4lz{tf{MU%Ue:m-Vo0YsiAGdmpAP:k0 JfB^%XC>jS/');
define('LOGGED_IN_SALT',   '#pxEc0L91:yH}TUWrd[U6 /=Cy0-sA17d?rN/$Z=Qm1;BuhK*5=e/ $x4?NJ&1,z');
define('NONCE_SALT',       '#(#ZjRq_7<[^f)}i*a*r=eW4&)%m{GQI DAjZN}b&CNIG0(n(J*}s0H-URjkQLJC');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define( 'WP_MEMORY_LIMIT', '256M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

