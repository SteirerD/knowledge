<?php
define( 'WP_MEMORY_LIMIT', '256M' );
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
define( 'DB_NAME', 'd030380f' );

/** MySQL database username */
define( 'DB_USER', 'd030380f' );

/** MySQL database password */
define( 'DB_PASSWORD', 'tJZkrEfkQY8JarKUEzWB' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'FRSR1E`Yc17.4tFsZsxr2f7dAuFk-oiYx#=#!281nYW2TX$f<:1en?cA-XCK/D>N' );
define( 'SECURE_AUTH_KEY',  '>V{[_.U/s9OabY`Lo}#3K[he1t`[YMDUg_hqh5Hme-IRW9obNX7(RLN@9X+2PZ)>' );
define( 'LOGGED_IN_KEY',    'av+JuY|CKaE]x58rQ-XaI@ujji;Pd{@1q)/6!9PnB3wAFl<|%$e!|x.T{LG*62V[' );
define( 'NONCE_KEY',        '}xF_HU>*QJ8@fG5h=t;hkNLr%4@}6a#5?V$[%Ll(HkTw=BlSx;TSSe,DFpK?v7*h' );
define( 'AUTH_SALT',        'UeC}@>QMDNCm8(}Ce#!7g!T}jVVNm8o95Hi@bN1}ASu;t#GIqtsyvnRXc}I65&?J' );
define( 'SECURE_AUTH_SALT', 'Blk)/s%`#x$n!!neA2uqH!RcNJx6MUxN}#S)`nyUViPuKe6(?F7*4g;c4jsW1v*=' );
define( 'LOGGED_IN_SALT',   'E4[6/?<qm)@H<<}^9L9r]P{pjIG)HJ:A`;RZZ*x]!$6nUcm+>U3+2t/hI)TR8;X!' );
define( 'NONCE_SALT',       'Db)#@m+Is><h4Ty%67|,Jv]W^naPo$rXa4*`pL%}suIG`WP_]DxDWOyC]U}Dq7c4' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ubqdi_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );