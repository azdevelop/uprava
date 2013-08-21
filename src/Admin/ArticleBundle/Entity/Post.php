<?php

namespace Admin\ArticleBundle\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="Admin\ArticleBundle\Entity\PostRepository")
 */
class Post implements Translatable
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

   /**
     * @var string $name
     * @Gedmo\Slug(fields={"title"}, separator="-", unique=true, updatable=false)
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $title
     * @Gedmo\Translatable
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var integer
     * 
     * @ORM\Column(name="user_id", type="string", length=255)
     */
    private $userId;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $createdDate;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable
     * @ORM\Column(type="datetime")
     */
    private $modifiedDate;

    /**
     * @var string $content
     * @Gedmo\Translatable
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @var string $status
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var string $postType
     *
     * @ORM\Column(name="post_type", type="string", length=255)
     */
    private $postType;

    /**
     * 
     * @ORM\ManyToMany(targetEntity="\Admin\CategoryBundle\Entity\Category", inversedBy="posts" , cascade={"persist", "detach"})
     * @ORM\JoinTable(
     *          joinColumns={@ORM\JoinColumn(onDelete="CASCADE")},
     *          inverseJoinColumns={@ORM\JoinColumn(onDelete="CASCADE")}
     * )
     */
    protected $categories;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    private $locale;
    
    public function __construct(){
        $this->categories = new \Doctrine\Common\Collections\ArrayCollection();
    }

    
    public function getCategories() {
        return $this->categories;
    }

    public function setCategories(\Doctrine\Common\Collections\ArrayCollection $categories) {
        $this->categories = $categories;
        return $this;
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
     * @return Post
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
     * @return Post
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
     * Set userId
     *
     * @param integer $userId
     * @return Post
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return Post
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;
    
        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime 
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set modifiedDate
     *
     * @param \DateTime $modifiedDate
     * @return Post
     */
    public function setModifiedDate($modifiedDate)
    {
        $this->modifiedDate = $modifiedDate;
    
        return $this;
    }

    /**
     * Get modifiedDate
     *
     * @return \DateTime 
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;
    
        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Post
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set postType
     *
     * @param string $postType
     * @return Post
     */
    public function setPostType($postType)
    {
        $this->postType = $postType;
    
        return $this;
    }

    /**
     * Get postType
     *
     * @return string 
     */
    public function getPostType()
    {
        return $this->postType;
    }

    /**
     * Add category
     *
     * @param \Admin\CategoryBundle\Entity\Category $category
     * @return Post
     */
    public function addCategory(\Admin\CategoryBundle\Entity\Category $category)
    {
        $this->categories[] = $category;
    
        return $this;
    }

    /**
     * Remove category
     *
     * @param \Admin\CategoryBundle\Entity\Category $category
     */
    public function removeCategory(\Admin\CategoryBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    public function hasCategory(\Admin\CategoryBundle\Entity\Category $category)
    {
        return $this->getCategories()->contains( $category );
    }

   
    
     /**
     * Set locale for translation
     *  @param string
     *  @return Post
     */
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
    
    

}