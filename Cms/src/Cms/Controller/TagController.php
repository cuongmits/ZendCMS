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
    Cms\Form\PostForm,
    Cms\Entity\WpPosts,
    Cms\Entity\WpTermRelationships,
        
    //For Sorting
    Doctrine\Common\Collections\Criteria,

    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    Zend\Paginator\Paginator,
    Cms\Entity\WpTerms,
    Cms\Entity\WpTermTaxonomy,

    Cms\Form\CategoryForm,
    Cms\Form\TagForm;
use Zend\Session\Container;



class TagController extends AbstractActionController {
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
    /*
     * Note: tag dont have parent/children tags
     */
    public function indexAction() {
        
        $message = $this->getEvent()->getRouteMatch()->getParam('message');
        $form = new TagForm();
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $slug = $this->commonHelper()->slug($request->getPost('slug', ''));
                $term = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array(
                    'slug' => $slug, //tag & category cannot have the same slug
                ));
                if ($term) {
                    $message = MESSAGE_ITEM_ALREADY_EXISTS;
                } else {
                    $newTerm = new WpTerms();
                    $newTerm->setName($request->getPost('name', ''));
                    $newTerm->setSlug($request->getPost('slug', ''));
                    $newTerm->setTermGroup(0);
                    $this->getEntityManager()->persist($newTerm);

                    $newTermTaxonomy = new WpTermTaxonomy();
                    $newTermTaxonomy->setTaxonomy('post_tag');
                    $newTermTaxonomy->setDescription($request->getPost('description', ''));
                    $newTermTaxonomy->setParent(0);
                    $newTermTaxonomy->setCount(0);
                    $this->getEntityManager()->persist($newTermTaxonomy);
                    
                    $newTerm->addTermTaxonomy($newTermTaxonomy);

                    $this->getEntityManager()->flush();
                    $message = MESSAGE_SUCCESS;
                }
            }        
        }
        
        //Set avaiable parent list
        $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'taxonomy' => 'post_tag',
                ));
        $terms = array();
        foreach ($termTaxonomies as $key => $termTaxonomyItem) {
            $terms[] = $termTaxonomyItem->getTerm();
        }
        
        return new ViewModel(array(
            'form' => $form,
            'tags' => $terms,
            'message' => $message,
        ));
    }
    
    /*
     * Delete Tag and redirect to index
     */
    public function deleteAction() {
        
        $message = MESSAGE_ITEM_DOESNT_EXIST;
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Tag');

        $term = $this->getEntityManager()->find('Cms\Entity\WpTerms', $id);
        if (!$term) return $this->redirect()->toRoute('home/Tag');
        
        foreach ($term->getTermTaxonomies() as $termTaxonomy) {
            if ($termTaxonomy->getTaxonomy()=='post_tag') {
                $this->em->remove($term);
                
                /* set category's posts into uncategoried category */
                //Uncategorized is usual category so dont need to pay attention about this
                
                $this->em->flush();                
                
                $message = MESSAGE_SUCCESS;
            }
        }

        return $this->redirect()->toRoute('home/Tag', array('message' => $message));
    }
    
    /*
     * Edit Tag
     */
    public function editAction() {
        
        $message = $this->getEvent()->getRouteMatch()->getParam('message');
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Tag');
        
        $term = $this->getEntityManager()->find('Cms\Entity\WpTerms', $id);
        if (!$term) return $this->redirect()->toRoute('home/Tag');
        
        $form = new TagForm();
        $form->setBindOnValidate(false);
        $form->setAttribute('method', 'POST');
        $form->get('submit')->setAttribute('value', 'Save');
        $form->get('name')->setAttribute('value', $term->getName());
        $form->get('slug')->setAttribute('value', $term->getSlug());
         
        $termTaxonomy;
        foreach ($term->getTermTaxonomies() as $termTaxonomyItem) {
            if ($termTaxonomyItem->getTaxonomy()=='post_tag') {
                $termTaxonomy = $termTaxonomyItem;
                $form->get('description')->setAttribute('value', $termTaxonomy->getDescription());
                break;
            }
        }
        
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) { //Everything is OK, then need to add new category:
                $slug = $this->commonHelper()->slug($request->getPost('slug', ''));
                /*
                 * NOTE: Slug is unique only, that means if there is a tag with slug A, 
                 *       then user cannot create new category with the same slug A
                 */
                //Check if Term with entered slug already exists
                $otherTerm = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array(
                    'slug' => $slug, //tag & category cannot have the same slug
                ));
                if ($otherTerm && $otherTerm->getTermId()!=$term->getTermId()) { //Yes, Term with entered slug already exists, then user need to enter new slug
                    //var_dump($otherTerm);
                    //var_dump($term);
                    $message = MESSAGE_INVALID;
                } else { //else, we can create Term with current slug and TermTaxonomy
                    $term->setName($request->getPost('name', ''));
                    $term->setSlug($slug);
                    $term->setTermGroup(0); //

                    $termTaxonomy->setDescription($request->getPost('description', ''));

                    $this->getEntityManager()->flush();
                    $message = MESSAGE_SUCCESS;
                }
            } else {
                $message = MESSAGE_INVALID;
            }
        }
        
        //Set avaiable parent list
        $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'taxonomy' => 'category',
                ));
        $terms = array();
        foreach ($termTaxonomies as $key => $termTaxonomyItem) {
            $terms[] = $termTaxonomyItem->getTerm();
        }

        //Set avaiable parent list
        $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'taxonomy' => 'post_tag',
                ));
        $terms = array();
        foreach ($termTaxonomies as $key => $termTaxonomyItem) {
            $terms[] = $termTaxonomyItem->getTerm();
        }
        
        return new ViewModel(array(
            'id' => $term->getTermId(),
            'form' => $form,
            'tags' => $terms,
            'message' => $message,
        ));
    }
}