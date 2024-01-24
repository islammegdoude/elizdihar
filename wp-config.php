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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'izdihar' );

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
define( 'AUTH_KEY',         'i%:o@eQGvJS{lhvk#*c*:OlLc0FI;zO1&:flOfu@hKL#G|6j4dgm/Y]r2c?@@^)M' );
define( 'SECURE_AUTH_KEY',  '8we|V&1G2b2j7*6D(?mkg/M``Nzm4xR+kD~NGRG2<Lv2$V~;K2&@hTsuJ_|81o&y' );
define( 'LOGGED_IN_KEY',    '|)F8Q`0 ,~_Eals$B{NnB/a!aDQyBHJ(B!X{|Kp$%R/9)R{Aci/CUB?vsmJL.;8K' );
define( 'NONCE_KEY',        'I4UN#yQ|<Nvg>yuFIIUp&d+H f0N*8w/YFB~d]<EyF-8I3Q[9KS$iw`34m[|y]py' );
define( 'AUTH_SALT',        'H*hh57ACT,5R`KrvMC dj/Ico6T)3XtsuM{XGOzS2X:5eHs#1ZFbShW55,{ HfHH' );
define( 'SECURE_AUTH_SALT', 'e0]G-qFc!V/dW.O+8dmw! ?Dy?EK0^Zn#Rr[|GiVe/pq&j]sT)14Y6o )<I6p)nw' );
define( 'LOGGED_IN_SALT',   'Aavt)v1ZHxTK:gAB)#g/WbvR4Uj1kL%$-9=k{u=m`aLj#+p@Z3>|4c7m6^;d~TPR' );
define( 'NONCE_SALT',       'G),Xf?Ms8-7Q/ -j~^AS vu(s}XA:aQ(JlMx_PH39mq*/ESM0t)z_leUVze9qcBY' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
