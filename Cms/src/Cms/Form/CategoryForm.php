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

class CategoryForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('CategoryForm');

        $this->setAttribute('method', 'POST');
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
                'label' => 'Name',
            ),
            'options' => array(
                'description' => 'The name is how it appears on your site.',
            ),
        ));

        $this->add(array(
            'name' => 'slug',
            'attributes' => array(
                'type' => 'text',
                'label' => 'Slug',
            ),
            'options' => array(                
                'description' => 'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',
            ),
        ));
        
        $this->add(array(
            'type'  => 'Zend\Form\Element\Select',
            'name' => 'parent',
            
            'required' => false,
            
            'options' => array(                
                'label' => 'Parent',
                //'empty_option' => 'None',
                'description' => 'Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.',
                
                'disable_inarray_validator' => true, // <-- disable
                /*
                'options' => array( //'value_options' => array(
                    'publish' => 'Published',
                    'pending' => 'Pending',
                    'draft' => 'Draft',
                    'trash' => 'Trash',
                ),*/
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
                'label' => 'Description',
            ),
            'options' => array(                
                'description' => 'The description is not prominent by default; however, some themes may show it.',
            ),
        ));
                
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add New Category',
            ),
        ));

    }
}
