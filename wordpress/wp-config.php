<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'my_db' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'GAlPf+v3$yhGa61-fcPYC+NMI)^{tOsSi7>^#D&HQB:)AK9L8|B_l5JArF+[}d>h' );
define( 'SECURE_AUTH_KEY',  '0mI(]v7=G8#9?3=k3mw;`oV3ZyZX5Q-CVYwfURBvGt5nUgLvhv[MBJ5/]_{LM^?}' );
define( 'LOGGED_IN_KEY',    '%4n#?K^I|b5UI1I{vUy[b_fZ4WuBZHCJ6dDnhFKz1^ W}^KFKO+!5Z17}apqpN8|' );
define( 'NONCE_KEY',        'T7]LY|]`y`[H`)Vs5am}UZpbYb0S.f]V00@1jb[m`WFl6B}8h9=1O0Jf&;FeoSsk' );
define( 'AUTH_SALT',        'h.|x_apuqL;O&r9kB3]|Pdz,!<S>Dh=VZtH?;w%sYFiNWIEOnTc5d$U)-1,5I$5I' );
define( 'SECURE_AUTH_SALT', 'a4=Ix]wHUbw4}/8`6&Y_Pu)<2>:9~v~7HFR+C)@Z a$(Y1$*#xMH1i:*U)~R.OWK' );
define( 'LOGGED_IN_SALT',   'wHGdr]_>7}{/^A((;&eOE&>Vd7_I@z*CbTxAmk504_Ww3a;uNsc!PDyYJqEX|W,y' );
define( 'NONCE_SALT',       'bDz,Bc@k3HcrQM+GN#>W_jSz.wvd:xs4?Egb0dFQ0h,JS{psx!C@5bwT|X;/qzwM' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */



/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
