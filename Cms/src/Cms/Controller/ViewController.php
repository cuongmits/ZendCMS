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

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel,

    //Doctrine using
    Doctrine\ORM\EntityManager,
    Cms\Entity\WpUsers,
    Cms\Entity\WpUsermeta,
    Cms\Form\UserForm,
        
    //For Sorting
    Doctrine\Common\Collections\Criteria,

    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    Zend\Paginator\Paginator;
use Zend\Session\Container;
use Cms\Controller\PasswordHash;

class ViewController extends AbstractActionController {
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
        $this->layout('layout/index');
        
        //main content
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
                        'postTitle' => 'Getting Started',
                        'postType' => 'page',));

        $view =  new ViewModel(array(
            'post' => $post,
        ));
        
        //right bar
        $rightbar = new ViewModel(array('blockTitle' => null));
        $rightbar->setTemplate('layout/block');
        
        //login block
        $blockLogin = new ViewModel();
        $blockLogin->setTemplate('layout/block/login');
        $rightbar->addChild($blockLogin, 'content');
        
        //categories block
        $tt = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
            'taxonomy' => 'category'));
        $blockCategories = new ViewModel(array(
            'blockItemTitle' => "Categories",
            'termTaxonomies' => $tt,
        ));
        $blockCategories->setTemplate('layout/block/categories');
        $rightbar->addChild($blockCategories, 'content', true);
        
        //last posts block
        $posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'post',
            'postStatus' => 'publish',), null, 5);
        $blockLastPosts = new ViewModel(array(
            'blockItemTitle' => 'Last posts',
            'posts' => $posts,
        ));
        $blockLastPosts->setTemplate('layout/block/lastPost');
        $rightbar->addChild($blockLastPosts, 'content', true);        
        
        $this->layout()->addChild($rightbar, 'rightbar');

        return $view;
    }
    
    public function viewAction() {
        $this->layout('layout/index');
        $slug = $this->getEvent()->getRouteMatch()->getParam('slug');
        if (!$slug) return $this->redirect()->toRoute('home');
        
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
            'postName' => $slug,
            'postType' => array('post', 'page'),
            'postStatus' => 'publish',));
        
        if (!$post) { //if there is not post with that slug then need to check term's slug (category/tag)
            $term = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array(
                'slug' => $slug));
            if (!$term) return $this->redirect()->toRoute('home'); //not correct slug at all
            $termTaxonomies = $term->getTermTaxonomies();
            //get all posts which have that term as category or tag
            $posts = array();
            foreach ($termTaxonomies as $termTaxonomy) {
                if ($termTaxonomy->getTaxonomy()=='category'||$termTaxonomy->getTaxonomy()=='post_tag') {
                    $posts = array_merge($posts, $termTaxonomy->getPosts()->toArray());
                }
            }
        } else {
            $termTaxonomies = $post->getTermTaxonomies();
            $categoryTerms = array();
            $tagTerms = array();
            foreach ($termTaxonomies as $termTaxonomy) {
                if ($termTaxonomy->getTaxonomy()=='category') {
                    $categoryTerms[] = $termTaxonomy->getTerm();
                } elseif ($termTaxonomy->getTaxonomy()=='post_tag') {
                    $tagTerms[] = $termTaxonomy->getTerm();
                }
            }
        }
                
        //right bar
        $rightbar = new ViewModel(array('blockTitle' => null));
        $rightbar->setTemplate('layout/block');
        
        //last posts block
        $ps = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'post',
            'postStatus' => 'publish',), null, 5);
        $blockLastPosts = new ViewModel(array(
            'blockItemTitle' => 'Last posts',
            'posts' => $ps,
        ));
        $blockLastPosts->setTemplate('layout/block/lastPost');
        $rightbar->addChild($blockLastPosts, 'content');        
        
        //categories block
        $tt = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
            'taxonomy' => 'category'));
        $blockCategories = new ViewModel(array(
            'blockItemTitle' => "Categories",
            'termTaxonomies' => $tt,
        ));
        $blockCategories->setTemplate('layout/block/categories');
        $rightbar->addChild($blockCategories, 'content', true);        
        
        $this->layout()->addChild($rightbar, 'rightbar');
        
        if ($post) {
            return new ViewModel(array(
                'post' => $post,
                'categoryTerms' => $categoryTerms,
                'tagTerms' => $tagTerms,
            )); 
        } else {
            return new ViewModel(array(
                'term' => $term,
                'posts' => $posts,
            ));
        }
    }
}