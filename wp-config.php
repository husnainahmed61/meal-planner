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
define( 'DB_NAME', 'wordpress' );

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
define( 'AUTH_KEY',         'y=!#Knd |(TP]le%(Th1Kb]MP=%gFGqx,D0%5n>U*5*FtgZc;{<$#43w;!l{:&-J' );
define( 'SECURE_AUTH_KEY',  'yj[dCmgp,m.PSUBSYP}K }DE%pnA*C4s)vza4^j%cwu$@;JO;G0hD>/w$gu~`Ky*' );
define( 'LOGGED_IN_KEY',    'O3P>ZpG$L#3akI0,|r$]vN0!o}$R;D;beqq60]KF,/@t6!:M)2HBwN?MwXquW%^9' );
define( 'NONCE_KEY',        '+$S0l3;L=1Sw kq|y<gWf+1#2Q%PWem8mVE]aH%kjc=)V0&=gb(PLZdM9@O?)=,z' );
define( 'AUTH_SALT',        '@q4~k/H),fi9cTV73PzpS]}K->J_N$PM%r6seP(jYJ%]!Th3p0t:3Dbbxso5+]<S' );
define( 'SECURE_AUTH_SALT', 'Bv>}usu Z8zO(Ql}4 vPaw2)#,&qJr{etZ!HLUb_sV|W4VdN1:^a5bF/}.bE2ate' );
define( 'LOGGED_IN_SALT',   'L>o+H{hkN=4S}z* B=]z+DV_v3s.:Y]*7^w])r*;IBoWW 7+AF66LN_LIc93~E5w' );
define( 'NONCE_SALT',       '$9V/2|55Y:}vbV5w>dz$asfvo$Rl;o#HpEb-Q/w:;S{L#)Q9xqbUvapa[64_i`(>' );

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
