<?php
/**
 * Define database credentials
 */
define("DB_HOST", "localhost"); 
define("DB_NAME", "instagram"); 
define("DB_USER", "root"); 
define("DB_PASS", "secret"); 
define("DB_ENCODING", "utf8"); // DB connnection charset


/**
 * Define DB tables
 */
define("TABLE_PREFIX", "");

// Set table names without prefix
define("TABLE_USERS", "users");
define("TABLE_ACCOUNTS", "accounts");
define("TABLE_PACKAGES", "packages");
define("TABLE_POSTS", "posts");
define("TABLE_GENERAL_DATA", "general_data");
define("TABLE_OPTIONS", "options");
define("TABLE_ORDERS", "orders");

define("TABLE_FILES", "post_medias");
define("TABLE_CAPTIONS", "captions");
define("TABLE_PROXIES", "proxies");

define("TABLE_PLUGINS", "plugins");
define("TABLE_THEMES", "themes");
