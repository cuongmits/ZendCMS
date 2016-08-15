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

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;

class FileUploadForm extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        //$file->setLabel('Avatar Image Upload');//no need label
        $file->setAttribute('id', 'image-file');
        $this->add($file);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $fileInput = new InputFilter\FileInput('image-file');
        $fileInput->setRequired(true);
        //Using this always return invalid to form
        /*$fileInput->getValidatorChain()
                ->attachByName('filesize', array('max' => MAX_UPLOAD_FILE_SIZE))
                ->attachByName('filemimetype', array('mimeType' => VALID_UPLOAD_FILE_TYPES));*/
        /*$fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target' => './module/Media/uploads',
                'randomize' => true,
            )
        );*/
        $inputFilter->add($fileInput);
        $this->setInputFilter($inputFilter);
    }
}