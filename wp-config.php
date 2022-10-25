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
 * @link http://wpdocs.osdn.jp/wp-config.php_%E3%81%AE%E7%B7%A8%E9%9B%86
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
define( 'DB_NAME', 'madoiso2022local' );

/** MySQL データベースのユーザー名 */
define( 'DB_USER', 'root' );

/** MySQL データベースのパスワード */
define( 'DB_PASSWORD', 'root' );

/** MySQL のホスト名 */
define( 'DB_HOST', 'localhost' );

/** データベースのテーブルを作成する際のデータベースの文字セット */
define( 'DB_CHARSET', 'utf8mb4' );

/** データベースの照合順序 (ほとんどの場合変更する必要はありません) */
define('DB_COLLATE', '');

/**#@+
 * 認証用ユニークキー
 *
 * それぞれを異なるユニーク (一意) な文字列に変更してください。
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org の秘密鍵サービス} で自動生成することもできます。
 * 後でいつでも変更して、既存のすべての cookie を無効にできます。これにより、すべてのユーザーを強制的に再ログインさせることになります。
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '%dS|[s%3i*j4lIqZj#EF9pD$v0H1C#@OExSM?fsr;|JWM6P|enmu}RN6OV,mHB>1' );
define( 'SECURE_AUTH_KEY',  '&~H+ tYY_j_?C+{{(Pp(Y)8v+NfG>B3i>?;FyL!qj~;+~b5 Y[R?AH.$XRUvq#jy' );
define( 'LOGGED_IN_KEY',    '^(_}RQ&LyFUu9f4kkd`NdWFt3/4C-{_^TwqOdKfqi_?#O;sWAx^O$bnCaG)AY7p0' );
define( 'NONCE_KEY',        'H,R=DOCW^r4MwG7jwX`?z8UQ>jl~^W!it4gE3k|]>tl++j0{sosUZyEhnnH@U*&l' );
define( 'AUTH_SALT',        '`N]n<&sssPxOEn7&w=%*[nwHSj8*<,P.7 ?%uwF~sffl0uLa60;&whi(@I 0VX/-' );
define( 'SECURE_AUTH_SALT', 'MZrz2]6[{I.o(8 M:HB7CLwrw0t>#`seXW=B9t.qS^NN{E5nU%]r:55W^B6`^D5X' );
define( 'LOGGED_IN_SALT',   'yjxh7:{#d*9%J*G&Y!sVk).i}6BhVw%0Icj~U1/pGql/*Asm>hG=X&+`>7;-;3S@' );
define( 'NONCE_SALT',       'yHm$Dv(TyM0Q|~:KwRu@kq}L[]r2pzXTph/{TQZus ,obOq2JlQAZ*vvB}N|<1C=' );

/**#@-*/

/**
 * WordPress データベーステーブルの接頭辞
 *
 * それぞれにユニーク (一意) な接頭辞を与えることで一つのデータベースに複数の WordPress を
 * インストールすることができます。半角英数字と下線のみを使用してください。
 */
$table_prefix = 'madoiso2022local_';

/**
 * 開発者へ: WordPress デバッグモード
 *
 * この値を true にすると、開発中に注意 (notice) を表示します。
 * テーマおよびプラグインの開発者には、その開発環境においてこの WP_DEBUG を使用することを強く推奨します。
 *
 * その他のデバッグに利用できる定数については Codex をご覧ください。
 *
 * @link http://wpdocs.osdn.jp/WordPress%E3%81%A7%E3%81%AE%E3%83%87%E3%83%90%E3%83%83%E3%82%B0
 */
define('WP_DEBUG', false);

/* 編集が必要なのはここまでです ! WordPress でのパブリッシングをお楽しみください。 */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
