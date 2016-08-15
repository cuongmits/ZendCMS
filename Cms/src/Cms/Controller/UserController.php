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

class UserController extends AbstractActionController {
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
        
        /* It's better to use DbSelect:
         * http://framework.zend.com/manual/2.3/en/modules/zend.paginator.usage.html
         * Instead of selecting every matching row of a given query, the DbSelect adapter retrieves 
         * only the smallest amount of data necessary for displaying the current page. Because of this, 
         * a second query is dynamically generated to determine the total number of matching rows.
         */
        /*
         * Get Role and Post quantity for each user from 3 table
         */
        /*
        $query = $this->getEntityManager()->createQuery("SELECT 
                u.id as ID, 
                u.userNicename as user_nicename, 
                u.displayName as display_name, 
                u.userEmail as user_email, 
                p.postType as post_type,
                um.metaValue as meta_value, 
                COUNT( p.postType ) AS quantity
            FROM Cms\Entity\WpUsers AS u
            LEFT JOIN Cms\Entity\WpPosts AS p WITH u = p.postAuthor
            LEFT JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY p.postType"); // (p.postType = 'post' OR p.postType is null) AND
        $res = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //HYDRATE_SCALAR: return combination of tables, HYDRATE_ARRAY: return only rows from 1 table
        */
        
