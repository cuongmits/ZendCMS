<?php
//Theme Configuration
return array(
    'template_path_stack' => array(
        'default' => __DIR__ . '/view',
    ),
    'template_map' => array(
        'layout/layout'             => __DIR__ . '/view/layout/layout.phtml',
        'error/404'                 => __DIR__ . '/view/error/404.phtml',
        'error/index'               => __DIR__ . '/view/error/index.phtml', 
        
        'layout/index'              => __DIR__ . '/view/layout/index.phtml',
        'layout/contact'            => __DIR__ . '/view/layout/contact.phtml',
        'layout/block'              => __DIR__ . '/view/layout/common/block.phtml',
        'layout/block/lastPost'     => __DIR__ . '/view/layout/common/block-lastPost.phtml',
        'layout/block/login'        => __DIR__ . '/view/layout/common/block-login.phtml',
        'layout/block/categories'   => __DIR__ . '/view/layout/common/block-categories.phtml',
        'layout/block/image'   => __DIR__ . '/view/layout/common/block-image.phtml',
    ),
);