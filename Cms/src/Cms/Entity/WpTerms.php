<?php
/**
 * This file is part of Cms
 *
 * (c) 2014 Keon Nguyen <cuongmits@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Cms\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * WpTerms
 *
 * @ORM\Table(name="wp_terms", uniqueConstraints={@ORM\UniqueConstraint(name="slug", columns={"slug"})}, indexes={@ORM\Index(name="name", columns={"name"})})
 * @ORM\Entity
 */
class WpTerms
{
    /**
     * @var integer
     *
     * @ORM\Column(name="term_id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $termId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200, nullable=false)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=200, nullable=false)
     */
    private $slug = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="term_group", type="bigint", nullable=false)
     */
    private $termGroup = '0';



    /**
     * Get termId
     *
     * @return integer 
     */
    public function getTermId()
    {
        return $this->termId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return WpTerms
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return WpTerms
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set termGroup
     *
     * @param integer $termGroup
     * @return WpTerms
     */
    public function setTermGroup($termGroup)
    {
        $this->termGroup = $termGroup;

        return $this;
    }

    /**
     * Get termGroup
     *
     * @return integer 
     */
    public function getTermGroup()
    {
        return $this->termGroup;
    }
    
    /**
     * ***************************************************
     * ADD MORE HERE
     * ***************************************************
     */
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->termTaxonomies = new ArrayCollection();
    }
    
    /**
     * @var Collection
     * 
     * @ORM\OneToMany(targetEntity="Cms\Entity\WpTermTaxonomy", mappedBy="term")
     */
    private $termTaxonomies;

    /**
     * Get termTaxonomies
     *
     * @return Collection 
     */
    public function getTermTaxonomies()
    {
        return $this->termTaxonomies;
    }

    /**
     * Set termTaxonomies
     *
     * @param Collection $usermetas
     * @return WpTerms
     */
    public function addTermTaxonomy(\Cms\Entity\WpTermTaxonomy $termTaxonomy)
    {
        $this->termTaxonomies->add($termTaxonomy);
        $termTaxonomy->setTerm($this);
    }    
    
    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) {
        $this->termId = $data['termId'];
        $this->name = $data['name'];
        $this->slug = $data['slug'];
        $this->termGroup = $data['termGroup'];
    }

    /**
     * Remove termTaxonomies
     *
     * @param \Cms\Entity\WpTermTaxonomy $termTaxonomies
     */
    public function removeTermTaxonomy(\Cms\Entity\WpTermTaxonomy $termTaxonomies)
    {
        $this->termTaxonomies->removeElement($termTaxonomies);
    }
}
