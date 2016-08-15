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
use Zend\View\Model\ViewModel,
    //Doctrine using
    Doctrine\ORM\EntityManager,
    Cms\Entity\WpPosts,
    Cms\Entity\PostMetaEntity,
    //For Sorting
    Doctrine\Common\Collections\Criteria,
    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    Zend\Paginator\Paginator;
use Cms\Form\PostForm;

class PageController extends AbstractActionController {
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
    
    public function pageAction() {
        
        $allPages = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('publish', 'draft', 'pending', 'trash'),
            'postType' => 'page',
        ), array( //order by
            'postDate' => 'DESC'
        ));
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($this->commonHelper()->pageArrayLevel($allPages));
        $paginator = new Paginator($arrayAdapter);

        $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $publish_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'page',
        ));
        $draft_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'draft',
            'postType' => 'page',
        ));
        $trash_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'trash',
            'postType' => 'page',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'posts_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'publish_posts_quantity' => count($publish_posts),
            'draft_posts_quantity' => count($draft_posts),
            'trash_posts_quantity' => count($trash_posts),
        ));
    }
    
    public function publishAction() {
        
        $allPages = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('publish'),
            'postType' => 'page',
        ), array( //order by
            'postDate' => 'DESC'
        ));
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($this->commonHelper()->pageArrayLevel($allPages));
        $paginator = new Paginator($arrayAdapter);
        
        $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        $trash_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'trash',
            'postType' => 'page',
        ));
        $all_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            //'postStatus' => array('publish', 'draft'),
            'postType' => 'page',
        ));
        $draft_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'draft',
            'postType' => 'page',
        ));
        
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'all_posts_quantity' => count($all_posts), //$paginator->getItemCount(),
            'publish_posts_quantity' => $paginator->getTotalItemCount(),
            'draft_posts_quantity' => count($draft_posts),
            'trash_posts_quantity' => count($trash_posts),
        ));
    }
    
    public function trashAction() {
        
        $allPages = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('trash'),
            'postType' => 'page',
        ), array( //order by
            'postDate' => 'DESC'
        ));
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($this->commonHelper()->pageArrayLevel($allPages));
        $paginator = new Paginator($arrayAdapter);
        
        $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        $publish_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'page',
        ));
        $all_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            //'postStatus' => array('publish', 'draft'),
            'postType' => 'page',
        ));
        $draft_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'draft',
            'postType' => 'page',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'all_posts_quantity' => count($all_posts), //$paginator->getItemCount(),
            'publish_posts_quantity' => count($publish_posts),
            'draft_posts_quantity' => count($draft_posts),
            'trash_posts_quantity' => $paginator->getTotalItemCount(),
        ));
    }
    
    public function draftAction() {
        
        $allPages = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('draft'),
            'postType' => 'page',
        ), array( //order by
            'postDate' => 'DESC'
        ));
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($this->commonHelper()->pageArrayLevel($allPages));
        $paginator = new Paginator($arrayAdapter);
        
        $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        $publish_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'page',
        ));
        $all_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            //'postStatus' => array('publish', 'draft'),
            'postType' => 'page',
        ));
        $trash_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'trash',
            'postType' => 'page',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'all_posts_quantity' => count($all_posts), //$paginator->getItemCount(),
            'publish_posts_quantity' => count($publish_posts),
            'draft_posts_quantity' => $paginator->getTotalItemCount(),
            'trash_posts_quantity' => count($trash_posts),
        ));
    }
        
    public function addAction() {
        
        $message = null;

        /* FORM */
        $form = new PostForm();
        $form->get('submit')->setAttribute('value', 'Add');
        
        //Set default value so form cannot be invalid
        $form->get('postType')->setAttribute('value', 'page');
        $form->get('commentStatus')->setAttribute('value', 'open');
        $form->get('pingStatus')->setAttribute('value', 'open');

        $request = $this->getRequest(); //HttpRequest()
        if ($request->isPost()) {
             $form->setData($request->getPost());
            if ($form->isValid()) {
                //current user
                $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
                
                //create page
                $post = new WpPosts();
                $post->populate($form->getData());
                $post->setPostDate(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time to current time
                $post->setPostDateGmt(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time GMT to current time
                $post->setPostModified(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time to current time
                $post->setPostModifiedGmt(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time GMT to current time
                $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $identity->getId())); //need to improve here
                $post->setPostParent($this->getEntityManager()->find('Cms\Entity\WpPosts', (int)$request->getPost('postParent'))); //super post have post parent = null
                $post->setPostName($post->getPostTitle().'-2'); //-2
                $this->getEntityManager()->persist($post);
                $this->getEntityManager()->flush();
                $post->setGuid(SITE_URL.'?page_id='.$post->getId());
                
                //create revision of page
                $revisionPost = clone $post;
                $revisionPost->setPostStatus('inherit');
                $revisionPost->setPostName($post->getId().'-revision-v1');
                $revisionPost->setPostParent($post);
                $revisionPost->setGuid(SITE_URL.$post->getId().'-revision-v1/');
                $revisionPost->setPostType('revision');
                $this->getEntityManager()->persist($revisionPost);
                
                /* Create Post Meta */
                
                $editLastMeta = new \Cms\Entity\WpPostmeta();
                $editLastMeta->setPost($post);
                $editLastMeta->setMetaKey('_edit_last'); //
                $editLastMeta->setMetaValue($identity->getId()); //last/current User Id who saved
                $this->em->persist($editLastMeta);
                
                $editLockMeta = new \Cms\Entity\WpPostmeta();
                $editLockMeta->setPost($post);
                $editLockMeta->setMetaKey('_edit_lock');
                $editLockMeta->setMetaValue(strtotime($post->getPostModified()->format('Y-m-d H:i:s')).':'.$identity->getId()); //last/current User Id who edited/editting
                $this->em->persist($editLockMeta);
                
                $templateMeta = new \Cms\Entity\WpPostmeta();
                $templateMeta->setPost($post);
                $templateMeta->setMetaKey('_wp_page_template');
                $templateMeta->setMetaValue(PAGE_TEMPLATE); //need to improve
                $this->em->persist($templateMeta);
                
                $this->getEntityManager()->flush(); 
                
                $message = MESSAGE_SUCCESS;
                
                $form = new PostForm();
                $form->get('postType')->setAttribute('value', 'page');
                $form->get('commentStatus')->setAttribute('value', 'open');
                $form->get('pingStatus')->setAttribute('value', 'open');
            } else {
                $message = $form->getMessages();//MESSAGE_INVALID;
            }            
        }

        $allPages = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postType' => 'page',
        ));
        
        $allPages = $this->commonHelper()->pageArrayLevel($allPages);
        
        return new ViewModel(array(
            'form' => $form,
            'message' => $message,
            'parents' => $allPages,
        ));
    }
    
    public function editAction() {
        
        $message = '';
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Post');
        
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
                        'id' => $id,
                        'postType' => 'page'));
        if (is_null($post)) {
            return array(
                'message' => MESSAGE_ITEM_DOESNT_EXIST,
            );
        }
        
        $request = $this->getRequest();
        
        /**** CHECK IF OTHER PERSON IS EDITING POST THEN EXIT, ELSE EDIT _EDIT_LOCK POSTMETA 'N CONTINUE */
        //Create/edit Postmeta with meta_key = _edit_lock
        $postMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
            'post' => $post,
            'metaKey' => '_edit_lock',
        ));
        
        /* Check if post can be deleted or not */
        
        //current user
        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
        
        $editable = true; //post can be edited by default
        $lastModifiedTime = $post->getPostModified();
        $metaValues = explode(':', $postMeta->getMetaValue());
        if ($metaValues[1]!=$identity->getId()) { //if it's not user who was the last one edited the post then need to check the time
            $lastEditTime = date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", $metaValues[0]));
            if ($lastEditTime->diff($lastModifiedTime)->format('%R') == '-') { //if ($lastEditTime > $lastModifiedTime)
                $message = MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM;
                $editable = false; //post cannot be deleted
            }
        }        
        if (!$editable) return new ViewModel(array('message' => $message)); //EXIT
        
        //edit postmeta _edit_lock. Note: this meta always exist, it was created while creating post
        $postMeta->setMetaValue(time().':'.$identity->getId());
        /*****   end of double editing post ******************/
        
        

        $form = new PostForm();
        $form->setBindOnValidate(false);
        $form->bind($post);
        $form->get('postAuthor')->setAttribute('value', $post->getPostAuthor()->getId());
        $form->get('postDate')->setAttribute('value', $post->getPostDate()->format('Y-m-d H:i:s'));
        $form->get('postDateGmt')->setAttribute('value', $post->getPostDateGmt()->format('Y-m-d H:i:s'));
        $form->get('postModified')->setAttribute('value', $post->getPostModified()->format('Y-m-d H:i:s'));
        $form->get('postModifiedGmt')->setAttribute('value', $post->getPostModifiedGmt()->format('Y-m-d H:i:s'));
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->setAttribute('method', 'POST');
        if ($request->isPost()) { //
            $form->setData($request->getPost());
            if ($form->isValid()) { //if input is validate
                $form->bindValues();
                
                /* save the page */
                $post->setPostModified(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time to current time
                $post->setPostModifiedGmt(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time GMT to current time
                $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $request->getPost('postAuthor'))); //need to improve here
                $post->setPostParent($this->getEntityManager()->find('Cms\Entity\WpPosts', (int)$request->getPost('postParent'))); //super post have post parent = null
                
                /* create revision page */
                
                //get revision version
                $revisionPosts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
                        'postParent' => $post,
                        'postStatus' => 'inherit',
                        'postType' => 'revision'));
                $k = count($revisionPosts) + 1; //supose that no one delete revision handly (not through our system!)
                //create revision post
                $revisionPost = clone $post;
                $revisionPost->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $identity->getId())); //need to improve here
                $revisionPost->setPostDate($post->getPostModified()); //set modified time to current time
                $revisionPost->setPostDateGmt($post->getPostModifiedGmt()); //set modified time GMT to current time
                $revisionPost->setPostStatus('inherit');
                $revisionPost->setPostName($post->getId().'-revision-v'.$k.'/');
                $revisionPost->setPostParent($post);
                $revisionPost->setGuid(SITE_URL.$revisionPost->getPostName());
                $revisionPost->setPostType('revision');
                $this->em->persist($revisionPost);
                
                //Create/edit Postmeta with meta_key = _edit_last
                $postMeta = $this->em->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
                    'post' => $post,
                    'metaKey' => '_edit_last',
                ));
                if ($postMeta) {
                    $postMeta->setMetaValue($identity->getId());
                } else {
                    $postMeta = new \Cms\OriginalEntity\WpPostmeta();
                    $postMeta->setPost($post);
                    $postMeta->setMetaKey('_edit_last');
                    $postMeta->setMetaValue($identity->getId());
                    $this->em->persist($postMeta);
                } 
                
                $message = MESSAGE_SUCCESS;
                
                $form->get('postParent')->setAttribute('value', $post->getPostParent()); //this value will be string after saving, so we need to set another value for it
            } else {
                $message = MESSAGE_INVALID;
            }
        }
        
        $this->getEntityManager()->flush();
        
        /* set avaiable parent page list */
        //get page children ids list, parent page cannot be one of them
        $childrenIds = $this->commonHelper()->getPostChildrenId($post);
        
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->add('select', 'p')
                ->add('from', 'Cms\Entity\WpPosts p')
                ->add('where', $qb->expr()->andx(
                    $qb->expr()->eq('p.postType', ':page'),
                    $qb->expr()->notIn('p.id', $childrenIds)
                ))
                ->setParameter('page', 'page');
        $allPages = $qb->getQuery()->getResult();
        
        $allPages = $this->commonHelper()->pageArrayLevel($allPages);
        
        return array(
            'id' => $id,
            'form' => $form,
            'message' => $message,
            'post' => $post,
            'current_parent' => $post->getPostParent(),
            'parents' => $allPages,
        );
    }
    
    public function deleteAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Page');
        $post = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        if ($post) {
            $post->setPostStatus('trash');
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Page');
    } 
    
    public function unpublishAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Page');
        $post = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        if ($post) {
            $post->setPostStatus('draft');
            $this->getEntityManager()->persist($post); //co can ko?http://marco-pivetta.com/doctrine-orm-zf2-tutorial/#/28/4
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Page', array(
                'controller' => 'page',
                'action' => 'page',
        ));
    }
    
    //publish post 
    public function doPublishAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Page');
        $post = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        if ($post) {
            $post->setPostStatus('publish');
            $this->getEntityManager()->persist($post); //co can ko?http://marco-pivetta.com/doctrine-orm-zf2-tutorial/#/28/4
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Page', array(
                'controller' => 'page',
                'action' => 'page',
        ));
    }
    
    public function deletePermanentlyAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Page');
        
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
            'id' => $id,
            'postType' => 'page'));
        if (!$post) {
            return array(
                'message' => MESSAGE_ITEM_DOESNT_EXIST,
            );
        }
        
        /* Delete post, set its children up 1 leve */

        //set children up 1 level
        $childPages = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postType' => 'page',
            'postParent' => $post,
        ));
        foreach ($childPages as $childPageItem) {
            $childPageItem->setPostParent($post->getPostParent());
        }
        
        //delete page
        $this->getEntityManager()->remove($post); 

        $this->getEntityManager()->flush();
        
        return $this->redirect()->toRoute('home/Page', array(
            'controller' => 'page',
            'action' => 'trash',
            ));
    }
}
    