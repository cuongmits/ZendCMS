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

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel,
    Doctrine\ORM\EntityManager,
    Cms\Entity\WpPosts,
    Cms\Entity\WpPostmeta,
        
    //For Sorting
    Doctrine\Common\Collections\Criteria,

    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    Zend\Paginator\Paginator;
use Cms\Entity\ProfileEntity,
    Cms\Form\FileUploadForm;
 
use Zend\Validator\File\Size;
use Zend\ProgressBar;
use Zend\View\Model\JsonModel;
use Zend\Json\Json; //cho up load response type

class MediaController extends AbstractActionController {
    /**
     * @var Doctrine\ORM\EntityManager
     */
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
    
    public function indexAction() {
        
        $paginator = $this->commonHelper()->getPaginatorPosts(array(
            'postType' => array('attachment'),
            'orderBy' => array('postDate' => \Doctrine\Common\Collections\Criteria::DESC),
        ));
        $pageIndex = 1;
        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id');
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);

        return new ViewModel(array(
            'medias' => $paginator, // $posts,
            'medias_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
        ));
    }

    public function addAction() {
        //$this->layout('layout/media');
        
        $form = new FileUploadForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $File = $this->params()->fromFiles('image-file'); //
            
            $foldername = date('Ymd');
            $uploadUrl = UPLOAD_FOLDER . $foldername; //20140321

            //Create new folder if need
            if (!is_dir($uploadUrl)) {
                mkdir($uploadUrl, 0777, true);
            }

            //Add index to filename if filename already exists
            $filenameIndex = 1;
            $newFilename = $File['name'];
            while (file_exists($uploadUrl.'/'.$newFilename)) {
                $newFilename = pathinfo($File['name'], PATHINFO_FILENAME).'_'.$filenameIndex.'.'.pathinfo($File['name'], PATHINFO_EXTENSION);
                $filenameIndex++;
            }
            $File['name'] = $newFilename;
            $filename = pathinfo($File['name'], PATHINFO_FILENAME);
            $extension = pathinfo($File['name'], PATHINFO_EXTENSION);
            $fullPath = $uploadUrl.'/'.$File['name'];
            
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) { //doesn't work!!!
                //Filter in Form can be deleted & cannot delete this because we need $adapter to receive file
                $size = new Size(array('max' => MAX_UPLOAD_FILE_SIZE));
                $extensionvalidator = new \Zend\Validator\File\Extension(array('extension'=>array(
                    'jpg',
                    'jpeg',
                    'png',
                    'gif',
                    'mp3',      //Opera&oldFF don't support
                    'wav',      //IE doesn't support
                    'mp4',      //Opera&oldFF don't support
                    'webm',     //IE&Safari don't support
                    'ogg',      //IE&Safari don't support
                    //'wmv',    //don't support
                ))); //need to add more here

                $adapter = new \Zend\File\Transfer\Adapter\Http();
                $adapter->setValidators(array($size, $extensionvalidator), $File['name']); //not use ProfileEntity to validate!
                
                if (!$adapter->isValid()) { //if validation is not passed
                    $errorMessages = $adapter->getMessages();
                    $error = '';
                    foreach ($errorMessages as $key => $message) {
                        $error .= $message;
                    }
                    return $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                            'res' => 0, 
                            'message' => ": ".$error,
                        )));
                    //return new \Zend\View\Model\JsonModel(array('res' => 0, 'message' => ": ".$error)); //!!! need to check more
                } else {                    
                    $adapter->setDestination($uploadUrl);
                    
                    if (move_uploaded_file($File['tmp_name'], $fullPath)) { //if move tmp_file to upload folder filename successfully
                        
                        //SAVE TO DATABASE
                        //Save to WP_POST
                        $post = new WpPosts();

                        //current user
                        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
                        
                        $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $identity->getId())); //!!! need to improve here
                        $post->setPostDate(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time())));
                        $post->setPostDateGmt(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time())));
                        $post->setPostContent('');
                        $post->setPostTitle($filename);
                        $post->setPostExcerpt('');
                        $post->setPostStatus('inherit');
                        $post->setCommentStatus('open'); //need to improve
                        $post->setPingStatus('open');
                        $post->setPostPassword('');
                        $post->setPostName($this->commonHelper()->slug($filename));
                        $post->setToPing('');
                        $post->setPinged('');
                        //$post->setPostModified(date('Y-m-d H:i:s', time()));
                        //$post->setPostModifiedGmt(date('Y-m-d H:i:s', time()-intval(date('Z', time()))));
                        $post->setPostModified(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time to current time
                        $post->setPostModifiedGmt(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time GMT to current time
                        $post->setPostContentFiltered('');
                        $post->setPostParent(null);
                        $post->setGuid(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http'.'://'.$_SERVER['HTTP_HOST'].'/uploads/'.$foldername.'/'.$File['name']);
                        $post->setMenuOrder(0);
                        $post->setPostMimeType(($extension=='jpg'?'image/jpeg':
                                ($extension=='jpeg'?'image/jpeg':
                                ($extension=='png'?'image/png':
                                ($extension=='gif'?'image/gif':
                                ($extension=='mp3'?'audio/mpeg':
                                ($extension=='mp4'?'video/mp4':
                                'undefined')))))));
                        $post->setPostType('attachment');
                        $post->setCommentCount(0);
                        $this->getEntityManager()->persist($post);
                        
                        //WP_POSTMETA
                        //..set _wp_attached_file:
                        $postMeta = new WpPostmeta();
                        $postMeta->setMetaKey('_wp_attached_file');
                        $postMeta->setMetaValue(date('Ymd').'/'.$File['name']);

                        $postMeta->setPost($post);
                        
                        $this->getEntityManager()->persist($postMeta);                        
                        
                        //..then set _wp_attachment_metadata:
                        //NEED TO IMPROVE MORE THEN
                        //create thumbnail/medium images with defined size
                        //..
                        if ($extension=='png'||$extension=='jpg'||$extension=='gif'||$extension=='jpeg') {
                            list($width, $height) = getimagesize($fullPath);
                            $metaData = array(
                                'width' => $width,
                                'height' => $height,
                                'file' => $foldername.'/'.$File['name'],
                                'sizes' => array(),
                                'image_meta' => array(
                                    'aperture' => 0,
                                    'credit' => '',
                                    'camera' => '',
                                    'caption' => '',
                                    'created_timestamp' => 0,
                                    'copyright' => '',
                                    'focal_length' => 0,
                                    'iso' => 0,
                                    'shutter_speed' => 0,
                                    'title' => '',
                                ),
                            );
                        } elseif ($extension=='mp3') {
                            $metaData = array();
                            /*
                            $metaData = array(
                                'dataformat' => 'mp3',
                                'channels' => 2,
                                'sample_rate' => 44100,
                                'bitrate' => 192000,
                                'channelmode' => 'stereo',
                                'bitrate_mode' => 'cbr',
                                'lossless' => 0, //bit
                                'encoder_options' => 'CBR192',
                                'compression_ratio' => 0.1360544217687074952660708504481590352952480316162109375,
                                'fileformat' => 'mp3',
                                'filesize' => 999,
                                'mime_type' => 'audio/mpeg',
                                //...
                            );*/
                        } elseif ($extension=='mp4') {
                            $metaData = array();
                            //...
                        } elseif ($extension=='mov') {
                            $metaData = array();
                            //...
                        }
                        $postMeta = new WpPostmeta();
                        $postMeta->setMetaKey('_wp_attachment_metadata');
                        $postMeta->setMetaValue(serialize($metaData));
                        
                        $postMeta->setPost($post);
                        
                        $this->getEntityManager()->persist($postMeta);
                        $this->getEntityManager()->flush();                        
                        
                        //Everything is OK, send successful message
                        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                            'res' => 1, 
                            'message' => $File['name'].": uploaded successfully!",
                        )));
                    } else { //if cannot move tmp_file into upload folder
                        return $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                            'res' => 0, 
                            'message' => $File['name'] . ": Please check filesize or filetype.",
                        )));
                    }
                    
                    /* //DON'T DELETE: need to check this:
                    if ($adapter->receive($File['name'])) {
                        //var_dump($File);
                        return new \Zend\View\Model\JsonModel(array(
                            'res' => 1, 
                            'message' => $File['name'].": uploaded successfully!",
                            'url' => $uploadUrl,
                            'filename' => $File['name'],
                            'index' => $filenameIndex,
                        ));
                    } else {
                        return new \Zend\View\Model\JsonModel(array(
                            'res' => 0, 
                            'message' => $File['name'] . ": Please check filesize or filetype.",
                            'url' => $uploadUrl,
                            'filename' => $File['name'],
                            'index' => $filenameIndex,
                            'file' => $File,
                        ));
                    }*/
                }
            } else {
                //return new \Zend\View\Model\JsonModel(array('res' => 0, 'message' => ''.$File['name']. ": Form is not valid. Plz check filesize or filetype."));
                return $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                            'res' => 0, 
                            'message' => ''.$File['name']. ": Form is not valid. Plz check filesize or filetype.",
                        )));
            }
        } 
    }
    
    public function editAction() {
        
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Media');
        $message = $this->getEvent()->getRouteMatch()->getParam('message');
        
        $post = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        if (is_null($post)) {
            return array(
                'message' => MESSAGE_ITEM_DOESNT_EXIST,
            );
        }
        
        $request = $this->getRequest();
        
        $fullPath = $post->getGuid();
        $filename = basename($fullPath);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $description = $post->getPostContent();
        $preview = '';        
        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            $preview = "<a alt='$description' target='_blank' href='$fullPath' class='thumbnail'><img src='$fullPath'></a>";
        } elseif ($extension == 'mp3') {
            $preview = "<audio class='width100percents' controls><source src='$fullPath'>Your browser does not support the audio element.</audio>";
        } elseif ($extension == 'mp4' || $extension == 'wmv') {
            $preview = "<video width='100%' height='auto' controls><source src='$fullPath' type='video/mp4'>Your browser does not support the video tag.</video>";
        }
        
        $form = new \Cms\Form\PostForm();
        $form->setBindOnValidate(FALSE); //
        $form->bind($post);
                
        $form->get('postAuthor')->setAttribute('value', $post->getPostAuthor()->getId());
        $form->get('postParent')->setAttribute('value', ($post->getPostParent()?$post->getPostParent()->getId():null));
        $form->get('postDate')->setAttribute('value', $post->getPostDate()->format('Y-m-d H:i:s'));
        $form->get('postDateGmt')->setAttribute('value', $post->getPostDateGmt()->format('Y-m-d H:i:s'));
        $form->get('postModified')->setAttribute('value', $post->getPostModified()->format('Y-m-d H:i:s'));
        $form->get('postModifiedGmt')->setAttribute('value', $post->getPostModifiedGmt()->format('Y-m-d H:i:s'));
        $form->get('submit')->setAttribute('value', 'Edit');
        $form->setAttribute('method', 'POST');
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $form->bindValues();
                
                $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $request->getPost('postAuthor')));
                $post->setPostParent($this->getEntityManager()->find('Cms\Entity\WpPosts', $request->getPost('postParent')));
                
                //save postmeta _wp_attachment_image_alt
                $postMeta = $this->em->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
                    'post' => $post,
                    'metaKey' => '_wp_attachment_image_alt',
                ));
                if ($postMeta) { //if postmeta _wp_attachment_image_alt already exists then just update its value
                    $postMeta->setMetaValue($request->getPost('alternativeText'));
                } elseif ($request->getPost('alternativeText')!=''||$request->getPost('alternativeText')!=null) {
                    $postmeta = new WpPostmeta();
                    $postmeta->setPost($post);
                    $postmeta->setMetaKey('_wp_attachment_image_alt');
                    $postmeta->setMetaValue($request->getPost('alternativeText'));
                    $this->getEntityManager()->persist($postmeta);
                }
                
                //save postmeta _edit_last
                $postMeta = $this->em->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
                    'post' => $post,
                    'metaKey' => '_edit_last',
                ));
                
                //current user
                $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
                
                if ($postMeta) { //if postmeta _edit_last already exists then just update its value
                    $postMeta->setMetaValue($identity->getId());
                } else {
                    $postmeta = new WpPostmeta();
                    $postmeta->setPost($post);
                    $postmeta->setMetaKey('_edit_last');
                    $postmeta->setMetaValue($identity->getId());
                    $this->getEntityManager()->persist($postmeta);
                }
                
                $this->getEntityManager()->flush();
                $message = MESSAGE_SUCCESS;
            } else {
                $message = MESSAGE_INVALID;
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'message' => $message,
            'preview' => $preview,
        );
    }
    
    public function deleteAction() {
        
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Media');
        
        $media = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        if ($media) {
            //delete post
            $this->getEntityManager()->remove($media); 
            $this->getEntityManager()->flush();
        }
        
        return $this->redirect()->toRoute('home/Media');
    }
}
    