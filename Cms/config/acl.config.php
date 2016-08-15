<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return array(
    'subscriber'=> array(
        'home/view',
        'home/Authen',
    ),
    'contributor'=> array(
        'home/Dashboard',
        'home/Post',
    ),
    'author'=> array(
        'home/Media',
    ),
    'editor'=> array(
        'home/Category',
        'home/Tag',
        'home/Page',
        'home/Comment',
    ),
    'administrator'=> array(
        'home/Appearance',
        'home/User',
    ),
);