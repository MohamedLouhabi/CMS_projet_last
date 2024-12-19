<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'CMS' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
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
define( 'AUTH_KEY',         'B?btnsCFa<H,>U_~~Ib<S|IM]CDRL5.?=-vTXHml{F#7%0{]sBQ7<UO`~LLq5L`!' );
define( 'SECURE_AUTH_KEY',  '&O==>K/^J#jX8+C3^G97zG$6]trdVc{$-7(_Y4[d,:?3%X1*sB(rQ0DKv[_} Ar3' );
define( 'LOGGED_IN_KEY',    'q;qY5`s! r`/A.&Kg`JqwV]#,/AiT.W~qmsFubM6:$[)Dq-gD2{%l?M>q.JKu<wF' );
define( 'NONCE_KEY',        '@EDSZ.^Z-]KMbgHQMwd`Vg2pT9jOHxSKbhIJey>o^lxfTvkuV+^XLq5XC:*^L?QN' );
define( 'AUTH_SALT',        'e=[xK1luegi_b5Y@h8{_85pjcLAXxgS 0njSYpmahoSo_Y?:O*gA:>3[m8p0]c;O' );
define( 'SECURE_AUTH_SALT', '%h/wD,ej;!8zi~ym7Dl)lg1r5| E](YDpX|$Xb;f5bn8KH3W8U;kE{Q7dc$xql)x' );
define( 'LOGGED_IN_SALT',   'wR`koaqHWROF9R)2p![6KDhhDJYN}24p#4>e3T+wfu-5lpt0J>YkyAn|OjpX`jqZ' );
define( 'NONCE_SALT',       'YtFt@6Q+Y39>XXn<ZWe9O|G=t2:9M:Rq#?XLd]}LDn/!QXsM56zg-{2{V:Bn~TL/' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
