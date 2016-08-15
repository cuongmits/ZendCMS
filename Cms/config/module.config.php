<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cms;

return array(
    'controllers' => array(
        'invokables' => array(
            'Cms\Controller\Post' => 'Cms\Controller\PostController',
            'Cms\Controller\Comment' => 'Cms\Controller\CommentController',
            'Cms\Controller\User' => 'Cms\Controller\UserController',
            'Cms\Controller\Media' => 'Cms\Controller\MediaController',
            'Cms\Controller\Tag' => 'Cms\Controller\TagController',
            'Cms\Controller\Category' => 'Cms\Controller\CategoryController',
            'Cms\Controller\Page' => 'Cms\Controller\PageController',
            'Cms\Controller\Dashboard' => 'Cms\Controller\DashboardController',
            'Cms\Controller\Appearance' => 'Cms\Controller\AppearanceController',
            'Cms\Controller\Contact' => 'Cms\Controller\ContactController',
            'Cms\Controller\View' => 'Cms\Controller\ViewController',
            'Cms\Controller\Authen' => 'Cms\Controller\AuthenController',
        ),
    ),
    'navigation' => array(
        'default' => array(
            'dashboard' => array(
                'label' => 'Dashboard',
                'route' => 'home/Dashboard',
                'resource' => 'home/Dashboard',
            ),
            'post' => array(
                'label' => 'Post',
                'route' => 'home/Post',
                'resource' => 'home/Post',
                'pages' => array(
                    'add' => array(
                        'label' => 'Add New',
                        'route' => 'home/Post',
                        'action' => 'add',
                    ),
                    'category' => array(
                        'label' => 'Categories',
                        'route' => 'home/Category',
                        'resource' => 'home/Category',
                    ),
                    'tag' => array(
                        'label' => 'Tags',
                        'route' => 'home/Tag',
                        'resource' => 'home/Tag',
                    ),
                ),
            ),
            'media' => array(
                'label' => 'Media',
                'route' => 'home/Media',
                'resource' => 'home/Media',
                'pages' => array(
                    'library' => array(
                        'label' => 'Library',
                        'route' => 'home/Media',
                        'action' => 'index',
                    ),
                    'add' => array(
                        'label' => 'Add New',
                        'route' => 'home/Media',
                        'action' => 'add',
                    ),
                ),
            ),
            'page' => array(
                'label' => 'Pages',
                'route' => 'home/Page',
                'resource' => 'home/Page',
                'pages' => array(
                    'library' => array(
                        'label' => 'All Pages',
                        'route' => 'home/Page',
                        'action' => 'page',
                    ),
                    'add' => array(
                        'label' => 'Add New',
                        'route' => 'home/Page',
                        'action' => 'add',
                    ),
                ),
            ),
            'comment' => array(
                'label' => 'Comment',
                'route' => 'home/Comment', 
                'resource' => 'home/Comment',
            ),
            'appearance' => array(
                'label' => 'Appearance',
                'route' => 'home/Appearance',
                'resource' => 'home/Appearance',
                'pages' => array(
                    'theme' => array(
                        'label' => 'Theme',
                        'route' => 'home/Appearance',
                        'action' => 'theme',
                    ),
                ),
            ),
            'user' => array(
                'label' => 'User',
                'route' => 'home/User',
                'resource' => 'home/User',
                'pages' => array(
                    'all' => array(
                        'label' => 'All Users',
                        'route' => 'home/User',
                        'action' => 'all',
                    ),
                    'add' => array(
                        'label' => 'Add New',
                        'route' => 'home/User',
                        'action' => 'add',
                    ),
                    'profile' => array(
                        'label' => 'Your Profile',
                        'route' => 'home/User',
                        'action' => 'edit',
                    ),
                ),
            ),
            'logout' => array(
                'label' => 'Logout',
                'route' => 'home/Authen',
                'action' => 'logout',
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Cms\Controller\View',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'view' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route'    => '[:slug]',
                            'constrains' => array(
                                'slug' => '[a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'action'     => 'view',
                            ),
                        ),
                    ),
                    'Post' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'post[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Post',
                                'action'        => 'post',
                                'id'            => 1,
                            ),
                        ),
                    ),
                    'Appearance' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'appearance[/:action[/:themename]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z0-9_-]+',
                                'themename' => '[a-zA-Z0-9_-]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Cms\Controller\Appearance',
                                'action' => 'theme',
                                'themename' => null,
                            ),
                        ),
                    ),
                    'Comment' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'comment[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z0-9_-]+',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Cms\Controller\Comment',
                                'action' => 'all',
                                'id' => 1,
                            ),
                        ),
                    ),
                    'User' => array(
                        'type' => 'segment',
                        'options' => array(
                            //'route' => '/comment[/:action[/page:id]]', //test to see
                            'route' => 'user[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z0-9_-]+', //zend 2.3
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Cms\Controller\User',
                                'action' => 'all',
                                'id' => 1,
                            ),
                        ),
                    ),
                    'Media' => array(
                        'type'    => 'segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => 'media[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Media',
                                'action'        => 'index',
                                'id'            => 1,
                            ),
                        ),
                    ),
                    'Tag' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'tag[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Tag',
                                'action'        => 'index',
                                'id'            => 1,
                            ),
                        ),
                    ),
                    'Category' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => 'category[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Category',
                                'action'        => 'index',
                                'id'            => 1,
                            ),
                        ),
                    ),
                    'Page' => array(
                        'type'    => 'segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => 'page[/:action][/:id]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Page',
                                'action'        => 'page',
                                'id'            => 1,
                            ),
                        ),
                    ),
                    'Dashboard' => array(
                        'type'    => 'segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => 'dashboard',
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Dashboard',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'Contact' => array(
                        'type'    => 'segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => 'contact',
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Contact',
                                'action'        => 'index',
                            ),
                        ),
                    ),
                    'Authen' => array(
                        'type'    => 'segment',
                        'options' => array(
                            // Change this to something specific to your module
                            'route'    => 'authen[/:action[/:id]]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller'    => 'Cms\Controller\Authen',
                                'action'        => 'login',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    
    // Doctrine config - Ko cho vao local.php duoc
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Cms\Entity\WpUsers',
                'identity_property' => 'userLogin',
                'credential_property' => 'userPass',
                'credential_callable' => function(Entity\WpUsers $user, $givenPassword) {
                    $hasher = new Controller\PasswordHash(8, TRUE);
                    $hash = $hasher->HashPassword(trim($givenPassword));
                    if ($hasher->CheckPassword($givenPassword, $user->getUserPass()) && $user->getUserActivationKey()== '') { //null or ''?
                        return true;
                    } else {
                        return false;
                    }
                },
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        //'locale' => 'en_US',
        //'locale' => 'fr_CA',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
                'text_domain' => __NAMESPACE__,
            ),
        ),
    ),

    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
    
);
