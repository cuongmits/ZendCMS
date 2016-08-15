<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cms\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('CommentForm');

        $this->setAttribute('method', 'POST');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'type' => 'text',
            'name' => 'userLogin',
            'options' => array(
                'label' => 'Login',
            ),
            'attributes'    => array(
                'readonly' => true,
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Password',
            'name' => 'userPass',
            'attributes' => array(
                'placeholder' => 'Enter to change password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Password',
            'name' => 'userConfirmPass',
            'attributes' => array(
                'placeholder' => 'Enter to confirm password',
            ),
            'options' => array(
                'label' => 'Confirm Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'userNicename',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Nicename',
            ),
        ));
        
        $this->add(array(
            'name' => 'userEmail',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));
        
        $this->add(array(
            'name' => 'userUrl',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'URL',
            ),
        ));

        $this->add(array(
            'name' => 'userRegistered',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Registered date',
            ),
        ));
        
        $this->add(array(
            'name' => 'userActivationKey',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Activation key',
            ),
        ));
        
        $this->add(array(
            'name' => 'userStatus',
            'attributes' => array(
                'type'  => 'text',
                'value' => null,
            ),
            'options' => array(
                'label' => 'Status',
            ),
        ));
        
        $this->add(array(
            'name' => 'displayName',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Display name',
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Submit',
            ),
        ));

    }
}
