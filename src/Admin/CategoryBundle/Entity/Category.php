<?php

namespace Admin\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    

    /**
     * @var \Admin\CategoryBundle\Entity\Category
     */
    private $parentId;

    /**
     * Constructor
     */
    public function __construct()
    {
        
    }
    
    public function __toString(){
        return (string) $this->getTitle();
    }

    
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
     * Set name
     *
     * @param string $name
     * @return Category
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
     * Set title
     *
     * @param string $title
     * @return Category
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Category
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    

    
    /**
     * Set parentId
     *
     * @param \Admin\CategoryBundle\Entity\Category $parentId
     * @return Category
     */
    public function setParentId(\Admin\CategoryBundle\Entity\Category $parentId = null)
    {
        $this->parentId = $parentId;
    
        return $this;
    }

    /**
     * Get parentId
     *
     * @return \Admin\CategoryBundle\Entity\Category 
     */
    public function getParentId()
    {
        return $this->parentId;
    }
}
