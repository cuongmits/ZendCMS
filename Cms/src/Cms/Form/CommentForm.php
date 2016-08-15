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

class CommentForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('CommentForm');

        $this->setAttribute('method', 'POST');
        $this->add(array(
            'name' => 'comment_ID',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_post_ID',
            'attributes' => array(
                'type'  => 'text',
                'value' => '1',
            ),
            'options' => array(
                'label' => 'Post ID',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_author',
            'attributes' => array(
                'type'  => 'text',
                'value' => 'cuongmits',
            ),
            'options' => array(
                'label' => 'Author',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_author_email',
            'attributes' => array(
                'type'  => 'text',
                'value' => 'cuongmits@gmail.com',
            ),
            'options' => array(
                'label' => 'Author email',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_author_url',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Author url',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_author_IP',
            'attributes' => array(
                'type'  => 'text',
                'value' => '1',
            ),
            'options' => array(
                'label' => 'Author IP',
            ),
        ));

        $this->add(array(
            'name' => 'comment_date',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Date',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_date_gmt',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Date GMT',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_content',
            'attributes' => array(
                'type'  => 'textarea',
                'value' => null,
            ),
            'options' => array(
                'label' => 'Content',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_karma',
            'attributes' => array(
                'type'  => 'text',
                //'placeholder' => 0,
                'value' => 0,
            ),
            'options' => array(
                'label' => 'Karma',
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Select',
            'name' => 'comment_approved',
            'options' => array(
                'label' => 'Status',
                'options' => array(
                    '1' => 'Approved',
                    '0' => 'Pending',
                    'spam' => 'Spam',
                    'trash' => 'Trash',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_agent',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Agent',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_type',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Type',
            ),
        ));
        
        $this->add(array(
            'name' => 'comment_parent',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Parent ID',
            ),
        ));
        
        $this->add(array(
            'name' => 'user_id',
            'attributes' => array(
                'type'  => 'text',
                //'placeholder' => 1,
                'value' => 1, //default is super admin, need to improve here
            ),
            'options' => array(
                'label' => 'User ID',
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
