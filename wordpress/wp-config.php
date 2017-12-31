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
define('DB_NAME', 'u487353156_unuby');

/** MySQL database username */
define('DB_USER', 'u487353156_aqyje');

/** MySQL database password */
define('DB_PASSWORD', 'aHaTeDateg');

/** MySQL hostname */
define('DB_HOST', 'mysql');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'AVVeEGyM0P8DH03PPvLTp1QxCkMQ1VHT7pDh07Ck9v4GXl5gEFvXRJnDXN3vYJin');
define('SECURE_AUTH_KEY',  '7boP5HXWFanwzyor98P3g4haQ7W1TLIupua3UDMyMAnxhLsL2pZO1IBLWoSwDmHZ');
define('LOGGED_IN_KEY',    'Msw61pWrpMXHxCdsuWoHEzyRYPFIRCG7LSPd1hdZ99jy5Fywln2Wss0dOtmqHSiX');
define('NONCE_KEY',        'QpUzlmbNMOoNfbc96xQPYgl13KdqicGMLAWJvhwtdFle2XEzztiYkbZ0M91ABm3O');
define('AUTH_SALT',        '7mjnoVMEnVhDq45MRt9ekrIT39fpUFCkUAz9x4AaA0QjjNebXZ0k0WtDUxdiyYFO');
define('SECURE_AUTH_SALT', 'NiipJCxJWcARK6UYDfbmkjkI13Dfv4qvMKvIQMGDQ1pio7h58zCupPxkfcmIerqV');
define('LOGGED_IN_SALT',   '8n3qdYZ6DH8yyf9NXPMay2SFnVS9WA1tYdnDFVdk1lHymuskfQlXhqmHNUBJ9i6m');
define('NONCE_SALT',       'Q76QKwceQO1A7FFW6iweNv3chq6EPalQrLm1sexVekmzzBCpvakvR7PYGAEEEgQc');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
