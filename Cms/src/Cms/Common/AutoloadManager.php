<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMS\Common;
use Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface,
    Doctrine\ORM\EntityManager,
    Cms\Entity\WpOptions;

/**
 * Cms Autoload Manager factory
 * @package Cms
 * @author Keon Nguyen <cuongmits@gmail.com>
 */
class AutoloadManager implements FactoryInterface 
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager($serviceLocator)
    {
        if (null === $this->em) {
            $this->em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }    
    
    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        /* Theme Init */
        
        //get current theme
        $option = $this->getEntityManager($serviceLocator)->getRepository('Cms\Entity\WpOptions')->findOneBy(array(
            'optionName' => 'template',
        ));
        if ($option) {
            $themename = $option->getOptionValue();
        } else {
            $themename = 'default';
        }
        
        //get config.php file from theme folder
        $configFile = ROOT_PATH . '/module/Cms/themes/'.$themename.'/config.php';
        $config = include ($configFile);
        
        $serviceLocator->get('ViewTemplateMapResolver')->add($config['template_map']);
        $serviceLocator->get('ViewTemplatePathStack')->addPaths($config['template_path_stack']);
        
        $mapResolver = new \Zend\View\Resolver\TemplateMapResolver($config['template_map']);
        $themeResolver = new \Zend\View\Resolver\AggregateResolver();
        $themeResolver->attach($mapResolver);

        $pathResolver = new \Zend\View\Resolver\TemplatePathStack(array(
            'script_paths'=>$config['template_path_stack']
        ));        
        $pathResolver->setDefaultSuffix($serviceLocator->get('ViewTemplatePathStack')->getDefaultSuffix());
        $themeResolver->attach($pathResolver);
        
        //set new theme to take effect to system
        $serviceLocator->get('ViewResolver')->attach($themeResolver, 100);
        /*
        $viewResolver = $serviceLocator->get('ViewResolver');
        $themeResolver = new \Zend\View\Resolver\AggregateResolver();
        if (isset($config['template_map'])){
            $viewResolverMap = $serviceLocator->get('ViewTemplateMapResolver');
            $viewResolverMap->add($config['template_map']);
            $mapResolver = new \Zend\View\Resolver\TemplateMapResolver(
                $config['template_map']
            );
            $themeResolver->attach($mapResolver);
        }

        if (isset($config['template_path_stack'])){
            $viewResolverPathStack = $serviceLocator->get('ViewTemplatePathStack');
            $viewResolverPathStack->addPaths($config['template_path_stack']);
            $pathResolver = new \Zend\View\Resolver\TemplatePathStack(
                array('script_paths'=>$config['template_path_stack'])
            );
            $defaultPathStack = $serviceLocator->get('ViewTemplatePathStack');
            $pathResolver->setDefaultSuffix($defaultPathStack->getDefaultSuffix());
            $themeResolver->attach($pathResolver);
        }*/
        
        return $serviceLocator;
    }
}