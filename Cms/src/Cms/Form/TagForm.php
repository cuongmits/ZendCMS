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

class TagForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('TagForm');

        $this->setAttribute('method', 'POST');
        
        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Name',
                'description' => 'The name is how it appears on your site.',
            ),
        ));

        $this->add(array(
            'name' => 'slug',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Slug',
                'description' => 'The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.',
            ),
        ));
        
        $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Description',
                'description' => 'The description is not prominent by default; however, some themes may show it.',
            ),
        ));
                
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Add New Tag',
            ),
        ));

    }
}
