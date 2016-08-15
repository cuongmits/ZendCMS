<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CMS\Common;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\AbstractActionController,
    Doctrine\ORM\EntityManager;

use Zend\View\Model\ViewModel, 
    //Pagination
    DoctrineModule\Paginator\Adapter\Selectable as SelectableAdapter,
    Zend\Paginator\Paginator,
    Cms\Form\PostForm,
    Cms\Entity\WpPosts,
    Cms\Entity\WpTerms,
    Cms\Entity\WpTermTaxonomy,
    Cms\Entity\WpTermRelationships,
    Doctrine\Common\Collections\Criteria;

class CommonHelper extends AbstractPlugin
{
    /* Singleton declaration */
    private static $_singleton;
    
    /* private function __construct() { */
    public function __construct() {
    }

    public static function getInstance() {
        if(!self::$_singleton) {
            self::$_singleton = new CommonHelper();
        }
        return self::$_singleton;
    }
    
    /* VARIABLES */
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;
    
    /* COMMON FUNCTIONS */
    
    /**
    * Return array of posts by tag
    *
    * @param $tag
    *
    * @return row of table 
    */ 
   public function getPostsByTag($tag) {
       return array();
   }
    
    /* FUNCTION */
    public function getMode()
    {
        return "test";
    }
    
