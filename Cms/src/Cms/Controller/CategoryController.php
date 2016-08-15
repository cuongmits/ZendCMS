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



class CategoryController extends AbstractActionController {
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
     * View and Add new Category
     */
    public function indexAction() {
        $message = $this->getEvent()->getRouteMatch()->getParam('message');
        $form = new CategoryForm();
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
                $term = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array(
                    'slug' => $slug, //tag & category cannot have the same slug
                ));
                if ($slug==''||$term) { //Yes, Term with entered slug already exists, then user need to enter new slug
                    $message = MESSAGE_INVALID;
                } else { //else, we can create Term with current slug and TermTaxonomy
                    $newTerm = new WpTerms();
                    $newTerm->setName($request->getPost('name', ''));
                    $newTerm->setSlug($slug);
                    $newTerm->setTermGroup(0); //
                    $this->getEntityManager()->persist($newTerm);

                    $newTermTaxonomy = new WpTermTaxonomy();
                    $newTermTaxonomy->setTaxonomy('category');
                    $newTermTaxonomy->setDescription($request->getPost('description', ''));
                    $newTermTaxonomy->setParent((int)$request->getPost('parent', 0));
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
                'taxonomy' => 'category',
                ));
        foreach ($termTaxonomies as $key => $termTaxonomyItem) {
            $terms[] = $termTaxonomyItem->getTerm();
        }
        $categories = $this->commonHelper()->termArrayLevel($terms);
        
        $ar = array();
        $ar[0] = 'None';
        foreach ($categories as $categoryItem) {
            $ar[$categoryItem->getTermId()] = $categoryItem->getName(); //$category['t_name'];
        }
        $form->get('parent')->setValueOptions($ar);
        
        return new ViewModel(array(
            'form' => $form,
            'categories' => $categories,
            'message' => $message,
        ));
    }
    
    /*
     * Delete Category and redirect to index
     */
    public function deleteAction() {
        
        $message = MESSAGE_ITEM_DOESNT_EXIST;
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Category');

        $term = $this->getEntityManager()->find('Cms\Entity\WpTerms', $id);
        if (!$term) return $this->redirect()->toRoute('home/Category');
        
        //foreach to find correct TermTaxonomy
        foreach ($term->getTermTaxonomies() as $termTaxonomy) {
            //if Term with that Id is exactly category then remove it
            if ($termTaxonomy->getTaxonomy()=='category') {
                /* set category's posts into uncategoried category */
                //Uncategorized is usual category so dont need to pay attention about this
                
                /* set current category's child categories up to 1 level */
                $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                    'taxonomy' => 'category',
                    'parent' => $id,
                ));
                foreach ($termTaxonomies as $termTaxonomyItem) {
                    $termTaxonomyItem->setParent($termTaxonomy->getParent());
                }

                /* remove current term */
                $this->em->remove($term);
                
                $this->em->flush();                
                
                $message = MESSAGE_SUCCESS;
                
                break; //exit from foreach
            }
        }

        return $this->redirect()->toRoute('home/Category', array('message' => $message));
    }
    
    /*
     * Edit Category
     */
    public function editAction() {
        
        $message = $this->getEvent()->getRouteMatch()->getParam('message');
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Category');
        
        $term = $this->getEntityManager()->find('Cms\Entity\WpTerms', $id);
        if (!$term) return $this->redirect()->toRoute('home/Category');
        
        $form = new CategoryForm();
        $form->setBindOnValidate(false);
        $form->setAttribute('method', 'POST');
        $form->get('submit')->setAttribute('value', 'Save');
        $form->get('name')->setAttribute('value', $term->getName());
        $form->get('slug')->setAttribute('value', $term->getSlug());
        $termTaxonomy;
        foreach ($term->getTermTaxonomies() as $termTaxonomyItem) {
            if ($termTaxonomyItem->getTaxonomy()=='category') {
                $termTaxonomy = $termTaxonomyItem;
                $form->get('description')->setAttribute('value', $termTaxonomy->getDescription());
                break;
            }
        }
         
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            /*$form->get('name')->setAttribute('value', $request->getPost('name', ''));
            $form->get('slug')->setAttribute('value', $request->getPost('slug', ''));
            $form->get('parent')->setAttribute('value', (int)$request->getPost('parent', 0));
            $form->get('description')->setAttribute('value', (int)$request->getPost('description', 0));
             * 
             */
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
                if ($slug==''||($otherTerm && $otherTerm->getTermId()!=$term->getTermId())) { //Yes, Term with entered slug already exists, then user need to enter new slug
                    $message = MESSAGE_INVALID;
                } else { //else, we can create Term with current slug and TermTaxonomy
                    $term->setName($request->getPost('name', ''));
                    $term->setSlug($slug);
                    $term->setTermGroup(0); //

                    $termTaxonomy->setDescription($request->getPost('description', ''));
                    $termTaxonomy->setParent((int)$request->getPost('parent', 0));

                    $this->getEntityManager()->flush();
                    $message = MESSAGE_SUCCESS;
                }
            } else {
                $message = MESSAGE_INVALID;
            }
        }
        
        /** Set avaiable parent list **/
        //get term children ids list, parent category cannot be one of them
        $childrenIds = $this->commonHelper()->getTermChildrenId($term, 'category');
        
        //get all categories
        $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'taxonomy' => 'category',
                ));
        foreach ($termTaxonomies as $key => $termTaxonomyItem) {
            $terms[] = $termTaxonomyItem->getTerm();
        }
        
        //sort received categories
        $fullCategories = $this->commonHelper()->termArrayLevel($terms); //get and sort all categories
        //$parentCategory = array();
        
        $ar = array();
        $ar[0] = 'None';
        foreach ($fullCategories as $key => $categoryItem) {
            //delete category from categories list because it cannot be parent of current category
            if (!in_array($categoryItem->getTermId(), $childrenIds)) {
                $ar[$categoryItem->getTermId()] = $categoryItem->getName();
            }
        }
        $form->get('parent')->setValueOptions($ar);
        $form->get('parent')->setValue($termTaxonomy->getParent());
        
        return new ViewModel(array(
            'id' => $term->getTermId(),
            'form' => $form,
            'categories' => $fullCategories,
            'message' => $message,
        ));
    }
}