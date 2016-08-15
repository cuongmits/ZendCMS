<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/* ----------- */
define('SITE_URL', 'http://localhost/');
define('UPLOAD_FOLDER', './public/uploads/');
define('PAGE_TEMPLATE', 0);

/* GLOBAL CONSTANTS */
define('POST_QUANTITY_IN_A_PAGE', 5);

/* PATH */

/* database */
define('DB_NAME', 'wordpress');
define('DB_PREFIX', 'wp_'); //'xxi_'
define('DB_COMMENTMETA', DB_PREFIX.'commentmeta');
define('DB_COMMENTS', DB_PREFIX.'comments');
define('DB_LINKS', DB_PREFIX.'links');
define('DB_OPTIONS', DB_PREFIX.'options');
define('DB_POSTMETA', DB_PREFIX.'postmeta');
define('DB_POSTS', DB_PREFIX.'posts');
define('DB_TERMS', DB_PREFIX.'terms');
define('DB_TERM_RELATIONSHIPS', DB_PREFIX.'term_relationships');
define('DB_TERM_TAXONOMY', DB_PREFIX.'term_taxonomy');
define('DB_USERMETA', DB_PREFIX.'usermeta');
define('DB_USERS', DB_PREFIX.'users');

/* Message */
define('MESSAGE_ITEM_ALREADY_EXISTS', 'You cannot add new item because it already exists.');
define('MESSAGE_SUCCESS', 'Process has been done successfully.');
define('MESSAGE_INVALID', 'Something is invalid, please check.');
define('MESSAGE_ITEM_DOESNT_EXIST', 'Error: Item doesn\' exist.');
define('MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM', 'Someone is doing something with this item at the moment, please wait until he finish it then you can continue by fresh F5.');

/* Others */
define('MAX_UPLOAD_FILE_SIZE', 1024*1024*100); //100MB
define('VALID_UPLOAD_FILE_TYPES', 'image/png, image/x-png, image/gif, image/jpeg');