    public function getEntityManager()
    {
        if (null === $this->em) {
            //$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            $this->em = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    
    /* need to improve */
    /**
     * Convert string into slug.
     *
     * @param $string
     *
     * @return slug
     */ 
    public function slug($string)
    {
        return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
    }
    
    /**
     * Get next autoincrement ID of table of database.
     *
     * @param $dbname: name of database
     *        $tbname: table name
     *
     * @return next increment index (int)
     */
    public function getAutoIncrementIndex($dbname, $tbname) {
        $con = mysqli_connect('localhost', 'root', 'nhcchn', 'information_schema');
        if (mysqli_connect_errno()) {
            $result = "Fail to connect to mySQL: " . mysqli_connect_error();
        } else {
            $query = mysqli_query($con, 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = "'.$dbname.'" AND TABLE_NAME = "'.$tbname.'"');
            $row = mysqli_fetch_array($query);
            $result = $row['AUTO_INCREMENT'];
        }
        mysqli_close($con);
        return $result;
    }
    
    /*
     * Get term by function: get 1 row with taxonomy and value of 1 column
     * $field = Either 'termId', 'slug', 'name', or 'termTaxonomyId'
     * $value = value
     * $taxonomy = category, post_tag, link_category or something custom
     * 
     * By default: input value MUST BE VALID
     * 
     */
    public function get_term_by($field, $value, $taxonomy) {
        $taxonomies = $this->getEntityManager()->createQuery("select count(*) from wp_term_taxonomy where taxonomy = $taxonomy");
        if ($taxonomies < 1) return false;
                
        if ('slug' == $field) {
            $field = 't.slug';
        } else if ('name' == $field) {
            $field = 't.name';
        } else if ('termTaxonomyId' == $field) {
            $value = (int) $value;
            $field = 'tt.termTaxonomyId';
        } else {
            $term = $this->getEntityManager()->createQuery("select * from wp_terms where termId = $field");
            if (!$term) return false;
            return $term;
        }
        
        $term = $this->getEntityManager()->createQuery("SELECT t.*, tt.* FROM wp_terms AS t INNER JOIN wp_term_taxonomy AS tt ON t.termId = tt.termId WHERE tt.taxonomy = $taxonomy AND $field = $value");
        if (!$term) return false;
        return $term;
    }
    
    /**
     * Get Term&TermTaxonomy by taxonomy.
     *
     * @param $taxonomy (string: category, post_tag...)
     *
     * @return array of (Term, TermTaxonomy)
     */ 
    public function getAllTermByTaxonomy($taxonomy) {
        /*
        $query = $this->getEntityManager()->createQuery("SELECT t, tt FROM Cms\Entity\WpTerms t left join Cms\Entity\WpTermTaxonomy tt with t.termId = tt.termId where tt.taxonomy = '$taxonomy' order by t.termId desc");
        $term = $query->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
        if (!$term) return array(); //false;
        return $term; */
        $terms = $this->getEntityManager()->createQuery("SELECT t, tt FROM Cms\Entity\WpTerms t join t.termTaxonomies tt where tt.taxonomy = '$taxonomy' order by t.termId desc")
                ->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
        if (!$terms) return array(); //false;
        return $terms;
    }
    
    /**
     * Get all categories, tags contain post by post id.
     *
     * @param Expression $ID
     *
     * @return array of categories
     */ 
    public function getTermIdByPostId($id) {
        $query = $this->getEntityManager()->createQuery("SELECT tr FROM Cms\Entity\WpTermRelationships tr where tr.objectId = '$id'");
        $term = $query->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
        if (!$term) return array();//false;
        return $term;
    }
    
    /**
     * Get posts paginator by $criteria
     * $c = array(
     *      'post_author' => array(),
     *      'post_date' => array(),
     *      'post_date_gmt' => array(),
     *      ...
     * )
     *
     * @param null
     *
     * @return paginator of All post by $criteria
     */ 
    public function getPaginatorPosts($c = null) {
        /*
        $criteria = Criteria::create()
                ->where(Criteria::expr()->eq('post_status', 'publish'))
                ->orWhere(Criteria::expr()->eq('post_status', 'draft'))
                ->andWhere(Criteria::expr()->eq('post_type', 'post'))
                ->orderBy(array('post_date' => \Doctrine\Common\Collections\Criteria::DESC)); */
        $criteria = Criteria::create();
        $needAnd = false;
        if (isset($c['postAuthor'])) {
            $criteria->where(Criteria::expr()->in('postAuthor', $c['postAuthor']));
            $needAnd = true;
        }
        if (isset($c['postDate'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postDate', $c['postDate']));
            } else {
                $criteria->where(Criteria::expr()->in('postDate', $c['postDate']));
                $needAnd = true;
            }
        }
        if (isset($c['postDateGmt'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postDateGmt', $c['postDateGmt']));
            } else {
                $criteria->where(Criteria::expr()->in('postDateGmt', $c['postDateGmt']));
                $needAnd = true;
            }
        }
        if (isset($c['postContent'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postContent', $c['postContent']));
            } else {
                $criteria->where(Criteria::expr()->in('postContent', $c['postContent']));
                $needAnd = true;
            }
        }
        if (isset($c['postTitle'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postTitle', $c['postTitle']));
            } else {
                $criteria->where(Criteria::expr()->in('postTitle', $c['postTitle']));
                $needAnd = true;
            }
        }
        if (isset($c['postExcerpt'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postExcerpt', $c['postExcerpt']));
            } else {
                $criteria->where(Criteria::expr()->in('postExcerpt', $c['postExcerpt']));
                $needAnd = true;
            }
        }
        if (isset($c['postStatus'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postStatus', $c['postStatus']));
            } else {
                $criteria->where(Criteria::expr()->in('postStatus', $c['postStatus']));
                $needAnd = true;
            }
        }
        if (isset($c['commentStatus'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentStatus', $c['commentStatus']));
            } else {
                $criteria->where(Criteria::expr()->in('commentStatus', $c['commentStatus']));
                $needAnd = true;
            }
        }
        if (isset($c['pingStatus'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('pingStatus', $c['pingStatus']));
            } else {
                $criteria->where(Criteria::expr()->in('pingStatus', $c['pingStatus']));
                $needAnd = true;
            }
        }
        if (isset($c['postPassword'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postPassword', $c['postPassword']));
            } else {
                $criteria->where(Criteria::expr()->in('postPassword', $c['postPassword']));
                $needAnd = true;
            }
        }
        if (isset($c['postName'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postName', $c['postName']));
            } else {
                $criteria->where(Criteria::expr()->in('postName', $c['postName']));
                $needAnd = true;
            }
        }
        if (isset($c['toPing'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('toPing', $c['toPing']));
            } else {
                $criteria->where(Criteria::expr()->in('toPing', $c['toPing']));
                $needAnd = true;
            }
        }
        if (isset($c['pinged'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('pinged', $c['pinged']));
            } else {
                $criteria->where(Criteria::expr()->in('pinged', $c['pinged']));
                $needAnd = true;
            }
        }
        if (isset($c['postModified'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postModified', $c['postModified']));
            } else {
                $criteria->where(Criteria::expr()->in('postModified', $c['postModified']));
                $needAnd = true;
            }
        }
        if (isset($c['postModifiedGmt'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postModifiedGmt', $c['postModifiedGmt']));
            } else {
                $criteria->where(Criteria::expr()->in('postModifiedGmt', $c['postModifiedGmt']));
                $needAnd = true;
            }
        }
        if (isset($c['postContentFiltered'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postContentFiltered', $c['postContentFiltered']));
            } else {
                $criteria->where(Criteria::expr()->in('postContentFiltered', $c['postContentFiltered']));
                $needAnd = true;
            }
        }
        if (isset($c['postParent'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postParent', $c['postParent']));
            } else {
                $criteria->where(Criteria::expr()->in('postParent', $c['postParent']));
                $needAnd = true;
            }
        }
        if (isset($c['guid'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('guid', $c['guid']));
            } else {
                $criteria->where(Criteria::expr()->in('guid', $c['guid']));
                $needAnd = true;
            }
        }
        if (isset($c['menuOrder'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('menuOrder', $c['menuOrder']));
            } else {
                $criteria->where(Criteria::expr()->in('menuOrder', $c['menuOrder']));
                $needAnd = true;
            }
        }
        if (isset($c['postType'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postType', $c['postType']));
            } else {
                $criteria->where(Criteria::expr()->in('postType', $c['postType']));
                $needAnd = true;
            }
        }
        if (isset($c['postMimeType'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('postMimeType', $c['postMimeType']));
            } else {
                $criteria->where(Criteria::expr()->in('postMimeType', $c['postMimeType']));
                $needAnd = true;
            }
        }
        if (isset($c['commentCount'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentCount', $c['commentCount']));
            } else {
                $criteria->where(Criteria::expr()->in('commentCount', $c['commentCount']));
                $needAnd = true;
            }
        }
        if (isset($c['orderBy'])) {
            $criteria->orderBy($c['orderBy']);
        }
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpPosts'), $criteria);
        return new Paginator($adapter);
        //return $paginator->getCurrentItemCount();
    }
    
    /**
     * Get comments paginator by $criteria
     * $c = array(
     *      'commentIв' => array(),
     *      'comment_post_ID' => array(),
     *      'comment_author' => array(),
     *      ...
     * )
     *
     * @param null
     *
     * @return paginator of All post by $criteria
     */ 
    public function getPaginatorComments($c = null) {
        $criteria = Criteria::create();
        $needAnd = false;
        if (isset($c['commentIв'])) {
            $criteria->where(Criteria::expr()->in('commentIв', $c['commentIв']));
            $needAnd = true;
        }
        if (isset($c['commentPostId'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentPostId', $c['commentPostId']));
            } else {
                $criteria->where(Criteria::expr()->in('commentPostId', $c['commentPostId']));
                $needAnd = true;
            }
        }
        if (isset($c['commentAuthor'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentAuthor', $c['commentAuthor']));
            } else {
                $criteria->where(Criteria::expr()->in('commentAuthor', $c['commentAuthor']));
                $needAnd = true;
            }
        }
        if (isset($c['commentAuthorEmail'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentAuthorEmail', $c['commentAuthorEmail']));
            } else {
                $criteria->where(Criteria::expr()->in('commentAuthorEmail', $c['commentAuthorEmail']));
                $needAnd = true;
            }
        }
        if (isset($c['commentAuthorUrl'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentAuthorUrl', $c['commentAuthorUrl']));
            } else {
                $criteria->where(Criteria::expr()->in('commentAuthorUrl', $c['commentAuthorUrl']));
                $needAnd = true;
            }
        }
        if (isset($c['commentAuthorIp'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentAuthorIp', $c['commentAuthorIp']));
            } else {
                $criteria->where(Criteria::expr()->in('commentAuthorIp', $c['commentAuthorIp']));
                $needAnd = true;
            }
        }
        if (isset($c['commentDate'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentDate', $c['commentDate']));
            } else {
                $criteria->where(Criteria::expr()->in('commentDate', $c['commentDate']));
                $needAnd = true;
            }
        }
        if (isset($c['commentDateGmt'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentDate_gmt', $c['commentDateGmt']));
            } else {
                $criteria->where(Criteria::expr()->in('commentDateGmt', $c['commentDateGmt']));
                $needAnd = true;
            }
        }
        if (isset($c['commentContent'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentContent', $c['commentContent']));
            } else {
                $criteria->where(Criteria::expr()->in('commentContent', $c['commentContent']));
                $needAnd = true;
            }
        }
        if (isset($c['commentKarma'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentKarma', $c['commentKarma']));
            } else {
                $criteria->where(Criteria::expr()->in('commentKarma', $c['commentKarma']));
                $needAnd = true;
            }
        }
        if (isset($c['commentApproved'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentApproved', $c['commentApproved']));
            } else {
                $criteria->where(Criteria::expr()->in('commentApproved', $c['commentApproved']));
                $needAnd = true;
            }
        }
        if (isset($c['commentAgent'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentAgent', $c['commentAgent']));
            } else {
                $criteria->where(Criteria::expr()->in('commentAgent', $c['commentAgent']));
                $needAnd = true;
            }
        }
        if (isset($c['commentType'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentType', $c['commentType']));
            } else {
                $criteria->where(Criteria::expr()->in('commentType', $c['commentType']));
                $needAnd = true;
            }
        }
        if (isset($c['commentParent'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('commentParent', $c['commentParent']));
            } else {
                $criteria->where(Criteria::expr()->in('commentParent', $c['commentParent']));
                $needAnd = true;
            }
        }
        if (isset($c['userId'])) {
            if ($needAnd) {
                $criteria->andWhere(Criteria::expr()->in('userId', $c['userId']));
            } else {
                $criteria->where(Criteria::expr()->in('userId', $c['userId']));
                $needAnd = true;
            }
        }
        if (isset($c['orderBy'])) {
            $criteria->orderBy($c['orderBy']);
        }
        $adapter = new SelectableAdapter($this->getEntityManager()->getRepository('Cms\Entity\WpComments'), $criteria);
        return new Paginator($adapter);
    }
    
    /**
     * Get all posts, which cannot be parent of post ID
     *
     * @param Expression $ID
     *
     * @return array of post IDs
     */ 
    public function getNotParents($id) {
        $parents[] = $id;
        $res[] = $id; //page cannot be parent of itself
        while (!empty($parents)) {
            foreach ($parents as $key => $value) {
                unset($parents[$key]);
                $son_posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
                    //'post_status' => 'draft',
                    'post_type' => 'page',
                    'post_parent' => $value,
                ));
                foreach ($son_posts as $key => $son_post) {
                    $parents[] = $son_post->ID;
                    $res[] = $son_post->ID;                    
                }
            }
        }
        return $res;
    }
    
    /**
     * Get parents of post by its id.
     * Parents = all pages, which is not son (or son of son) or page itself
     *
     * @param Expression $ID
     *
     * @return array of categories
     */ 
    public function getParents($id = null) {
        $parents = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
            'postStatus' => 'publish',
            'postType' => 'page',
        ));
        if ($id!=null) {
            $notParents = $this->getNotParents($id);
            foreach ($parents as $key => $parent) {
                if (in_array($parent->ID, $notParents)) {
                    unset($parents[$key]);
                }
            }
        }
        return $parents;
    }
    
    
    /**
     * Get all publish posts (publish)
     *
     * @param null
     *
     * @return array of All publish post (post_status = publish)
     */ 
    public function getPublishPages() {
        return $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')
                ->findBy(array(
                    'post_status' => 'publish', 
                    'post_type' => 'page',));
    }
        
    /**
     * Get row by tablename, array()
     *
     * @param null
     *
     * @return row of table 
     */ 
    public function getEntityListBy($entityName, $criteria) {
        $is_first_criteria = true;
        $s = '';
        foreach ($criteria as $key => $value) {
            if ($is_first_criteria) $s = "where en.$key = '$value'";
            else $s = "and $key = '$value'";
        }
        $query = $this->getEntityManager()->createQuery("SELECT en FROM $entityName en $s");
        //$query->setParameter(1, 'jwage');
        //$term = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY); //roi nhau
        $term = $query->getResult(\Doctrine\ORM\Query::HYDRATE_SCALAR);
        if (!$term) return false; //false;
        return $term;
    }
    
    /**
     * Get all tags if postID = null or tags of post by postID
     * $type = null: tags separated by comma
     * $type = 'array': return tags in array type
     *
     * @param $id (int), $type = 'array'
     *
     * @return text of tags separate by comma (,)
     */ 
    public function getTags($criteria = null) { //$$id = 'all', $type = null) {
        $res = null;
        if (is_null($criteria['id'])) {
            $term_relationships = $this->getEntityManager()->getRepository('Cms\Entity\WpTermRelationships')->findAll();
        } else {
            $term_relationships = $this->getEntityManager()->getRepository('Cms\Entity\WpTermRelationships')->findBy(array(
                'objectId' => $criteria['id'],
            ));
        }        
        foreach ($term_relationships as $term_relationship) {
            $term_taxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'termTaxonomyId' => $term_relationship->gettermTaxonomyId(),
                'taxonomy' => 'post_tag',
            ));
            foreach ($term_taxonomies as $term_taxonomy) {
                $term = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array(
                    'termId' => $term_taxonomy->getTerm()->getTermId(),
                ));
                if ($criteria['type'] == 'comma') {
                    if (is_null($res)) {
                        $res = $term->getName();
                    } else {
                        $res .= ', '.$term->getName();
                    }
                } elseif (is_null($criteria) || $criteria['type']=='array') {
                    $res[] = $term->getName();
                } elseif (!is_null($criteria['type']) && $criteria['type']=='html') {
                    if (is_null($res)) {
                        $res = '<table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Slug</th>
                                            <th>Posts</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th><input type="checkbox"></th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Slug</th>
                                            <th>Posts</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>';
                    }
                    $res .= '           <tr>
                                            <th><input type="checkbox"></th>
                                            <th>'.$term->getName().'</th>
                                            <th>'.$term_taxonomy->getDescription().'</th>
                                            <th>'.$term->getSlug().'</th>
                                            <th>'.count($this->getPostsByTag($term->getName())).'</th>
                                        </tr>';
                }
            }
        }
        if (!is_null($criteria['type']) && $criteria['type']=='html') {
            $res .=     '</tbody>
                    </table>';
        }
        return $res;
    }
    
    /**
     * Delete empty elements, similar elements
     * 
     * @param $tags (text separate by comma)
     *
     * @return tags array with not repeated element, not space at front/end, not repeat element
     */ 
    public function validateTags($tags) {
        $tags = explode(',', $tags);
        $res = array();
        foreach ($tags as $key => $tag) {
            $tag = trim($tag);
            if (!is_null($tag)&&$tag!='') {
                if (!in_array($tag, $res)) {
                    $res[] = $tag;
                }
            }
        }
        return $res;
    }
    
    /**
     * Set post tags by postID and tags. Add new record to TERM_RELATIONSHIP
     * 1. Delete all old tags
     * 2. Set all new tags
     * 3. Delete record in TERMS and TERM_TAXONOMY if no post has that tag (do later)
     *
     * @param $id (int) $tags (text separate by comma
     *
     * @return post with new tags
     */ 
    /*
    public function setTags($id, $tags) {
        $tags = $this->validateTags($tags);
        
        //delete all old tags of post
        $query = $this->getEntityManager()->createQuery("SELECT tr FROM Cms\Entity\WpTermRelationships tr left join Cms\Entity\WpTermTaxonomy tt with tr.termTaxonomyId = tt.termTaxonomyId where tt.taxonomy = 'post_tag' and tr.objectId = '$id'");
        $term_relationships = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        foreach ($term_relationships as $term_relationship) {
            $item = $this->getEntityManager()->getRepository('Cms\Entity\WpTermRelationships')->findOneBy(array(
                'objectId' => (int)$term_relationship['objectId'],
                'termTaxonomyId' => (int)$term_relationship['termTaxonomyId'],
                'termOrder' => (int)$term_relationship['termOrder'],
            ));
            $this->getEntityManager()->remove($item);
        }
        $this->getEntityManager()->flush();
        
        //add new tags
        foreach ($tags as $key => $tag) {
            $slug = $this->slug($tag); //get slug for tag
            $term = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array( //find term by slug //?? Truong hop category va tag cung slug ???
                'slug' => $slug, //Category and Tag can have similar slug (1 record in TERMS) but 2 taxonomies in TERM_TAXONOMY
            ));
            $termId;
            if (is_null($term)) { //if doens't exist, need to create new row in TERMS ...
                $term = new WpTerms();
                $term->setName($tag);
                $term->setSlug($slug);
                $term->setTermGroup(0); //tim hieu them ve term group
                $this->getEntityManager()->persist($term);
                $this->getEntityManager()->flush();
                $termId = $term->getTermId();

                $term_taxonomy = new WpTermTaxonomy(); //..and TERM_TAXONOMY
                $term_taxonomy->setTermId( $termId);
                $term_taxonomy->setTaxonomy('post_tag');
                $term_taxonomy->setDescription('');
                $term_taxonomy->setParent(0);
                $term_taxonomy->setCount(1);
                $this->getEntityManager()->persist($term_taxonomy);
                $this->getEntityManager()->flush();
                $termTaxonomyId = $term_taxonomy->getTermTaxonomyId();
            } else { //if exists, need to get its ID (not auto increment id)
                $termId = $term->getTermId(); //get termId if term already exists
                $term_taxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                    'termId' => $termId,
                ));
                $termTaxonomyId = $term_taxonomies[0]->getTermTaxonomyId(); //ready to add new record to TERM_RELATIONSHIP
                
                //and reset Name in case it's changed (eg: from 2 spaces to 1 space)
                $term->setName($tag);
                $this->getEntityManager()->persist($term);                
            }
            //it's safe to add in TERM_RELATIONSHIPS because all term_relationships are deleted above
            $term_relationship = new WpTermRelationships();
            $term_relationship->setObjectId($id);
            $term_relationship->setTermTaxonomyId((int)$termTaxonomyId);
            $term_relationship->setTermOrder(0); //need to check in future
            $this->getEntityManager()->persist($term_relationship);
            
            $this->getEntityManager()->flush();
        }
        return true;
    }  
    */
    
    /**
     * Get tags of post by postID
     *
     * @param $id (int)
     *
     * @return text of tags separate by comma (,)
     */ 
    public function setCategories($id, $categories) {
        $res = '';
        $term_relationships = $this->getEntityManager()->getRepository('Cms\Entity\WpTermRelationships')->findBy(array(
            'objectId' => $id,
        ));
        foreach ($term_relationships as $term_relationship) {
            $term_taxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                'termTaxonomyId' => $term_relationship->getTermTaxonomyId(),
                'taxonomy' => 'post_tag',
            ));
            foreach ($term_taxonomies as $term_taxonomy) {
                $terms = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findBy(array(
                    'termId' => $term_taxonomy->getTermId(),
                ));
                if ($res=='') {
                    $res = $terms[0]->getName();
                } else {
                    $res .= ', '.$terms[0]->getName();
                }
            }
        }
        return $res;
    }
    
    /* ************************************************* */
    /* ****                   View                  **** */
    /* ************************************************* */
    
    /* check if tt_termTaxonomyId ($category) in tr_termTaxonomyId ($categories) or not
     * for echoCategories() only
     * $category: array (size=10)
        't_termId' => int 1
        't_name' => string 'Uncategorized' (length=13)
        't_slug' => string 'uncategorized' (length=13)
        't_term_group' => string '0' (length=1)
        'tt_termTaxonomyId' => string '1' (length=1)
        'tt_termId' => string '1' (length=1)
        'tt_taxonomy' => string 'category' (length=8)
        'tt_description' => string '' (length=0)
        'tt_parent' => string '0' (length=1)
        'tt_count' => string '2' (length=1)
     * $categories: null/array() or array (size=3)
        0 => 
          array (size=3)
            'tr_objectId' => string '155' (length=3)
            'tr_termTaxonomyId' => string '3' (length=1)
            'tr_term_order' => string '0' (length=1)
        1 => 
          array (size=3)
            'tr_objectId' => string '155' (length=3)
            'tr_termTaxonomyId' => string '9' (length=1)
            'tr_term_order' => string '0' (length=1)
        2 => 
          array (size=3)
            'tr_objectId' => string '155' (length=3)
            'tr_termTaxonomyId' => string '10' (length=2)
            'tr_term_order' => string '0' (length=1)
     * return checked if exists, or ''
     */
    private function categoryCheck($category, $categories) {
        $res = '';
        if (!is_null($categories)&&count($categories)>0) {
            if (in_array(array(
                'tr_objectId' => $categories[0]['tr_objectId'],
                'tr_termTaxonomyId' => $category['tt_termTaxonomyId'],
                'tr_termOrder' => $categories[0]['tr_termOrder']), $categories)) {
                $res = 'checked';
            }
        }
        return $res;
    }
    
    /**
     * get Tree of $parent from array $items
     *
     * @param $parent, $items
     *
     * @return array of tree, which parent is $parent
     */ 
    public function getTree(&$res, $parent, &$terms, $level) {
        $res[] = $parent;
        if (count($terms)>0) {            
            $level .= '— ';
            foreach ($terms as $key => $term) {
                foreach ($term->getTermTaxonomies() as $termTaxonomy) {
                    if ($termTaxonomy->getParent() == $parent->getTermId() && $termTaxonomy->getTaxonomy() == 'category') {                    
                        $term->setName($level.$term->getName());
                        unset($terms[$key]);
                        $newTerms = $terms;
                        $this->getTree($res, $term, $newTerms, $level);
                        
                    }
                }
            }
        }
    }
    
    /**
     * Print space belongs to level
     * dad level = 0, son level +=1
     *
     * @param $category, $categories
     *
     * @return string with space * level
     */ 
    public function termArrayLevel($terms) {
        $res = array();
        $parents = array();
        foreach ($terms as $key => $term) { 
            foreach ($term->getTermTaxonomies() as $termTaxonomy) {
                if ($termTaxonomy->getParent() == 0 && $termTaxonomy->getTaxonomy()=='category') {
                    $parents[] = $term;
                    unset($terms[$key]);
                }
            }
        }
        foreach ($parents as $key => $parent) {
            $this->getTree($res, $parent, $terms, '');
        }
        return $res;
    }
    
    
    
    /**
     * get Tree of $parent from array $items
     *
     * @param $parent, $items
     *
     * @return array of tree, which parent is $parent
     */ 
    public function getPageTree(&$res, $parent, &$pages, $level) {
        $res[] = $parent;
        if (count($pages)>0) {            
            $level .= '— ';
            foreach ($pages as $key => $page) {
                if ($page->getPostParent()->getId() == $parent->getId()) {
                //if ($page->getPostParent() == $parent) {
                    $page->setPostTitle($level.$page->getPostTitle());
                    unset($pages[$key]);
                    //$newPages = $pages;
                    //$this->getPageTree($res, $page, $newPages, $level);
                    $this->getPageTree($res, $page, $pages, $level);
                }
            }
        }
    }
    
    /**
     * Print space belongs to level
     * dad level = 0, son level +=1
     *
     * @param $category, $categories
     *
     * @return string with space * level
     */ 
    public function pageArrayLevel($pages) {
        /* get page Id array */
        $ids = array();
        foreach ($pages as $page) {
            $ids[] = $page->getId();
        }
        
        /* get root pages */
        $parents = array();        
        foreach ($pages as $key => $page) { 
            if (is_null($page->getPostParent())||(!in_array($page->getPostParent()->getId(), $ids))) {
                $parents[] = $page;
                unset($pages[$key]);
            }
        }
        
        $res = array();
        foreach ($parents as $key => $parent) {
            $this->getPageTree($res, $parent, $pages, '');
        }
        return $res;
    }
    
    /**
     * Get list of post/page children, children of children... including post/page itself
     * it is used in:
     * - PageController for listing avaiable page parents
     *
     * @param $post/$page, $type
     *
     * @return array of term children Ids
     */ 
    public function getPostChildrenId($post) {
        $remains[] = $post;
        $newRemains = array();
        $childIdList = array();
        
        while (count($remains)>0) {
            foreach ($remains as $remain) {
                $childIdList[] = (int)$remain->getId();
                $posts = $this->getEntityManager()->getRepository('Cms\Entity\WpPosts')->findBy(array(
                    'postParent' => $remain,
                    'postType' => 'page',
                ));
                foreach ($posts as $postItem) {
                    $newRemains[] = $postItem;
                }
            }
            $remains = $newRemains;
            $newRemains = array();
        }
        
        return $childIdList;
    }
    
    
    /**
     * Get list of term children, children of children... including term itself
     * it is use for choosing category parent / page parent of category / page
     *
     * @param $term, $termType
     *
     * @return array of term children Ids
     */ 
    public function getTermChildrenId($term, $termType) {
        //get TermTaxonomy Ids list, that its Term cannot be parent of editing category, it contains:
        // - current TermTaxonomy itself
        // - children and subchildren of that TermTaxonomy
        $termTaxonomy = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findOneBy(array(
            'term' => $term,
            'taxonomy' => $termType,
        ));
        $remains[] = $termTaxonomy;
        $newRemains = array();
        $childTermIdList = array();
        
        while (count($remains)>0) {
            foreach ($remains as $remain) {
                $childTermIdList[] = $remain->getTerm()->getTermId();
                $termTaxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                    'parent' => $remain->getTerm()->getTermId(),
                    'taxonomy' => $termType,
                ));
                foreach ($termTaxonomies as $termTaxonomyItem) {
                    $newRemains[] = $termTaxonomyItem;
                }
            }
            $remains = $newRemains;
            $newRemains = array();
        }
        
        return $childTermIdList;
    }
    
    /**
     * Show tags in html type
     *
     * @param null
     *
     * @return html string
     */ 
    public function echoTags() {
        $res = '';
        $res = $this->getTags(null, 'array');     
        return $res;
    }
    
    /**
     * Add a new tag
     *
     * @param tag name
     *
     * @return true - success, false - not success; new record added to TERMS, TERM_TAXONOMY
     */ 
    public function addTag($tag) {
        $tag = $this->slug($tag);
        $tags = $this->validateTags($tags);
        
        //delete all old tags of post
        $query = $this->getEntityManager()->createQuery("SELECT tr FROM Cms\Entity\WpTermRelationships tr left join Cms\Entity\WpTermTaxonomy tt with tr.termTaxonomyId = tt.termTaxonomyId where tt.taxonomy = 'post_tag' and tr.objectId = '$id'");
        $term_relationships = $query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        //return $term_relationships;
        foreach ($term_relationships as $term_relationship) {
            $item = $this->getEntityManager()->getRepository('Cms\Entity\WpTermRelationships')->findOneBy(array(
                'objectId' => (int)$term_relationship['objectId'],
                'termTaxonomyId' => (int)$term_relationship['termTaxonomyId'],
                'term_order' => (int)$term_relationship['term_order'],
            ));
            //return $term_relationship['objectId'];
            $this->getEntityManager()->remove($item);
        }
        $this->getEntityManager()->flush();
        
        
        
        //add new tags
        foreach ($tags as $key => $tag) {
            $tag = trim($tag);
            //if (!is_null($tag)&&$tag!='') { //if tag != null
            $slug = $this->slug($tag); //get slug for tag
            $term = $this->getEntityManager()->getRepository('Cms\Entity\WpTerms')->findOneBy(array( //find term by slug //?? Truong hop category va tag cung slug ???
                'slug' => $slug,
            ));
            $termId = $this->getAutoIncrementIndex(DB_NAME, DB_TERMS); //get next id in case create new term
            if (is_null($term)) { //if doens't exist, need to create new row in TERMS ...
                $term = new WpTerms();
                $term->setName($tag);
                $term->setSlug($slug);
                $term->setTermGroup(0); //tim hieu them ve term group
                $this->getEntityManager()->persist($term);

                $termTaxonomyId = $this->getAutoIncrementIndex(DB_NAME, DB_TERM_TAXONOMY);
                $term_taxonomy = new WpTermTaxonomy(); //..and TERM_TAXONOMY
                $term_taxonomy->setTermId( $termId);
                $term_taxonomy->setTaxonomy('post_tag');
                $term_taxonomy->setDescription('');
                $term_taxonomy->setParent(0);
                $term_taxonomy->setCount(1);
                $this->getEntityManager()->persist($term_taxonomy);
            } else { //if exists, need to get its ID (not auto increment id)
                $termId = $term->getTermId(); //get termId if term already exists
                $term_taxonomies = $this->getEntityManager()->getRepository('Cms\Entity\WpTermTaxonomy')->findBy(array(
                    'termId' => $termId,
                ));
                $termTaxonomyId = $term_taxonomies[0]->getTermTaxonomyId(); //ready to add new record to TERM_RELATIONSHIP
            }
            //it's safe to add in TERM_RELATIONSHIPS because all term_relationships are deleted above
            $term_relationship = new WpTermRelationships();
            $term_relationship->setObjectId($id);
            $term_relationship->setTermTaxonomyId((int)$termTaxonomyId);
            $term_relationship->setTermOrder(0); //need to check in future
            $this->getEntityManager()->persist($term_relationship);
            //}
        }
        $this->getEntityManager()->flush();
        return true;
    }
    
    /**
     * Check if item in table with criteria exists
     *
     * @param $criteria (array)
     *
     * @return true - exists, false - not exists
     */ 
    public function itemExists($criteria) {

    }
        
    /**
     * Add a new termTaxonomy by criteria
     *
     * @param $criteria (array)
     *
     * @return true - success, false - not success; new record added to TERMS, TERM_TAXONOMY
     */ 
    public function addTermTaxonomy($criteria) {
        
    }
}