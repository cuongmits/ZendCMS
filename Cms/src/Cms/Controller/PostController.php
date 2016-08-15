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

    //Doctrine using
    Doctrine\ORM\EntityManager,
    Cms\Form\PostForm,
    Cms\Entity\WpPosts,
    Cms\Entity\WpTermRelationships,
        
    //For Sorting
    Doctrine\Common\Collections\Criteria,

    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    //Doctrine\Common\Collections\ArrayCollection,
    //DoctrineModule\Paginator\Adapter\Collection as PaginatorAdapte,
    Zend\Paginator\Paginator,
    Cms\Entity\WpTerms,
    Cms\Entity\WpTermTaxonomy,

    Cms\Form\CategoryForm,
    Cms\Form\TagForm;
use Zend\Session\Container;



class PostController extends AbstractActionController {
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

    public function postAction() {
        
        
        $paginator = $this->commonHelper()->getPaginatorPosts(array(
            'postType' => array('post'),
            'postStatus' => array('publish', 'draft'),
            'orderBy' => array('postDate' => \Doctrine\Common\Collections\Criteria::DESC),            
        ));
        
        if ($this->params()->fromRoute('id')) $pageIndex = $this->params()->fromRoute('id', 1);
        $paginator->setCurrentPageNumber((int)$pageIndex)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $publish_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'post',
        ));
        $draft_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'draft',
            'postType' => 'post',
        ));
        $trash_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'trash',
            'postType' => 'post',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'posts_quantity' => $paginator->getTotalItemCount(), //$paginator->getItemCount(),
            'publish_posts_quantity' => count($publish_posts),
            'draft_posts_quantity' => count($draft_posts),
            'trash_posts_quantity' => count($trash_posts),
        ));
    }

    //View Published posts
    public function publishAction() {
        
        $paginator = $this->commonHelper()->getPaginatorPosts(array(
            'postStatus' => array('publish'),
            'postType' => array('post'),
            'orderBy' => array('postDate' => \Doctrine\Common\Collections\Criteria::DESC),
        ));
        $page = 1;
        if ($this->params()->fromRoute('id')) $page = $this->params()->fromRoute('id');
        $paginator->setCurrentPageNumber((int)$page)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);        
        $all_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('publish', 'draft'),
            'postType' => 'post',
        ));
        $draft_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'draft',
            'postType' => 'post',
        ));
        $trash_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'trash',
            'postType' => 'post',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'posts_quantity' => count($all_posts),
            'publish_posts_quantity' => $paginator->getTotalItemCount(),
            'draft_posts_quantity' => count($draft_posts),
            'trash_posts_quantity' => count($trash_posts),
        ));
    }

    //View Draft posts
    public function draftAction() {
        
        $paginator = $this->commonHelper()->getPaginatorPosts(array(
            'postStatus' => array('draft'),
            'postType' => array('post'),
            'orderBy' => array('postDate' => \Doctrine\Common\Collections\Criteria::DESC),
        ));
        $page = 1;
        if ($this->params()->fromRoute('id')) $page = $this->params()->fromRoute('id');
        $paginator->setCurrentPageNumber((int)$page)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $all_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('publish', 'draft'),
            'postType' => 'post',
        ));
        $publish_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'post',
        ));
        $trash_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'trash',
            'postType' => 'post',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'posts_quantity' => count($all_posts),
            'publish_posts_quantity' => count($publish_posts),
            'draft_posts_quantity' => $paginator->getTotalItemCount(),
            'trash_posts_quantity' => count($trash_posts),
        ));
    }

    //View Trash posts
    public function trashAction() {
        
        $paginator = $this->commonHelper()->getPaginatorPosts(array(
            'postStatus' => array('trash'),
            'postType' => array('post'),
            'orderBy' => array('postDate' => \Doctrine\Common\Collections\Criteria::DESC),
        ));
        $page = 1;
        if ($this->params()->fromRoute('id')) $page = $this->params()->fromRoute('id');
        $paginator->setCurrentPageNumber((int)$page)->setItemCountPerPage(POST_QUANTITY_IN_A_PAGE);
        
        $all_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => array('publish', 'draft'),
            'postType' => 'post',
        ));
        $publish_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'post',
        ));
        $draft_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'draft',
            'postType' => 'post',
        ));
        return new ViewModel(array(
            'posts' => $paginator, // $posts,
            'posts_quantity' => count($all_posts),
            'publish_posts_quantity' => count($publish_posts),
            'draft_posts_quantity' => count($draft_posts),
            'trash_posts_quantity' => $paginator->getTotalItemCount(),
        ));
    }
    
