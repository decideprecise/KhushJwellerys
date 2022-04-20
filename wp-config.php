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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'khushjwellers' );

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
define( 'AUTH_KEY',         ')HUif4QX`@?)Ug!?7%BD${DatErd03L /xmZr2pU%v`Zq30;MQDuG4F,N>N8Q8Oe' );
define( 'SECURE_AUTH_KEY',  '!^8rwr?DR^*x%Q9wlOaXMF$VB[e*+eXe|]<C4)Yy]e716wL { v(:=*[?zo(RlL}' );
define( 'LOGGED_IN_KEY',    '**m=v@H/)}Xc_=`y;5?)d4Q*K,yAcJp*O/,}ki[ WE_F5i=)_.)DG(= uE*JC4.U' );
define( 'NONCE_KEY',        ',<gdK?,~brK(^veRw{.ZY@RF58,Hsy%_R<?[WF]<0)L!3R)gaNj;z[QD]9l*l.Nw' );
define( 'AUTH_SALT',        'c9fA,pG1:m49]9&:yNlV`V2xS)d*(ap`&KBbDW!c;v*dP-%95QG)ixj*0TUFP<&?' );
define( 'SECURE_AUTH_SALT', 'S?!-ctATT`MNS6?t5wK&VB<!k[Vch0yygjJC~$y3)$C!Mb/KOA8m?lOT<G0?,ELk' );
define( 'LOGGED_IN_SALT',   'xm<?5r6xyEXfrhV+-KVUDy%3>T9m#?:*Cdm|m/9<12x%Rg8Z$+Q/UV6M4aHSfA$p' );
define( 'NONCE_SALT',       'Hc]|IHqLxj1SAE=3hfgGft=DB$9p+MgBZN}{Z%2V9}EjSy!;tRT8<rfj%zvG }aX' );

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
