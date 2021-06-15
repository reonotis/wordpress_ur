<?php
/**
 * WordPress の基本設定
 *
 * このファイルは、インストール時に wp-config.php 作成ウィザードが利用します。
 * ウィザードを介さずにこのファイルを "wp-config.php" という名前でコピーして
 * 直接編集して値を入力してもかまいません。
 *
 * このファイルは、以下の設定を含みます。
 *
 * * MySQL 設定
 * * 秘密鍵
 * * データベーステーブル接頭辞
 * * ABSPATH
 *
 * @link https://ja.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// 注意:
// Windows の "メモ帳" でこのファイルを編集しないでください !
// 問題なく使えるテキストエディタ
// (http://wpdocs.osdn.jp/%E7%94%A8%E8%AA%9E%E9%9B%86#.E3.83.86.E3.82.AD.E3.82.B9.E3.83.88.E3.82.A8.E3.83.87.E3.82.A3.E3.82.BF 参照)
// を使用し、必ず UTF-8 の BOM なし (UTF-8N) で保存してください。

// ** MySQL 設定 - この情報はホスティング先から入手してください。 ** //
/** WordPress のためのデータベース名 */
define( 'DB_NAME', 'wordpress_ur' );

/** MySQL データベースのユーザー名 */
define( 'DB_USER', 'wordpress_ur' );

/** MySQL データベースのパスワード */
define( 'DB_PASSWORD', 'wordpress_ur' );

/** MySQL のホスト名 */
define( 'DB_HOST', 'localhost' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8mb4' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define( 'DB_COLLATE', '' );

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ZMQ$q//<`h$%EPGR/(KVlB<X?zUYQV_pc|B*j-H}i1=wESMk0a<aya95RvCy0oh1' );
define( 'SECURE_AUTH_KEY',  'n}8O?t1R<PIZPRG}Z#o3#dkUx8s][c0vKmDkDOmb[;?q>EJB iHoF|emtcGb6XJs' );
define( 'LOGGED_IN_KEY',    'vx7/r`3c+;l<3-3tb6!XXSdBt/ojQ93}7QsewtOUgs~XM!u*R 1z^R%j$%sY`pY)' );
define( 'NONCE_KEY',        '/FP$<pwjbB9IuJiQ@7k,`tfdQJhjtSMjxygjihBNYqeh-0<wal+/b~0/NED`ZK,F' );
define( 'AUTH_SALT',        '[Gs$tS0P/qSd<TeYqWcB67n9wE?sZ;%~0Xvet{6k@G(aDa)Ulk$0T+4jU/T=PZ`G' );
define( 'SECURE_AUTH_SALT', '>c*Dx9a.jYR;e0OV{Ge.4Ld_2?xjO-g[RqmJ6tcU:p&)dTY2CI1Jw%$0xYJk-Exf' );
define( 'LOGGED_IN_SALT',   ']||l-L?N2YXf$?Up7{jL`21Me-3wP7HkaYKU$vpZwvZu*w.Q}A8-:}(jh.{gitfc' );
define( 'NONCE_SALT',       'L4o[$HA=)$7xp;Q-i0(<ZVEX/#z5k2ej!H%L1Q{zXjVxw$>zkK)_:T{zajg]nw%.' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'ur_wp';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数についてはドキュメンテーションをご覧ください。
 *
 * @link https://ja.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
