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

class TermRelationshipForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('TermRelationshipForm');

        $this->setAttribute('method', 'POST');
        
        $this->add(array(
            'name' => 'objectId',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Author',
            ),
        ));

        $this->add(array(
            'name' => 'termTaxonomyId',
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
            'name' => 'termOrder',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Post Date GMT',
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