        $res = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($res);
        $paginator = new Paginator($arrayAdapter);        

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        /*
         * Get user quantity for every user's type
         */
        $users = $this->getEntityManager()->createQuery("SELECT um.metaValue as meta_value, count(um.user) as quantity
            FROM Cms\Entity\WpUsers AS u
            JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY um.metaValue")->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //u.id
        $admins_quantity = 0;
        $editors_quantity = 0;
        $authors_quantity = 0;
        $contributors_quantity = 0;
        $subscribers_quantity = 0;
        foreach ($users as $key => $user) {
            if (strpos($user['meta_value'], 'administrator')!== false) $admins_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'editor')!== false) $editors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'author')!== false) $authors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'contributor')!== false) $contributors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'subscriber')!== false) $subscribers_quantity = (int)$user['quantity'];
        }

        return new ViewModel(array(
            'users' => $paginator, // $posts,
            'all_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'admins_quantity' => $admins_quantity,
            'editors_quantity' => $editors_quantity,
            'authors_quantity' => $authors_quantity,
            'contributors_quantity' => $contributors_quantity,
            'subscribers_quantity' => $subscribers_quantity,
        ));
    }
    
    public function administratorAction() {
        
        $users = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        $res = array();
        foreach ($users as $key => $userItem) {
            foreach ($userItem->getUsermetas() as $usermetaItem) {
                if ($usermetaItem->getMetaKey()=='wp_capabilities') {
                    if (strpos($usermetaItem->getMetaValue(), 'administrator')!== false) $res[] = $userItem;
                    break;
                }
            }
        }
        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($res);
        $paginator = new Paginator($arrayAdapter);        

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        /*
         * Get user quantity for every user's type
         */
        $users = $this->getEntityManager()->createQuery("SELECT um.metaValue as meta_value, count(um.user) as quantity
            FROM Cms\Entity\WpUsers AS u
            JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY um.metaValue")->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //u.id
        $admins_quantity = 0;
        $editors_quantity = 0;
        $authors_quantity = 0;
        $contributors_quantity = 0;
        $subscribers_quantity = 0;
        foreach ($users as $key => $user) {
            if (strpos($user['meta_value'], 'administrator')!== false) $admins_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'editor')!== false) $editors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'author')!== false) $authors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'contributor')!== false) $contributors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'subscriber')!== false) $subscribers_quantity = (int)$user['quantity'];
        }

        return new ViewModel(array(
            'users' => $paginator, // $posts,
            'all_quantity' => $admins_quantity + $editors_quantity + $authors_quantity + $contributors_quantity + $subscribers_quantity,
            'admins_quantity' => $admins_quantity,
            'editors_quantity' => $editors_quantity,
            'authors_quantity' => $authors_quantity,
            'contributors_quantity' => $contributors_quantity,
            'subscribers_quantity' => $subscribers_quantity,
        ));
    }
    
    public function editorAction() {
        
        $users = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        $res = array();
        foreach ($users as $key => $userItem) {
            foreach ($userItem->getUsermetas() as $usermetaItem) {
                if ($usermetaItem->getMetaKey()=='wp_capabilities') {
                    if (strpos($usermetaItem->getMetaValue(), 'editor')!== false) $res[] = $userItem;
                    break;
                }
            }
        }
        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($res);
        $paginator = new Paginator($arrayAdapter);        

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        /*
         * Get user quantity for every user's type
         */
        $users = $this->getEntityManager()->createQuery("SELECT um.metaValue as meta_value, count(um.user) as quantity
            FROM Cms\Entity\WpUsers AS u
            JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY um.metaValue")->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //u.id
        $admins_quantity = 0;
        $editors_quantity = 0;
        $authors_quantity = 0;
        $contributors_quantity = 0;
        $subscribers_quantity = 0;
        foreach ($users as $key => $user) {
            if (strpos($user['meta_value'], 'administrator')!== false) $admins_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'editor')!== false) $editors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'author')!== false) $authors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'contributor')!== false) $contributors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'subscriber')!== false) $subscribers_quantity = (int)$user['quantity'];
        }

        return new ViewModel(array(
            'users' => $paginator, // $posts,
            'all_quantity' => $admins_quantity + $editors_quantity + $authors_quantity + $contributors_quantity + $subscribers_quantity,
            'admins_quantity' => $admins_quantity,
            'editors_quantity' => $editors_quantity,
            'authors_quantity' => $authors_quantity,
            'contributors_quantity' => $contributors_quantity,
            'subscribers_quantity' => $subscribers_quantity,
        ));
    }
    
    public function authorAction() {
        
        $users = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        $res = array();
        foreach ($users as $key => $userItem) {
            foreach ($userItem->getUsermetas() as $usermetaItem) {
                if ($usermetaItem->getMetaKey()=='wp_capabilities') {
                    if (strpos($usermetaItem->getMetaValue(), 'author')!== false) $res[] = $userItem;
                    break;
                }
            }
        }
        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($res);
        $paginator = new Paginator($arrayAdapter);        

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        /*
         * Get user quantity for every user's type
         */
        $users = $this->getEntityManager()->createQuery("SELECT um.metaValue as meta_value, count(um.user) as quantity
            FROM Cms\Entity\WpUsers AS u
            JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY um.metaValue")->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //u.id
        $admins_quantity = 0;
        $editors_quantity = 0;
        $authors_quantity = 0;
        $contributors_quantity = 0;
        $subscribers_quantity = 0;
        foreach ($users as $key => $user) {
            if (strpos($user['meta_value'], 'administrator')!== false) $admins_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'editor')!== false) $editors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'author')!== false) $authors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'contributor')!== false) $contributors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'subscriber')!== false) $subscribers_quantity = (int)$user['quantity'];
        }

        return new ViewModel(array(
            'users' => $paginator, // $posts,
            'all_quantity' => $admins_quantity + $editors_quantity + $authors_quantity + $contributors_quantity + $subscribers_quantity,
            'admins_quantity' => $admins_quantity,
            'editors_quantity' => $editors_quantity,
            'authors_quantity' => $authors_quantity,
            'contributors_quantity' => $contributors_quantity,
            'subscribers_quantity' => $subscribers_quantity,
        ));
    }
    
    public function contributorAction() {
        
        $users = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        $res = array();
        foreach ($users as $key => $userItem) {
            foreach ($userItem->getUsermetas() as $usermetaItem) {
                if ($usermetaItem->getMetaKey()=='wp_capabilities') {
                    if (strpos($usermetaItem->getMetaValue(), 'contributor')!== false) $res[] = $userItem;
                    break;
                }
            }
        }
        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($res);
        $paginator = new Paginator($arrayAdapter);        

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        /*
         * Get user quantity for every user's type
         */
        $users = $this->getEntityManager()->createQuery("SELECT um.metaValue as meta_value, count(um.user) as quantity
            FROM Cms\Entity\WpUsers AS u
            JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY um.metaValue")->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //u.id
        $admins_quantity = 0;
        $editors_quantity = 0;
        $authors_quantity = 0;
        $contributors_quantity = 0;
        $subscribers_quantity = 0;
        foreach ($users as $key => $user) {
            if (strpos($user['meta_value'], 'administrator')!== false) $admins_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'editor')!== false) $editors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'author')!== false) $authors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'contributor')!== false) $contributors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'subscriber')!== false) $subscribers_quantity = (int)$user['quantity'];
        }

        return new ViewModel(array(
            'users' => $paginator, // $posts,
            'all_quantity' => $admins_quantity + $editors_quantity + $authors_quantity + $contributors_quantity + $subscribers_quantity,
            'admins_quantity' => $admins_quantity,
            'editors_quantity' => $editors_quantity,
            'authors_quantity' => $authors_quantity,
            'contributors_quantity' => $contributors_quantity,
            'subscribers_quantity' => $subscribers_quantity,
        ));
    }
    
    public function subscriberAction() {
        
        $users = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        $res = array();
        foreach ($users as $key => $userItem) {
            foreach ($userItem->getUsermetas() as $usermetaItem) {
                if ($usermetaItem->getMetaKey()=='wp_capabilities') {
                    if (strpos($usermetaItem->getMetaValue(), 'subscriber')!== false) $res[] = $userItem;
                    break;
                }
            }
        }
        
        $arrayAdapter = new \Zend\Paginator\Adapter\ArrayAdapter($res);
        $paginator = new Paginator($arrayAdapter);        

        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        /*
         * Get user quantity for every user's type
         */
        $users = $this->getEntityManager()->createQuery("SELECT um.metaValue as meta_value, count(um.user) as quantity
            FROM Cms\Entity\WpUsers AS u
            JOIN Cms\Entity\WpUsermeta as um WITH um.user = u
            WHERE (um.metaKey='wp_capabilities')
            GROUP BY um.metaValue")->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //u.id
        $admins_quantity = 0;
        $editors_quantity = 0;
        $authors_quantity = 0;
        $contributors_quantity = 0;
        $subscribers_quantity = 0;
        foreach ($users as $key => $user) {
            if (strpos($user['meta_value'], 'administrator')!== false) $admins_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'editor')!== false) $editors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'author')!== false) $authors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'contributor')!== false) $contributors_quantity = (int)$user['quantity'];
            elseif (strpos($user['meta_value'], 'subscriber')!== false) $subscribers_quantity = (int)$user['quantity'];
        }

        return new ViewModel(array(
            'users' => $paginator, // $posts,
            'all_quantity' => $admins_quantity + $editors_quantity + $authors_quantity + $contributors_quantity + $subscribers_quantity,
            'admins_quantity' => $admins_quantity,
            'editors_quantity' => $editors_quantity,
            'authors_quantity' => $authors_quantity,
            'contributors_quantity' => $contributors_quantity,
            'subscribers_quantity' => $subscribers_quantity,
        ));
    }
    
    /*
     * Registration process:
     * 1. User enter username/email
     * 2. System send confirmation email to user
     * 3. User click on link in email to set password and enter system
     */
    
    public function deleteAction() {
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) return $this->redirect()->toRoute('home/User');
        
        $user = $this->getEntityManager()->find('Cms\Entity\WpUsers', $id);
        if (!$user) return $this->redirect()->toRoute('home/User');
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {            
            $del = $request->getPost('delete_option', 'delete_all_post');
            if ($del == 'delete_all_posts') { //delete all posts of this user, other posts (page, attachment...) will have CURRENT_USER as postAuthor
                $posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
                    'postAuthor' => $id,
                ));                
                
                //current user
                $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
                
                foreach ($posts as $post) {
                    //set posts with postType != post/revision to CURRENT USER
                    if ($post->getPostType()!='post'||$post->getPostType()!='revision') {
                        $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $identity->getId()));
                    }
                }
            } elseif ($del = 'attribute_all_posts') { //attribute all posts to another user
                $target_user_id = $request->getPost('target_user_id', null);
                if (!$target_user_id) return $this->redirect()->toRoute('home/User');
                $posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
                    'postAuthor' => $id,
                ));
                foreach ($posts as $post) {
                    $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $target_user_id));
                }
            }
            
            //delete user in both case            
            $this->getEntityManager()->remove($user);
            $this->getEntityManager()->flush();
            
            return $this->redirect()->toRoute('home/User', array('action' => 'all'));
        }
        
        //get all user that can take place of current deleted user
        $allUsers = $this->getEntityManager()->getRepository('Cms\Entity\WpUsers')->findAll();
        foreach ($allUsers as $key => $userItem) {
            if ($userItem->getId() == $id) unset ($allUsers[$key]);
        }
        return array(
            'id' => $id,
            'user' => $this->getEntityManager()->find('Cms\Entity\WpUsers', $id),
            'allUsers' => $allUsers,
        );
    }
    
    /*
     * Edit User
     */    
    public function editAction() {
        
        $message = $this->getEvent()->getRouteMatch()->getParam('message', '');
        
        $id = (int)$this->params()->fromRoute('id', null);
        if (!$id) return $this->redirect()->toRoute('home/User');
        
        $request = $this->getRequest();
        $user = $this->getEntityManager()->find('Cms\Entity\WpUsers', $id);
        
        if (!$user) {
            return array(
                'message' => MESSAGE_ITEM_DOESNT_EXIST,
            );
        }
        
        $form = new UserForm();
        $form->setBindOnValidate(false);
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->get('userConfirmPass')->setAttribute('value', $user->getUserPass());
        $form->get('userRegistered')->setAttribute('value', $user->getUserRegistered()->format('Y-m-d H:i:s'));
        $form->setAttribute('method', 'POST');
        if ($request->isPost()) {
            $data = $request->getPost();
            $password = $data->get('userPass');
            $password2 = $data->get('userConfirmPass');
            if ($password==$password2) {
                $hasher = new PasswordHash(8, TRUE);
                $hash = $hasher->HashPassword(trim($password));
                //if new password is not entered then dont need to change password
                if ($password!='') $data->set('userPass', $hash);
                else $data->set('userPass', $user->getUserPass());
                $form->setInputFilter($user->getInputFilter());
                $form->setData($data);
                if ($form->isValid()) {
                    $form->bindValues();
                    $user->setUserRegistered(date_create_from_format('Y-m-d H:i:s', $request->getPost('userRegistered')));
                    
                    //create role
                    $usermetas = $user->getUsermetas();
                    foreach ($usermetas as $usermeta) {
                        if ($usermeta->getMetaKey()=='wp_capabilities') {
                            if ($request->getPost('userRole') == '1') {
                                $usermeta->setMetaValue('administrator');
                            } elseif ($request->getPost('userRole') == '2') {
                                $usermeta->setMetaValue('editor');
                            } elseif ($request->getPost('userRole') == '3') {
                                $usermeta->setMetaValue('author');
                            } elseif ($request->getPost('userRole') == '4') {
                                $usermeta->setMetaValue('contributor');
                            } else {
                                $usermeta->setMetaValue('editor');
                            }
                        }
                    }
                    
                    $this->getEntityManager()->flush();
                    
                    $message = MESSAGE_SUCCESS;
                } else {
                    $message = MESSAGE_INVALID;
                }
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
    
    /*
     * Edit User
     */    
    public function addAction() {
        
        $message = null;

        $form = new UserForm();
        $form->get('submit')->setAttribute('value', 'Add');
        $form->get('userLogin')->setAttribute('readonly', false);
        $form->get('userActivationKey')->setAttribute('readonly', true);
        $form->get('userRegistered')->setAttribute('readonly', true);
        $form->setAttribute('method', 'POST');

        $request = $this->getRequest(); //HttpRequest()
        if ($request->isPost()) {
            $data = $request->getPost();
            $password = $data->get('userPass');
            $password2 = $data->get('userConfirmPass');
            if ($password==$password2 && $password!='') {
                $hasher = new PasswordHash(8, TRUE);
                $hash = $hasher->HashPassword(trim($password));
                //if new password is not entered then dont need to change password
                $data->set('userPass', $hash);
                $form->setData($data);
                if ($form->isValid()) {
                    $user = new WpUsers();
                    $user->populate($form->getData());
                    $user->setUserRegistered(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time())));
                    $this->getEntityManager()->persist($user);
                    
                    $usermeta = new WpUsermeta();
                    $usermeta->setMetaKey('wp_capabilities');
                    if ($request->getPost('userRole')==1) $usermeta->setMetaValue('administrator');
                    elseif ($request->getPost('userRole')==2) $usermeta->setMetaValue('editor');
                    elseif ($request->getPost('userRole')==3) $usermeta->setMetaValue('author');
                    elseif ($request->getPost('userRole')==4) $usermeta->setMetaValue('contributor');
                    elseif ($request->getPost('userRole')==5) $usermeta->setMetaValue('subscriber');
                    $usermeta->setUser($user);
                    $this->getEntityManager()->persist($usermeta);
                    
                    $this->getEntityManager()->flush();
                    $message = MESSAGE_SUCCESS;
                    
                    //reset form
                    $form->get('userLogin')->setAttribute('value', '');
                    $form->get('userPass')->setAttribute('value', '');
                    $form->get('userConfirmPass')->setAttribute('value', '');
                    $form->get('displayName')->setAttribute('value', '');
                    $form->get('userNicename')->setAttribute('value', '');
                    $form->get('userEmail')->setAttribute('value', '');
                    $form->get('userStatus')->setAttribute('value', '');
                    $form->get('userActivationKey')->setAttribute('value', '');
                } else {
                    $message = MESSAGE_INVALID;
                }
            } else {
                $message = MESSAGE_INVALID;
            }         
        }
        
        return new ViewModel(array(
            'form' => $form,
            'message' => $message,
        ));
    }
}