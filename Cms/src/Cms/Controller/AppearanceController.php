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
    Cms\Entity\WpOptions;

class AppearanceController extends AbstractActionController {
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
    public function themeAction() {
        //if need to set new theme then do it
        $themename = $this->params()->fromRoute('themename');
        if ($themename && is_dir('./module/Cms/themes/'.$themename)) {
            $option = $this->getEntityManager()->getRepository('Cms\Entity\WpOptions')->findOneBy(array(
                'optionName' => 'template',
            ));
            if ($option) {
                $option->setOptionValue($themename);
            } else {
                $option = new WpOptions();
                $option->setOptionName('template');
                $option->setOptionValue($themename);
                $option->setAutoload('yes');
                $this->getEntityManager()->persist($option);
            }
            $this->getEntityManager()->flush();
            return $this->redirect()->toRoute('home/Appearance', array('action' => 'theme'));
        }
        
        //get current theme
        $templateMapResolver = $this->getServiceLocator()->get('ViewTemplateMapResolver');
        preg_match('~module.Cms.themes.(.*?)/view~',$templateMapResolver->get('layout/layout'), $r);
        $currentThemename = $r[1];
        
        /* get theme list */
        $themes = array();
        $fullThemenames = glob("./module/Cms/themes/*", GLOB_ONLYDIR);
        foreach ($fullThemenames as $fullThemename) {
            $themename = pathinfo($fullThemename, PATHINFO_BASENAME);
            $themes[$themename] = include ($fullThemename.'/info.php');
            $themes[$themename]['url'] = $fullThemename;
        }

        return array(
            'themes' => $themes,
            'currentTheme' => $currentThemename,
        );
    }
}