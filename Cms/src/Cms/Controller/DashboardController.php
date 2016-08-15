<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Cms\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class DashboardController extends AbstractActionController {
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    
    public function indexAction() {
        //$session = $this->getSession();
        //$session->theme = 'default';
        //var_dump($session->theme);
        //$session = new \Zend\Session\Container();
        //var_dump($session->theme);
        //
        //var_dump($this->getServiceLocator()); //Zend\ServiceManager\ServiceManager
        //var_dump($this->getServiceLocator()->get('Router'));
        //var_dump($this->getServiceLocator()->get('Config')); //array()
        
        //var_dump($this->getServiceLocator()->get('Config'));
        //$sl = new \Zend\Di\ServiceLocator();
        //var_dump($sl->get('Config'));
        
        //$_SESSION['theme'] = 'default';
        //$_SESSION['theme'] = 'test';
        
        /*
        $themename = 'default';
        //$themename = 'test';
        
        $configFile = ROOT_PATH . '/module/Cms/themes/'.$themename.'/config.php';
        $config = include ($configFile);
        
        //View Templale Map Resolver
        $viewResolverMap = $this->serviceLocator->get('ViewTemplateMapResolver');
        $viewResolverMap->add($config['template_map']);
        
        //View Template Path Stack
        $viewResolverPathStack = $this->serviceLocator->get('ViewTemplatePathStack');
        $viewResolverPathStack->addPaths($config['template_path_stack']);
        
        //Template Map Resolver
        
        $mapResolver = new \Zend\View\Resolver\TemplateMapResolver($config['template_map']);
        $themeResolver = new \Zend\View\Resolver\AggregateResolver(); //Resolver tong hop
        $themeResolver->attach($mapResolver);

        $defaultPathStack = $this->serviceLocator->get('ViewTemplatePathStack');
        $pathResolver = new \Zend\View\Resolver\TemplatePathStack(array(
            'script_paths'=>$config['template_path_stack']
        ));        
        $pathResolver->setDefaultSuffix($defaultPathStack->getDefaultSuffix());
        $themeResolver->attach($pathResolver);
        
        //View Resolver
        $viewResolver = $this->serviceLocator->get('ViewResolver'); //Zend\View\Resolver\AggregateResolver
        $viewResolver->attach($themeResolver, 100);
        */
        
        //Last 20 posts
        $posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postType' => 'post',
            'postStatus' => 'publish',
        ), null, 20);
        
        //last 10 comments
        $comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(), null, 10);
        
        //last 10 registered users
        $users = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findBy(array(), null, 10);
        
        return array(
            'posts' => $posts,
            'comments' => $comments,
            'users' => $users,
        );
    }
}