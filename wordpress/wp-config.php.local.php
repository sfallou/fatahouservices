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
define('DB_NAME', 'fatahouservices');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'passer');

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
define('AUTH_KEY',         '[*LDqse8|fR@|CFWIBZ*lE]a(UYURpCpsn& 1WaliSS}R<`-<FrUcD)v8R^huKGq');
define('SECURE_AUTH_KEY',  ',iW35Obz~T9z5:B$X!}J)e`oRZ^CNIu3A]f36{W$$zp:Ci-61IbA n!tG@-2za4]');
define('LOGGED_IN_KEY',    '.;i6].)MAeCmof$Vkr&:bu8NmEfW+`8P<=,=g*rhm:Hd.(MkJ)T9L$(RE`uw^kl1');
define('NONCE_KEY',        'K2Kd_O?W+?{~#qa cA]n5Uap<U2.&h_x,Tu,-PI62Z&diLgrpT/@RtE>~yO_>KY~');
define('AUTH_SALT',        'wv#jB]rIdaY/xLVvMipcfXsO.Mst79tg?uK^KZ[lUFs=DhSsV_wQ*VzH@a`gPU0i');
define('SECURE_AUTH_SALT', 'qAD%<X,_)&nznEIw}Tw*wU[loHW>o/;?wqC}0rpC;w33+ zB!mVX*W $!LQFk}qP');
define('LOGGED_IN_SALT',   'IU0&9 gD|%Kdjp=|KAg.IU#X?1+ASHd`h*xu-6!6{S:X0W3Ws e[)5@$$Od.~~*&');
define('NONCE_SALT',       'nYcQ}:JJR-1u_2|oPM/5xoeh,8fR%=|j:UtR/$puQ~*{H_Y#GGS)1V^+tG!}99!1');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'avpy_';

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
