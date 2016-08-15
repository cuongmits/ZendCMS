<?php

namespace Cms;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener; //for commonHelper
use Zend\Mvc\MvcEvent; //for theme

class Module implements AutoloaderProviderInterface {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/', __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e) {
        //AutoloadManager
        $serviceManager = $e->getApplication()->getServiceManager();
        $autoloadManager = $serviceManager->get('AutoloadManager');
        //CommonHelper
        $moduleRouteListencer = new ModuleRouteListener();
        $moduleRouteListencer->attach($e->getApplication()->getEventManager());
        //Acl
        $this->initAcl($e);
        $e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));
        //Constants
        include_once 'constants.php';
    }

    /**
     * Get Service Configuration
     * @return array
     */
    public function getServiceConfig() { //is automatically called by the ModuleManager and applied to the ServiceManager.
        return array(
            'factories' => array(
                'AutoloadManager' => 'Cms\Common\AutoloadManager',
                'Zend\Authentication\AuthenticationService' => function ($sm) {
                    return $sm->get('doctrine.authenticationservice.orm_default');
                }
            )
        );
    }

    public function getControllerPluginConfig() {
        return array(
            'factories' => array(
                'commonHelper' => function(\Zend\ServiceManager\ServiceManager $sm) {
            return new Common\CommonHelper();
        },
            )
        );
    }

    public function initAcl(MvcEvent $e) {

        $acl = new \Zend\Permissions\Acl\Acl();
        $roles = include __DIR__ . '/config/acl.config.php';
        $allResources = array();
        foreach ($roles as $role => $resources) {

            $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
            $acl->addRole($role);

            $allResources = array_merge($resources, $allResources);

            //adding resources
            foreach ($resources as $resource) {
                if (!$acl->hasResource($resource)) {
                    $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                }
            }
            //adding restrictions
            foreach ($allResources as $resource) {
                $acl->allow($role, $resource);
            }
        }
        //set acl into view
        $e->getViewModel()->acl = $acl;
    }

    public function checkAcl(MvcEvent $e) {
        $route = $e->getRouteMatch()->getMatchedRouteName();

        //default role
        $userRole = 'subscriber';

        $authenManager = $e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService');
        if ($authenManager->hasIdentity()) {
            $identity = $authenManager->getIdentity();
            foreach ($identity->getUsermetas() as $userMeta) {
                if ($userMeta->getMetaKey() == 'wp_capabilities') {
                    if (strpos($userMeta->getMetaValue(), 'administrator')!== false)
                        $userRole = 'administrator';
                    elseif (strpos($userMeta->getMetaValue(), 'editor')!== false)
                        $userRole = 'editor';
                    elseif (strpos($userMeta->getMetaValue(), 'author')!== false)
                        $userRole = 'author';
                    elseif (strpos($userMeta->getMetaValue(), 'contributor')!== false)
                        $userRole = 'contributor';
                }
            }
        }

        if ($e->getViewModel()->acl->hasResource($route) && !$e->getViewModel()->acl->isAllowed($userRole, $route)) {
            $response = $e->getResponse();
            $scheme = $e->getRequest()->getUri()->getScheme();
            $host = $e->getRequest()->getUri()->getHost();
            //redirect to login page
            $response->getHeaders()->addHeaderLine('Location', $scheme . '://' . $host . '/authen');
            $response->setStatusCode(302);
        }
    }

}
