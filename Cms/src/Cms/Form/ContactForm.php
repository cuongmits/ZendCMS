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

class ContactForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('ContactForm');

        $this->setAttribute('method', 'POST');
        
        $this->add(array(
            'name' => 'fullname',
            'attributes' => array(
                'type'  => 'text',
                'placeholder' => 'Enter Fullname',
            ),
            'options' => array(
                'label' => 'Your Fullname',
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Enter Email',
            ),
            'options' => array(
                'label' => 'Email Address',
            ),
        ));
        
        $this->add(array(
            'name' => 'emailContent',
            'attributes' => array(
                'type' => 'textarea',
                'placeholder' => 'Enter content',
                'rows' => 8,
            ),
            'options' => array(
                'label' => 'Content',
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
