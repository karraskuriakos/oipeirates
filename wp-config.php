<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

define('WP_MEMORY_LIMIT', '256M'); 
define('WP_HOME','https://oipeirates.pro');
define('WP_SITEURL','https://oipeirates.pro');
define('ENFORCE_GZIP', true);
define('WP_POST_REVISIONS', false);
define('AUTOSAVE_INTERVAL', 300 );

define('FS_METHOD','direct');

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

// ** MySQL settings ** //
/** The name of the database for WordPress */
define('DB_NAME', 'xrysoise_wp');
#define( 'DB_NAME', 'oipeirates_tv' );

/** MySQL database username */
define('DB_USER', 'xrysoise_wp');
#define( 'DB_USER', 'oipeirates_tv' );

/** MySQL database password */
define('DB_PASSWORD', '6xlS6zq0P4');
#define( 'DB_PASSWORD', 'AeOWNxPcFZMsgDq' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
#define( 'AUTH_KEY',         'SVlCHlz|d5jQLhi;rVaS1-.bAr2|fCrb,}e4-*Ocye(!jSCs/A6Ao`T:h)nQ_l|H' );
#define( 'SECURE_AUTH_KEY',  'J3BeXQ@w#|y djS~C6OXU1]Ls2n^ruE1^rG=FWD]zo*!u?hnpJ1/ag(oaAx?4^z[' );
#define( 'LOGGED_IN_KEY',    'x/V_.=N0lH@FJ^-nB!8;E?H`[%MH/fu,WT|Vc.A^+=eS2N>7|]dBRrC_DO71!8-D' );
#define( 'NONCE_KEY',        'mcQwY2f ^&vS;G[[HR]x F4Kd?&)wle@d)#b]S:A%p6$)I>]j*H&gch#L3nbAK)%' );
#define( 'AUTH_SALT',        '{d[Ap<Z30N@AGXz/=n<0NX#xZ{5~Ptm(usKy,+l8A8^#V&X>0&@{[K0!PZV2K>o>' );
#define( 'SECURE_AUTH_SALT', '^(.@rD{`}b!(qZsi1/7pSX.{ @RO*Rd/BOjR/cp0J(%sQI%6tLC1vt|I/?2+;$Ya' );
#define( 'LOGGED_IN_SALT',   '[-];&UpxO<(njnY|*Bws?F@Q$!rwSmcEd3s.o#g+9Y<`HOf96iDEYl??=K|n)R]I' );
#define( 'NONCE_SALT',       'Y^7(c2TNWHL[d,Y %}Jt=QnK3cwBM1Tm|pWQ`|zQz4QVy-31@GpwW~*gCHT%Leb;' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

define('WP_DEBUG', false); 

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) )
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
