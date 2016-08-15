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
use Zend\View\Model\ViewModel;
use Cms\Form\LoginForm;
use Cms\Form\LoginFilter;

class AuthenController extends AbstractActionController
{
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
    
    public function loginAction()
    {
        $this->layout('layout/index');
        $message = null;
        
        $form = new LoginForm();
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setInputFilter(new LoginFilter($this->getServiceLocator()));
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $authenService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authenService->getAdapter();
                $adapter->setIdentityValue($data['username']);
                $adapter->setCredentialValue($data['password']);
                $authenResult = $authenService->authenticate();
                if ($authenResult->isValid()) {
                    $identity = $authenResult->getIdentity();
                    $authenService->getStorage()->write($identity);
                    $time = 120960;
                    if ($data['rememberme']) {
                        $sessionManager = new \Zend\Session\SessionManager();
                        $sessionManager->rememberMe($time);
                    }
                }
                foreach ($authenResult->getMessages() as $message) {
                    $message .= $message.PHP_EOL;
                    break;
                }
            }
        }        
        
        //right bar
        $rightbar = new ViewModel(array('blockTitle' => null));
        $rightbar->setTemplate('layout/block');
        
        //get current theme
        $option = $this->getEntityManager()->getRepository('Cms\Entity\WpOptions')->findOneBy(array(
            'optionName' => 'template',
        ));
        if ($option) {
            $themename = $option->getOptionValue();
        } else {
            $themename = 'default';
        }
        
        //categories block
        $blockImage = new ViewModel(array('imageUrls' => array(
            $themename.'/img/crm_icon.png',
            $themename.'/img/cms_icon.png',
        )));
        $blockImage->setTemplate('layout/block/image');
        $rightbar->addChild($blockImage, 'content', true);        
        
        $this->layout()->addChild($rightbar, 'rightbar');        
        
        return new ViewModel(array(
            'form' => $form,
            'message' => $message,
        ));
    }
    
    public function logoutAction()
    {
        $auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }
        $sessionManager = new \Zend\Session\SessionManager();
        $sessionManager->forgetMe();
        return $this->redirect()->toRoute('home/Authen', array('controller' => 'authen', 'action' => 'login'));
    }
}