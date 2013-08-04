<?php

namespace Admin\NavMenuBundle\Entity;


use Doctrine\ORM\Mapping as ORM;


/**
 * NavMenu
 */
class NavMenu 
{
    const PATH_SEPARATOR = '/';

    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $url = null;

    /**
     * @var integer
     */
    private $pageId = null;

    /**
    * @var string
    */
    private $children = null;    

    
    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $parentId = null;

    /**
     * @var integer
     */
    private $sort = null;

    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return NavMenu
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set pageId
     *
     * @param integer $pageId
     * @return NavMenu
     */
    public function setPageId($pageId)
    {
        $this->pageId = $pageId;
    
        return $this;
    }

    /**
     * Get pageId
     *
     * @return integer 
     */
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return NavMenu
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
     * Set parentId
     *
     * @param integer $parentId
     * @return NavMenu
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return NavMenu
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
    
        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }
    
    public function getChildren() {
        return $this->children;
    }
    
    public function setChildren( $children )
    {
        $this->children[] = $children;
    
        return $this;
    }


}
