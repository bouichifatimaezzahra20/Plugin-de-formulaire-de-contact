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
define( 'DB_NAME', 'Plugin_de_formulaire' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'bouichi2002' );

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
define( 'AUTH_KEY',         '@A!5$OU1V&g[U75R,Xo]aQ?GxHL[ROCxODQ?{zt.SY3wVWwF7_g*B,+uyWf u=14' );
define( 'SECURE_AUTH_KEY',  'XX?CHiH$q#o}.uy]51R` S>y P/7lVAd,Ln-#r?gj$.yb{+>b$JHI+mGvH[uG.G`' );
define( 'LOGGED_IN_KEY',    'l{jXQ<95(Nhny6BVA`|@6ye]y^wy$ g]30!R!(uKo/RO]}a`17*VyM@3<_0byr/&' );
define( 'NONCE_KEY',        '+**hl*dQ1zo)fr7L}6mAG!EFDfQSD/e8qG)8m?onl}a*=2CM%>.9d9<tkw^h2*fk' );
define( 'AUTH_SALT',        '# cm]fUN+3TIX^$A7=W}z#),@{y^lu=m%b2W5kbjDA^,f=zph8bUR]li+u4b8DxL' );
define( 'SECURE_AUTH_SALT', '65Q72[XwHKOg!JT6oM(GVE=?TV!4]FK@)!nhH@i_2EJA#0{Z=C/mguc(v!X.SqzQ' );
define( 'LOGGED_IN_SALT',   ')SN:QGmRM;_*,)_?4PGKy~dT+>04?f^%P7ZJa0qD{|u$a@P&U(x(@X/e8!3;S#.!' );
define( 'NONCE_SALT',       'NNFRz709;M6R-AB-`Y=cz4N_n[#uBH<R07Ka.?$MM2p~RfT_S I{n~CQsqMt.`TY' );

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
