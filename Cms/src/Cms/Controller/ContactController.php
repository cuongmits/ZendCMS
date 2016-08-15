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
    Zend\Mail,
    Cms\Form\ContactForm;

class ContactController extends AbstractActionController {
    
    public function indexAction() {
        $this->layout('layout/contact');
        $message = null;
        $form = new ContactForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                //everything is ok, now send email to system & user
                $mail = new Mail\Message();
                $mail->setBody($request->getPost('emailContent'));
                $mail->setFrom($request->getPost('email'), $request->getPost('fullname'));
                $mail->addTo('cuongmits@gmail.com', 'KeoN');
                $mail->addCc($request->getPost('email'));
                $mail->setSubject('Email from ZF2 CMS Module project');

                $transport = new Mail\Transport\Sendmail();
                $transport->send($mail);
                                
                $message = MESSAGE_SUCCESS;
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
            'message' => $message,
        ));
    }
}