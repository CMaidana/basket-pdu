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
define('DB_NAME', 'deporte');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'I>u!ZMG%?Vb/;+$8&[EuTg1n$Zd]024d(ZTYw3=J6vtTy&UVa=XwQ=0K~P lD)Jt');
define('SECURE_AUTH_KEY',  ':G8ld.BH6&.MX/MIB>m[t^C2SLn]8wa<{~Z*Kk(mF#8_-cgX5V*}3v0Z>+Rxru&Q');
define('LOGGED_IN_KEY',    ':8Su>b~id1uiyef a[jL{*v^%~/pPD[D@brNK:Gd5heF[}4=(uE39aIh@e-Y=ec^');
define('NONCE_KEY',        '|]|||.KwLY?rpaf5W!.TsKov7f;uDM<K84!l*;vu|byARiejYHt8Ym+|n-`/IcjI');
define('AUTH_SALT',        '9azYU_S{4brW1f2q]ZzA.+p)QZzh(.Nb` 0h|,O44# KqtKbb56KtZ~mF&^&P!:,');
define('SECURE_AUTH_SALT', '1|q2_3f={>2jbLOeHCHv`x<WM=u*atsvbz}jleB12M#t%54Y}DhSyF&rHK $+:j|');
define('LOGGED_IN_SALT',   'p2|VY{-E~tdk24D<pC=CcNVJBla`@*bjv][yFWn8uzR}N?A3bop]=-Q4#VBt]1q.');
define('NONCE_SALT',       't&qnO*F?b}sTozZ.38Me 6`+_-%tG^gspzW.7SN[z;~X`*-<dI1;y+0Kcq+wQf,s');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
