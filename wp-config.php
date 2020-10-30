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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mexpro' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ae xe0[)Of=B3p`P*@y-AXYDcX50-tge0*fVP@D vd7KF<5318?$Jr$+kKi`}3B?' );
define( 'SECURE_AUTH_KEY',  'CV;M?|Jhcp$e%l;(x};nw*AA,o5WJ.~GA/GUb;;N(Qt9F)h9j}:fk&@Yp>tS|010' );
define( 'LOGGED_IN_KEY',    ',hU1H]yef//yv!530?)0D6/jMYW,;IuXNimz?UM]F0^T=vJ[oH!5.Toy}FY+@GVx' );
define( 'NONCE_KEY',        'E1}E.wq`_q<.DI~A$O6n:lz(R%IWi>iuT&o%!,&xwKT2BT1ewE9juTWj5H2-/O=v' );
define( 'AUTH_SALT',        '6@N2youR<z[j?+{g5w;.P1$94?DT/OmY#7= Ip:( lr5(;~|D>V30n6<6cfu8^n1' );
define( 'SECURE_AUTH_SALT', 'z@%Ap%Hzo,&KdBFxrxYf0#A>%([e q)CE7QxnXJbu$U>#Xq=e(Y|OG1f%T*6A,Xv' );
define( 'LOGGED_IN_SALT',   '7@Vv9RU-AM#MuiiAb<BL~KJ mNCL&ZKC2<gi@_RD(sl7tcOsL-(JSS)ZwVAa-X?5' );
define( 'NONCE_SALT',       '+#2-PF$(DDhM5hs[uihOvS[[+7hT^vwsG: z2H$I@I/!]>?_R4Gpr*jQ0WZhoVz8' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
