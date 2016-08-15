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

class PostForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('PostForm');

        $this->setAttribute('method', 'POST');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
        
        /*
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'post_author',
            'options' => array(
                'label' => 'Author',
                'empty_option' => 'Please choose',
            ),
        ));*/
        
        $this->add(array(
            'name' => 'postAuthor',
            /* //chi danh cho Entity!!
            'filters' => array(
                array(
                    'name' => 'Int', //we need only Integer for post_author
                ),
            ),*/
            'attributes' => array(
                'type'  => 'text',
                'value' => '1', //default author is Admin, need to improve
            ),
            'options' => array(
                'label' => 'Author',
            ),
        ));

        $this->add(array(
            'name' => 'postDate',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Post Date',
            ),
            /*
            'attributes' => array(
                'type'  => 'date',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Date',
            ),*/
        ));
        
        $this->add(array(
            'name' => 'postDateGmt',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Post Date GMT',
            ),
            /*
            'attributes' => array(
                'type'  => 'date',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Date',
            ),*/
        ));
        
        $this->add(array(
            'name' => 'postContent',
            'attributes' => array(
                'type'  => 'textarea',
                'value' => null,
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Content',
            ),
        ));
        
        $this->add(array(
            'name' => 'postTitle',
            'attributes' => array(
                'type'  => 'text',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        $this->add(array(
            'name' => 'postExcerpt',
            'attributes' => array(
                'type'  => 'textarea',
                'value' => null,
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post Excerpt',
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Select',
            'name' => 'postStatus',
            'options' => array(
                'label' => 'Status',
                'options' => array(
                    'publish' => 'Published',
                    'pending' => 'Pending',
                    'draft' => 'Draft',
                    'trash' => 'Trash',
                    'inherit' => 'Inherit',
                ),
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Select',
            'name' => 'commentStatus',
            'options' => array(
                'label' => 'Comment Status',
                //'empty_option' => 'Please choose', //ko can thiet
                'options' => array(
                    'open' => 'Open',
                    'close' => 'Close',
                ),
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Select',
            'name' => 'pingStatus',
            'options' => array(
                'label' => 'Ping Status',
                //'empty_option' => 'Please choose',
                /* How to set Default value
                'value' => 'open',
                'default' => 'open',
                'selected' => 'open',
                'default_option' => 'open',
                'selected_option' => 'open',*/
                'value_options' => array(
                    'open' => 'Open',
                    'close' => 'Close',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'postPassword',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
                'placeholder' => 'not required',
                'value' => null,
            ),
            'options' => array(
                'label' => 'Post Password',
            ),
        ));
        
        $this->add(array(
            'name' => 'postName',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
                'placeholder' => 'Generate from Post Title',
            ),
            'options' => array(
                'label' => 'Post Name',
            ),
        ));
        
        $this->add(array(
            'name' => 'toPing',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'To Ping',
            ),
        ));
        
        $this->add(array(
            'name' => 'pinged',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Pinged',
            ),
        ));
        
        $this->add(array(
            'name' => 'postModified',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post Modified',
            ),
        ));
        
        $this->add(array(
            'name' => 'postModifiedGmt',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post Modified GMT',
            ),
        ));
        
        $this->add(array(
            'name' => 'postContentFiltered',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Post Content Filtered',
            ),
        ));
        
        $this->add(array(
            'name' => 'postParent',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
                'value' => '0',
            ),
            'options' => array(
                'label' => 'Post Parent',
            ),
        ));
        
        $this->add(array(
            'name' => 'guid',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
                'placeholder' => 'bare full url, appear after saving',
            ),
            'options' => array(
                'label' => 'Guid',
            ),
        ));
        
        $this->add(array(
            'name' => 'menuOrder',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
                'value' => 0, //default value is no menu, need to improve!
            ),
            'options' => array(
                'label' => 'Menu Order',
            ),
        ));
        
        $this->add(array(
            'name' => 'postMimeType',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post Mime Type',
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'postType',
            'required' => 'required',
            'options' => array(
                'label' => 'Post type',
                'options' => array(
                    'post' => 'post',
                    'page' => 'page',
                    'attachment' => 'attachment',
                    'revision' => 'revision',
                ),
            ),
            /*
            'name' => 'postType',
            'attributes' => array(
                'type'  => 'text',
                'value' => 'post',
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Post Type',
            ),*/
        ));
        
        $this->add(array(
            'name' => 'commentCount',
            'attributes' => array(
                'type'  => 'text',
                //'required' => 'required',
            ),
            'options' => array(
                'label' => 'Comment Count',
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
