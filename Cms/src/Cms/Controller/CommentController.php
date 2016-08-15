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
    Cms\Entity\WpComments,
    Cms\Entity\WpCommentmeta,
    Cms\Form\CommentForm,
        
    //For Sorting
    Doctrine\Common\Collections\Criteria,

    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    Zend\Paginator\Paginator;
use Zend\Session\Container;

class CommentController extends AbstractActionController {
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
    
    public function allAction() {
        
        
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('commentApproved', '0'))
                ->orWhere(Criteria::expr()->eq('commentApproved', '1'))
                ->orderBy(array('commentDate' => \Doctrine\Common\Collections\Criteria::DESC));
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpComments'), $criteria);
        $paginator = new Paginator($adapter);

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $pending_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '0',
        ));
        $approved_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '1',
        ));
        $spam_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'spam',
        ));
        $trash_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'trash',
        ));
        return new ViewModel(array(
            'comments' => $paginator, // $posts,
            'comments_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'pending_comments_quantity' => count($pending_comments),
            'approved_comments_quantity' => count($approved_comments),
            'spam_comments_quantity' => count($spam_comments),
            'trash_comments_quantity' => count($trash_comments),
        ));
    }
    
    public function approvedAction() {
        
        
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('commentApproved', '1'))
                ->orderBy(array('comment_date' => \Doctrine\Common\Collections\Criteria::DESC));
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpComments'), $criteria);
        $paginator = new Paginator($adapter);

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $pending_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '0',
        ));
        $all_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => array('0', '1'),
        ));
        $spam_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'spam',
        ));
        $trash_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'trash',
        ));
        return new ViewModel(array(
            'comments' => $paginator, // $posts,
            'approved_comments_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'pending_comments_quantity' => count($pending_comments),
            'all_comments_quantity' => count($all_comments),
            'spam_comments_quantity' => count($spam_comments),
            'trash_comments_quantity' => count($trash_comments),
        ));
    }
    
    public function pendingAction() {
        
        
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('commentApproved', '0'))
                ->orderBy(array('commentDate' => \Doctrine\Common\Collections\Criteria::DESC));
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpComments'), $criteria);
        $paginator = new Paginator($adapter);

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $all_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => array('0', '1'),
        ));
        $approved_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '1',
        ));
        $spam_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'spam',
        ));
        $trash_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'trash',
        ));
        return new ViewModel(array(
            'comments' => $paginator, // $posts,
            'pending_comments_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'all_comments_quantity' => count($all_comments),
            'approved_comments_quantity' => count($approved_comments),
            'spam_comments_quantity' => count($spam_comments),
            'trash_comments_quantity' => count($trash_comments),
        ));
    }
    
    public function spamAction() {
        
        
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('commentApproved', 'spam'))
                ->orderBy(array('comment_date' => \Doctrine\Common\Collections\Criteria::DESC));
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpComments'), $criteria);
        $paginator = new Paginator($adapter);

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $all_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => array('0', '1'),
        ));
        $approved_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '1',
        ));
        $pending_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '0',
        ));
        $trash_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'trash',
        ));
        return new ViewModel(array(
            'comments' => $paginator, // $posts,
            'spam_comments_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'all_comments_quantity' => count($all_comments),
            'approved_comments_quantity' => count($approved_comments),
            'pending_comments_quantity' => count($pending_comments),
            'trash_comments_quantity' => count($trash_comments),
        ));
    }
    
    public function trashAction() {
        
        
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('commentApproved', 'trash'))
                ->orderBy(array('comment_date' => \Doctrine\Common\Collections\Criteria::DESC));
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpComments'), $criteria);
        $paginator = new Paginator($adapter);

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $pending_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '0',
        ));
        $approved_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => '1',
        ));
        $spam_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => 'spam',
        ));
        $all_comments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
            'commentApproved' => array('0', '1'),
        ));
        return new ViewModel(array(
            'comments' => $paginator, // $posts,
            'trash_comments_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'pending_comments_quantity' => count($pending_comments),
            'approved_comments_quantity' => count($approved_comments),
            'spam_comments_quantity' => count($spam_comments),
            'all_comments_quantity' => count($all_comments),
        ));
    }
    
    /*
     * Mark comment as Approved
     */
    public function approveAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->redirect()->toRoute('home/Comment');
        }
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if ($comment) {
            $comment->setCommentApproved('1');
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Comment', array(
            'controller' => 'Comment',
            'action' => 'all',
        ));
    }
    
    /*
     * Or mark comment as Pending (restore/not spam)
     */
    public function unapproveAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->redirect()->toRoute('home/Comment');
        }
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if ($comment) {
            $comment->setCommentApproved('0');
            $this->getEntityManager()->persist($comment);
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Comment', array(
            'controller' => 'Comment',
            'action' => 'all',
        ));
    }
    
    /*
     * Set commentApproved to 'spam', nothing changed with comment_parent
     * 
     * WP_CommentMeta: add 1 new record:
     *      meta_key = _wp_trash_meta_status, meta_value = current commentApproved
     * When restoring/(deleting) this new record will be used to restore commentApproved and then deleted
     * 
     * In View: son of Spam comment will be ver first comment (without parent)
     */
    public function doSpamAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->redirect()->toRoute('home/Comment');
        }
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if ($comment) {
            //add 1 recordsinto wp_commentmeta:
            $commentMeta = new WpCommentmeta();
            $commentMeta->setCommentId($comment->getCommentId());
            $commentMeta->setMetaKey('_wp_trash_meta_status');
            $commentMeta->setMetaValue($comment->getCommentApproved());
            $this->getEntityManager()->persist($commentMeta);
            
            //mark as spam
            $comment->setCommentApproved('spam');
            $this->getEntityManager()->persist($comment);
            
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Comment', array(
            'controller' => 'Comment',
            'action' => 'all',
        ));
    }
    
    /*
     * Restore commentApproved from wp_commentmeta table
     * and delete record from wp_commentmeta
     */
    public function unSpamAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->redirect()->toRoute('home/Comment');
        }
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if ($comment) {
            $commentMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpCommentmeta')->findOneBy(array(
                'comment_id' => $id,
                'meta_key' => '_wp_trash_meta_status', //no need
            ));
            
            //restore comment
            if ($commentMeta) {
                $comment->setCommentApproved($commentMeta->getMetaValue());
            }
            $this->getEntityManager()->persist($comment);            
            
            //delete commentMeta:
            $this->getEntityManager()->remove($commentMeta);
            
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Comment', array(
            'controller' => 'Comment',
            'action' => 'all',
        ));
    }
    
    /*
     * WP_Comments: analogy as doSpamAction, just set commentApproved to 'trash'
     * nothing changed with comment_parent
     * 
     * WP_CommentMeta: add 2 new records
     *      meta_key = _wp_trash_meta_status, meta_value = current commentApproved
     *      meta_key = _wp_trash_meta_time, meta_value = (time)1397121798           //QUESTION: time for what??
     * When restoring/(deleting) these new records will be used to restore commentApproved and then deleted
     * 
     * In View: son of Spam comment will be ver first comment (without parent)
     */
    public function doTrashAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->redirect()->toRoute('home/Comment');
        }
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if ($comment) {
            //add 2 records into wp_commentmeta:
            $commentMeta1 = new WpCommentmeta();
            $commentMeta1->setCommentId($comment->getCommentId());
            $commentMeta1->setMetaKey('_wp_trash_meta_status');
            $commentMeta1->setMetaValue($comment->getCommentApproved());
            $this->getEntityManager()->persist($commentMeta1);
            
            $commentMeta2 = new WpCommentmeta();
            $commentMeta2->setCommentId($comment->getCommentId());
            $commentMeta2->setMetaKey('_wp_trash_meta_time');
            $commentMeta2->setMetaValue(time());
            $this->getEntityManager()->persist($commentMeta2);
            
            //mark comment as trash
            $comment->setCommentApproved('trash');
            $this->getEntityManager()->persist($comment);
            
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Comment', array(
            'controller' => 'Comment',
            'action' => 'all',
        ));
    }
    
    /*
     * Restore commentApproved from wp_commentmeta table
     * and delete 2 records from wp_commentmeta
     */
    public function unTrashAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) {
            return $this->redirect()->toRoute('home/Comment');
        }
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if ($comment) {
            $commentMeta1 = $this->getEntityManager()->getRepository('Cms\Entity\WpCommentmeta')->findOneBy(array(
                'comment_id' => $id,
                'meta_key' => '_wp_trash_meta_status', //no need
            ));
            $commentMeta2 = $this->getEntityManager()->getRepository('Cms\Entity\WpCommentmeta')->findOneBy(array(
                'comment_id' => $id,
                'meta_key' => '_wp_trash_meta_time', //no need
            ));
            
            //restore comment
            if ($commentMeta1) {
                $comment->setCommentApproved($commentMeta1->getMetaValue());
            }
            $this->getEntityManager()->persist($comment);            
            
            //delete commentMeta:
            $this->getEntityManager()->remove($commentMeta1);
            $this->getEntityManager()->remove($commentMeta2);
            
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Comment', array(
            'controller' => 'Comment',
            'action' => 'all',
        ));
    }
    
    /*
     * Delete Spam/Trash comment
     * WP_Comment: delete comment, and set son->comment_parent to parent->comment_ID
     * WP_CommentMeta: delete all records with comment_id = comment_ID
     */
    public function deleteAction() {
        
        //$id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        //or
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) return $this->redirect ()->toRoute('home/Comment');
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                $id = $request->getPost('id', null);
                $comment = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findOneBy(array(
                    'comment_ID' => $id,
                ));
                if ($comment) {
                    $this->getEntityManager()->remove($comment);
                    
                    //delete record(s) from WP_CommentMeta
                    $commentMeta1 = $this->getEntityManager()->getRepository('Cms\Entity\WpCommentmeta')->findOneBy(array(
                        'comment_id' => $id,
                        'meta_key' => '_wp_trash_meta_status', //no need
                    ));
                    if ($commentMeta1) $this->getEntityManager()->remove($commentMeta1);
                    $commentMeta2 = $this->getEntityManager()->getRepository('Cms\Entity\WpCommentmeta')->findOneBy(array(
                        'comment_id' => $id,
                        'meta_key' => '_wp_trash_meta_time', //no need
                    ));
                    if ($commentMeta2) $this->getEntityManager()->remove($commentMeta2); //$commentMeta2 = null in case of Spam Comment
                    
                    //change comment_parent of comment's son
                    $childComments = $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findBy(array(
                        'comment_parent' => $id,
                    ));
                    foreach ($childComments as $childComment) {
                        $childComment->setCommentParent($comment->getCommentParent());
                        $this->getEntityManager()->persist($childComment);
                    }
                    
                    $this->getEntityManager()->flush();
                }
            }
            return $this->redirect()->toRoute('home/Comment', array('action' => 'trash'));
        }
        return array(
            'id' => $id,
            'comment' => $this->getEntityManager()->getRepository('Cms\Entity\WpComments')->findOneBy(array('comment_ID' => $id)),
        );
    }
    
    /*
     * Reply to comment (create comment child)
     * Redirect to Comment Edit page of that created comment
     */
    public function replyAction() {
        
        $message = '';
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) return $this->redirect()->toRoute('home/Comment', array('action' => 'reply'));
        $parent = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        if (!$parent) return $this->redirect()->toRoute('home/Comment', array('action' => 'reply'));
        
        $request = $this->getRequest();
        
        $form = new CommentForm();
        $form->get('submit')->setAttribute('value', 'Add reply');
        $form->get('comment_parent')->setAttribute('value', $id);
        $form->get('comment_post_ID')->setAttribute('value', $parent->getCommentPostId());
        //$form->get('user_id')->setAttribute('value', 1); //need to improve: 1 must be user's(admin/author) ID
        $form->get('comment_author_IP')->setAttribute('value', $request->getServer('REMOTE_ADDR'));
        $form->get('comment_agent')->setAttribute('value', $request->getServer('HTTP_USER_AGENT'));
        $form->get('comment_date')->setAttribute('value', date('Y-m-d H:i:s', time()));
        $form->get('comment_date_gmt')->setAttribute('value', date('Y-m-d H:i:s', time()-intval(date('Z', time()))));
        $form->setAttribute('method', 'POST');
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $comment = new WpComments();
                $comment->populate($form->getData());
                $this->getEntityManager()->persist($comment);
                $this->getEntityManager()->flush();
                $message = MESSAGE_SUCCESS;
                
                //use Session to send message to action edit
                $session = new Container('base');
                $session->message = $message;       
                
                return $this->redirect()->toRoute('home/Comment', array(
                    'action' => 'edit', 
                    'id' => $comment->getCommentId(),
                ));
            } else {
                $message = MESSAGE_INVALID;
            }
        }
        return new ViewModel(array(
            'form' => $form,
            'message' => $message,
            'id' => $id,
        ));
    }
    
    public function editAction() {
        
        
        $session = new Container('base');
        $message = ($session->message)?$session->message:'';
        
        $id = (int)$this->params()->fromRoute('id', null);

        if (!$id) return $this->redirect ()->toRoute('home/Comment');
        
        $request = $this->getRequest();
        $comment = $this->getEntityManager()->find('Cms\Entity\WpComments', $id);
        
        if (!$comment) {
            return array(
                'message' => MESSAGE_ITEM_DOESNT_EXIST,
            );
        }
        
        $form = new CommentForm();
        $form->setBindOnValidate(false);
        $form->bind($comment);
        $form->get('submit')->setAttribute('value', 'Edit');
        //$form->get('comment_post_ID')->setAttribute('value', $id);
        $form->setAttribute('method', 'POST');
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getEntityManager()->flush();
                $message = MESSAGE_SUCCESS;
            } else {
                $message = MESSAGE_INVALID;
            }
        }
        return array(
            'id' => $id,
            'form' => $form,
            'message' => $message,
        );
    }    
}