/* *****************************************************************************
 * *****************************************************************************
 * 
 * Hiện tại hệ thống chỉ có tính năng:
 * 
 * - LƯU CÁC REVISION CỦA 1 POST (id = ID):
 * Điều này được thực hiện bằng cách là mỗi khi tạo mới hoặc edit 1 post, ta lập 
 * tức tạo bản revision cho post này với các thông số tương đương, chỉ có các thông
 * số sau là khác:
 *  post_author = user, người mà đang edit post
 *  post_date, post_date_gmt, post_modified, post_modified = time()
 *  post_status = inherit
 *  post_name = ID-revision-[k], [k] là revision version của post
 *  post_parent = ID
 *  guid = SITE_URL.ID.'-revision-v'.[k]
 *  post_type = revision
 * 
 * Riêng với post cha (là bản current mà thông tin sẽ được nhập/xuất ra từ đó) thì 
 * các thông số sau luôn được giữ nguyên khi edit:
 *  post_author
 *  post_date, post_date_gmt, post_modified, post_modified_gmt
 *  post_parent
 *  
 * - KHÔNG CHO PHÉP 2 USER EDIT 1 POST CÙNG MỘT LÚC
 * Khi User mở editor để edit 1 post thì thời gian mở sẽ lưu vào PostMeta với metakey=_edit_lock
 * Khi User save thì thời gian save này sẽ lưu vào post
 * Vậy nếu thời gian lưu vào post này WpPosts.post_modified_gmt <= thời gian lưu vào PostMeta thì tức là user đang chỉnh sửa chưa xong
 * và nếu thời gian lưu vào post này WpPosts.post_modified_gmt > thời gian lưu vào PostMeta thì tức là user đã chỉnh sửa xong * 
 * 
 * *****************************************************************************
 * *****************************************************************************
 */
    
    /*
     * Add new post in to system. It will:
     * WP_POSTs:
     * 1. Create post (parent post) with id=ID post_type = post, post_parent = 0, post_status = publish/draft.., guid = SITE_URL?p=ID
     * 2. Inherit post with post_type = revision, post_parent = ID, post_name = ID-revision-v1
     * WP_POSTMETA:
     * 1. Create meta_key = _edit_last, meta_value = User's ID
     * 2. Create meta_key = _edit_lock, meta_value = time (last time user make change) : User's ID
     */
    public function addAction() {
        
        $message = null;
        $form = new PostForm();
        $form->get('submit')->setAttribute('value', 'Add');
        $form->get('postType')->setAttribute('value', 'post');
        $form->get('pingStatus')->setAttribute('value', 'open');
        $form->get('commentStatus')->setAttribute('value', 'open');

        //$categories_html = $this->commonHelper()->echoCategories();
        $request = $this->getRequest(); //HttpRequest()

        if ($request->isPost()) {
            //date_default_timezone_set("UTC");
            $request->getPost()->set('postType', 'post');
            $form->setData($request->getPost());
            //$form->get('postType')->setAttribute('value', 'post'); //User dont need to choose postType
            if ($form->isValid()) {
                /* Create post */
                $post = new WpPosts();
                $post->populate($form->getData());
                
                //current user
                $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
                
                $post->setPostType('post');
                $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $identity->getId())); //need to improve here
                $post->setPostParent(null);
                $this->em->persist($post);
                $this->em->flush();
                
                //define Guid
                $post->setGuid(SITE_URL.'?p='.$post->getId());
                //define postName: slug used in router to open post
                $i = 1;
                if ($post->getPostName()!='') {
                    $postName = $this->commonHelper()->slug($post->getPostName());
                } elseif ($post->getPostTitle()!='') {
                    $postName = $this->commonHelper()->slug($post->getPostTitle());
                } else {
                    $postName = $post->getId();
                }
                $originalPostName = $postName;
                $p = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
                        'postName' => $postName,
                        'postType' => 'post'));
                while ($p) {
                    $i++;
                    $postName = $originalPostName.'-'.$i;
                    $p = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
                        'postName' => $postName,
                        'postType' => 'post'));
                }                
                $post->setPostName($postName);
                
                /* Create Revision post */
                $revisionPost = clone $post;
                $revisionPost->setPostStatus('inherit');
                $revisionPost->setPostName($post->getId().'-revision-v1/');
                $revisionPost->setPostParent($post);
                $revisionPost->setGuid(SITE_URL.$revisionPost->getPostName());
                $revisionPost->setPostType('revision');
                $this->em->persist($revisionPost);
                
                //set category (we dont need to create category, but for tag we may need to create)
                $termIds = $request->getPost('postCategory', array()); //get Category checked list from Post
                foreach ($termIds as $termId) {
                    $term = $this->em->find('Cms\Entity\WpTerms', $termId);
                    foreach ($term->getTermTaxonomies() as $termTaxonomy) {
                       if ($termTaxonomy->getTaxonomy()=='category') { //be sure taxonomy is category
                           $post->addTermTaxonomy($termTaxonomy); //table term_relationships will be added new record automatically
                           $termTaxonomy->setCount($termTaxonomy->getCount()+1);
                       }
                    }
                }

                //set tags
                $tags = $request->getPost('tags_field', array());
                $tags = $this->commonHelper()->validateTags($tags); //delete empty, similar tags
                foreach ($tags as $tag) {
                    $needCreateTerm = true;
                    $needCreateTermTaxonomy = true; //this pair can be (true, true), (false, false) and (false, true) only
                    $slug = $this->commonHelper()->slug($tag); //get slug from tag (Note: 1 slug can have different name and can be different types (eg: tag & category)
                    $term = $this->em->getRepository('Cms\Entity\WpTerms')->findOneBy(array( //slug MUST be different
                        'slug' => $slug,
                    ));
                    if ($term) { //if exist term with that slug then need to check its termTaxonomies
                        $needCreateTerm = false;
                        $termTaxonomies = $term->getTermTaxonomies();
                        foreach ($termTaxonomies as $termTaxonomy) { //go through every termTaxonomy of this termTaxonomies
                            if ($termTaxonomy->getTaxonomy()=='post_tag') { //if this term is tag then 
                                $needCreateTermTaxonomy = false;
                                $termTaxonomy->setCount($termTaxonomy->getCount() + 1);
                                $post->addTermTaxonomy($termTaxonomy); //add this term to post
                                break;
                            }                            
                        }
                    }
                    //in cases: 1. need to create both term & termTaxonomy
                    //          2. need to create only termTaxonomy, term already exists
                    if ($needCreateTermTaxonomy) {
                        if ($needCreateTerm) { //case 1
                            $term = new WpTerms();
                            $term->setName($tag);
                            $term->setSlug($slug);
                            $term->setTermGroup(0); //??
                            $this->em->persist($term);
                        }
                        //case 1 + 2
                        $termTaxonomy = new WpTermTaxonomy();
                        $termTaxonomy->setTaxonomy('post_tag');
                        $termTaxonomy->setDescription('');
                        $termTaxonomy->setParent(0);
                        $termTaxonomy->setCount(1);
                        $this->em->persist($termTaxonomy);

                        $term->addTermTaxonomy($termTaxonomy);
                        $post->addTermTaxonomy($termTaxonomy);
                    }
                }
                
                /* Create Post Meta */
                
                $editLastMeta = new \Cms\Entity\WpPostmeta();
                $editLastMeta->setPost($post);
                $editLastMeta->setMetaKey('_edit_last'); //
                $editLastMeta->setMetaValue($identity->getId()); //last/current User Id who saved
                $this->em->persist($editLastMeta);
                
                $editLockMeta = new \Cms\Entity\WpPostmeta();
                $editLockMeta->setPost($post);
                $editLockMeta->setMetaKey('_edit_lock');
                $editLockMeta->setMetaValue(strtotime($post->getPostModified()->format('Y-m-d H:i:s')).':'.$identity->getId()); //last/current User Id who edited/editting
                $this->em->persist($editLockMeta);
                
                $this->getEntityManager()->flush();

                $message = MESSAGE_SUCCESS;
                
                $form = new PostForm();
                $form->get('submit')->setAttribute('value', 'Add');
            }
        }
        
        //Set avaiable parent list
        $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'taxonomy' => 'category',
                ));
        foreach ($termTaxonomies as $key => $termTaxonomy) {
            $terms[] = $termTaxonomy->getTerm();
        }
        $categories = $this->commonHelper()->termArrayLevel($terms);
        
        return new ViewModel(array(
            'form' => $form,
            //'categories_html' => $categories_html,
            'message' => $message,
            'categories' => $categories,
        ));
    }

    /*
     * Edit a post (ID)
     * 0. Check if post id under editing by postMeta postmeta.meta_value(_edit_lock) & posts.post_modified 
     * WP_POSTs:
     * 1. Create new revision post from that post with 
     *      post_status = inherit, 
     *      post_name = ID-revision-v[k], 
     *      post_parent = ID, 
     *      guid=URL/ID-revision-v[k], //need to find [K]
     *      post_type = revision
     * 2. Open parent post to edit
     *      + Create new post with 
     *          
     * WP_POSTMETAs:
     * 1. new/edit record with: meta_key = _edit_lock, meta_value = time():USER's ID when Open editor
     * 2. new/edit record with: meta_key = _edit_last, meta_value = USER's ID when Save only
     * 
     */
    public function editAction() {
        
        $error_message = array();
        $session = new Container('base');
        $message = '';
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute('home/Post');
        
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array(
                        'id' => $id,
                        'postType' => 'post'));
        if (is_null($post)) {
            return array(
                'message' => MESSAGE_ITEM_DOESNT_EXIST,
            );
        }
        
        $request = $this->getRequest();
        
        /**** CHECK IF OTHER PERSON IS EDITING POST THEN EXIT, ELSE EDIT _EDIT_LOCK POSTMETA 'N CONTINUE */
        //Create/edit Postmeta with meta_key = _edit_lock
        $postMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
            'post' => $post,
            'metaKey' => '_edit_lock',
        ));
        
        /* Check if post can be deleted or not */
        $editable = true; //post can be edited by default
        $lastModifiedTime = $post->getPostModified();
        $metaValues = explode(':', $postMeta->getMetaValue());
        
        //current user
        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
        
        if ($metaValues[1]!=$identity->getId()) { //if it's not user who was the last one edited the post then need to check the time
            $lastEditTime = date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", $metaValues[0]));
            if ($lastEditTime->diff($lastModifiedTime)->format('%R') == '-') { //if ($lastEditTime > $lastModifiedTime)
                $message = MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM;
                $editable = false; //post cannot be deleted
            }
        }        
        if (!$editable) return new ViewModel(array('message' => $message)); //EXIT
        
        //edit postmeta _edit_lock. Note: this meta always exist, it was created while creating post
        $postMeta->setMetaValue(time().':'.$identity->getId());
        /*****   end of double editing post ******************/
        
        /* if no one is editing post then we can continue */
        $form = new PostForm();
        $form->setBindOnValidate(false);
        $form->bind($post);
        $form->get('postDate')->setAttribute('value', $post->getPostDate()->format('Y-m-d H:i:s'));
        $form->get('postDateGmt')->setAttribute('value', $post->getPostDateGmt()->format('Y-m-d H:i:s'));
        $form->get('postModified')->setAttribute('value', $post->getPostModified()->format('Y-m-d H:i:s'));
        $form->get('postModifiedGmt')->setAttribute('value', $post->getPostModifiedGmt()->format('Y-m-d H:i:s'));
        
        $form->setAttribute('method', 'POST');
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) { //if input is validate
                //bind data to $post
                $form->bindValues(); 
                
                //check postName if it's right (postName: slug used in router to open post)
                $i = 1;
                if ($post->getPostName()!='') {
                    $postName = $this->commonHelper()->slug($post->getPostName());
                } elseif ($post->getPostTitle()!='') {
                    $postName = $this->commonHelper()->slug($post->getPostTitle());
                } else {
                    $postName = $post->getId();
                }
                $originalPostName = $postName;
                $query = "SELECT p FROM Cms\Entity\WpPosts p WHERE p.postName = '$postName' and p.postType = 'post' AND NOT p.id = ".$post->getId();
                $p = $this->getEntityManager()->createQuery($query)->getResult();
                while ($p) {
                    $i++;
                    $postName = $originalPostName .'-'.$i;
                    $query = "SELECT p FROM Cms\Entity\WpPosts p WHERE p.postName = '$postName' and p.postType = 'post' AND NOT p.id = ".$post->getId();
                    $p = $this->getEntityManager()->createQuery($query)->getResult();
                }
                
                //change value of PostAuthor and PostParent
                $post->setPostName($postName);
                $post->setPostModified(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time to current time
                $post->setPostModifiedGmt(date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", time()))); //set modified time GMT to current time
                $post->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $request->getPost('postAuthor'))); //need to improve here
                $post->setPostParent(null); //super post have post parent = null
                
                //set new values to form
                $form->get('postName')->setAttribute('value', $post->getPostName());
                $form->get('postModified')->setAttribute('value', $post->getPostModified()->format('Y-m-d H:i:s'));
                $form->get('postModifiedGmt')->setAttribute('value', $post->getPostModifiedGmt()->format('Y-m-d H:i:s'));
                
                /* create revision post */
                
                //get revision version
                $revisionPosts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
                        'postParent' => $post,
                        'postStatus' => 'inherit',
                        'postType' => 'revision'));
                $k = count($revisionPosts) + 1; //supose that no one delete revision handly (not through our system!)
                //create revision post
                $revisionPost = clone $post;
                $revisionPost->setPostAuthor($this->getEntityManager()->find('Cms\Entity\WpUsers', $identity->getId())); //need to improve here
                $revisionPost->setPostDate($post->getPostModified()); //set modified time to current time
                $revisionPost->setPostDateGmt($post->getPostModifiedGmt()); //set modified time GMT to current time
                $revisionPost->setPostStatus('inherit');
                $revisionPost->setPostName($post->getId().'-revision-v'.$k.'/');
                $revisionPost->setPostParent($post);
                $revisionPost->setGuid(SITE_URL.$revisionPost->getPostName());
                $revisionPost->setPostType('revision');                
                $this->em->persist($revisionPost);               
                
                //Create/edit Postmeta with meta_key = _edit_last
                $postMeta = $this->em->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
                    'post' => $post,
                    'metaKey' => '_edit_last',
                ));
                if ($postMeta) {
                    $postMeta->setMetaValue($identity->getId());
                } else {
                    $postMeta = new \Cms\OriginalEntity\WpPostmeta();
                    $postMeta->setPost($post);
                    $postMeta->setMetaKey('_edit_last');
                    $postMeta->setMetaValue($identity->getId());
                    $this->em->persist($postMeta);
                } 
                
                /*****           Set Categories & Tags          *****/
                //delete all categories and tags before setting them
                foreach ($post->getTermTaxonomies() as $termTaxonomy) {
                    $post->removeTermTaxonomy($termTaxonomy);
                    $termTaxonomy->setCount($termTaxonomy->getCount() - 1);
                }
                
                //set category: just need to set termTaxonomies because Terms are always exist
                $termIds = $request->getPost('postCategory', array()); //get Category checked list from Post
                foreach ($termIds as $termId) {
                    $term = $this->getEntityManager()->find('Cms\Entity\WpTerms', $termId);
                    foreach ($term->getTermTaxonomies() as $termTaxonomy) {
                       if ($termTaxonomy->getTaxonomy()=='category') { //be sure taxonomy is category
                           $post->addTermTaxonomy($termTaxonomy);
                           $termTaxonomy->setCount($termTaxonomy->getCount() + 1);
                       }
                    }
                }                
                
                //set tags: if Term doesn't exists then create it then set termTaxonomy
                $tags = $request->getPost('tags_field', array());
                $tags = $this->commonHelper()->validateTags($tags); //delete empty, similar tags to get new tags list
                foreach ($tags as $tag) {
                    $needCreateTerm = true;
                    $needCreateTermTaxonomy = true; //this pair can be (true, true), (false, false) and (false, true) only
                    $slug = $this->commonHelper()->slug($tag); //get slug from tag (Note: 1 slug can have different name and can be different types (eg: tag & category)
                    $term = $this->em->getRepository('Cms\Entity\WpTerms')->findOneBy(array( //slug MUST be different
                        'slug' => $slug,
                    ));
                    if ($term) { //if exist term with that slug then need to check its termTaxonomies
                        $needCreateTerm = false;
                        $termTaxonomies = $term->getTermTaxonomies();
                        foreach ($termTaxonomies as $termTaxonomy) { //go through every termTaxonomy of this termTaxonomies
                            if ($termTaxonomy->getTaxonomy()=='post_tag') { //if this term is tag then 
                                $needCreateTermTaxonomy = false;
                                $termTaxonomy->setCount($termTaxonomy->getCount() + 1);
                                $post->addTermTaxonomy($termTaxonomy); //add this term to post
                                break;
                            }                            
                        }
                    }
                    //in cases: 1. need to create both term & termTaxonomy
                    //          2. need to create only termTaxonomy, term already exists
                    if ($needCreateTermTaxonomy) {
                        if ($needCreateTerm) { //case 1
                            $term = new WpTerms();
                            $term->setName($tag);
                            $term->setSlug($slug);
                            $term->setTermGroup(0); //??
                            $this->getEntityManager()->persist($term);
                        }
                        //case 1 + 2
                        $termTaxonomy = new WpTermTaxonomy();
                        $termTaxonomy->setTaxonomy('post_tag');
                        $termTaxonomy->setDescription('');
                        $termTaxonomy->setParent(0);
                        $termTaxonomy->setCount(1);
                        $this->getEntityManager()->persist($termTaxonomy);

                        $term->addTermTaxonomy($termTaxonomy);
                        $post->addTermTaxonomy($termTaxonomy);
                    }                    
                }

                $message = MESSAGE_SUCCESS;
            }
        } 
        
        $this->getEntityManager()->flush();
        
        //Set avaiable parent list
        $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'taxonomy' => 'category',
                ));
        foreach ($termTaxonomies as $key => $termTaxonomy) {
            $terms[] = $termTaxonomy->getTerm();
        }
        $categories = $this->commonHelper()->termArrayLevel($terms);
        
        //Set own parent list
        $ownTermTaxonomies = $post->getTermTaxonomies();
        $ownCategoryIds = array();
        foreach ($ownTermTaxonomies as $key => $termTaxonomy) {
            $ownCategoryIds[] = $termTaxonomy->getTerm()->getTermId();
        }
        
        //get tags information
        $tags = $this->commonHelper()->getTags(array(
            'id' => $id,
            'type' => 'comma',
        ));
        
        //reset postAuthor value for viewing
        $form->get('postAuthor')->setAttribute('value', $post->getPostAuthor()->getId());
        $postParent = ($post->getPostParent()?$post->getPostParent()->getId():null);
        $form->get('postParent')->setAttribute('value', $postParent);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        return new ViewModel(array(
            'id' => $id,
            'form' => $form,
            'tags' => $tags,
            'ownCategoryIds' => $ownCategoryIds,
            'categories' => $categories,
            'message' => $message,
        ));
    }

    /*
     * Put a post (ID) to trash:
     * 1. Create new revision as for editAction()
     * 2. Set 
     */
    public function deleteAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Post');
        
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array( //slug MUST be different
            'id' => $id,
            'postType' => 'post',
        ));
        
        /* Check if post can be deleted or not */
        $postMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
            'post' => $post,
            'metaKey' => '_edit_lock',
        ));
        $editable = true; //post can be edited by default
        $lastModifiedTime = $post->getPostModified();
        $metaValues = explode(':', $postMeta->getMetaValue());
        
        //current user
        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
        
        if ($metaValues[1]!=$identity->getId()) { //if it's not user who was the last one edited the post then need to check the time
            $lastEditTime = date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", $metaValues[0]));
            if ($lastEditTime->diff($lastModifiedTime)->format('%R') == '-') { //if ($lastEditTime > $lastModifiedTime)
                $message = MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM;
                $editable = false; //post can be deleted
            }
        }        
        if (!$editable) return new ViewModel(array('message' => $message));
        //----
        
        if ($post) {
            $post->setPostStatus('trash');
            $this->getEntityManager()->persist($post);
            $this->getEntityManager()->flush();
        }

        return $this->redirect()->toRoute('home/Post', array(
            'controller' => 'post',
            'action' => 'post',
        ));
    }
    
    public function deletePermanentlyAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Post');
        
        $post = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findOneBy(array( //slug MUST be different
            'id' => $id,
            'postType' => 'post',
        ));
        
        /* Check if post can be deleted or not */
        $postMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
            'post' => $post,
            'metaKey' => '_edit_lock',
        ));
        $editable = true; //post can be edited by default
        $lastModifiedTime = $post->getPostModified();
        $metaValues = explode(':', $postMeta->getMetaValue());
        
        //current user
        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
        
        if ($metaValues[1]!=$identity->getId()) { //if it's not user who was the last one edited the post then need to check the time
            $lastEditTime = date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", $metaValues[0]));
            if ($lastEditTime->diff($lastModifiedTime)->format('%R') == '-') { //if ($lastEditTime > $lastModifiedTime)
                $message = MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM;
                $editable = false; //post can be deleted
            }
        }        
        if (!$editable) return new ViewModel(array('message' => $message));
        //----
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            //$del = $request->post()->get('del', 'No');
            $del = $request->getPost('del', 'No');
            if ($del == 'Yes') {
                //delete post
                $this->getEntityManager()->remove($post); 

                //descrease count of TermTaxonomy
                foreach ($post->getTermTaxonomies() as $termTaxonomy) {
                    $termTaxonomy->setCount($termTaxonomy->getCount() - 1);
                }

                /* No need because of on Delete/Update as Cascade */
                //delete inherited posts of exist
                //delete postmeta
                //delete term_relationship
                //---
                
                $this->getEntityManager()->flush();
            }
            return $this->redirect()->toRoute('home/Post', array(
                'controller' => 'post',
                'action' => 'trash',
            ));
        }
        return array(
            'post' => $this->getEntityManager()->find('Cms\Entity\WpPosts', $id),
        );
    }

    public function unpublishAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Post');
        $post = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        
        /* Check if post can be deleted or not */
        $postMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
            'post' => $post,
            'metaKey' => '_edit_lock',
        ));
        $editable = true; //post can be edited by default
        $lastModifiedTime = $post->getPostModified();
        $metaValues = explode(':', $postMeta->getMetaValue());
        
        //current user
        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
        
        if ($metaValues[1]!=$identity->getId()) { //if it's not user who was the last one edited the post then need to check the time
            $lastEditTime = date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", $metaValues[0]));
            if ($lastEditTime->diff($lastModifiedTime)->format('%R') == '-') { //if ($lastEditTime > $lastModifiedTime)
                $message = MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM;
                $editable = false; //post can be deleted
            }
        }        
        if (!$editable) return new ViewModel(array('message' => $message));
        //----
        
        if ($post) {
            $post->setPostStatus('draft');
            $this->getEntityManager()->persist($post); //co can ko?http://marco-pivetta.com/doctrine-orm-zf2-tutorial/#/28/4
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Post', array(
                'controller' => 'post',
                'action' => 'post',
        ));
    }
    
    //publish post 
    public function doPublishAction() {
        
        $id = (int)$this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) return $this->redirect()->toRoute ('home/Post');
        $post = $this->getEntityManager()->find('Cms\Entity\WpPosts', $id);
        
        /* Check if post can be deleted or not */
        $postMeta = $this->getEntityManager()->getRepository('Cms\Entity\WpPostmeta')->findOneBy(array(
            'post' => $post,
            'metaKey' => '_edit_lock',
        ));
        $editable = true; //post can be edited by default
        $lastModifiedTime = $post->getPostModified();
        $metaValues = explode(':', $postMeta->getMetaValue());
        
        //current user
        $identity = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService')->getIdentity();
        
        if ($metaValues[1]!=$identity->getId()) { //if it's not user who was the last one edited the post then need to check the time
            $lastEditTime = date_create_from_format('Y-m-d H:i:s', date("Y-m-d H:i:s", $metaValues[0]));
            if ($lastEditTime->diff($lastModifiedTime)->format('%R') == '-') { //if ($lastEditTime > $lastModifiedTime)
                $message = MESSAGE_ANOTHER_USER_IS_WORKING_WITH_ITEM;
                $editable = false; //post can be deleted
            }
        }        
        if (!$editable) return new ViewModel(array('message' => $message));
        //----
        
        if ($post) {
            $post->setPostStatus('publish');
            $this->getEntityManager()->persist($post); //co can ko?http://marco-pivetta.com/doctrine-orm-zf2-tutorial/#/28/4
            $this->getEntityManager()->flush();
        }
        return $this->redirect()->toRoute('home/Post', array(
                'controller' => 'post',
                'action' => 'post',
        ));
    }
}