<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recipe
 *
 * @ORM\Table(name="recipe", indexes={@ORM\Index(name="fk_category_idx", columns={"id_category"}), @ORM\Index(name="fk_user_idx", columns={"created_by"})})
 * @ORM\Entity
 */
class Recipe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_recipe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecipe;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ingredients", type="integer", nullable=true)
     */
    private $ingredients;

    /**
     * @var integer
     *
     * @ORM\Column(name="tags", type="integer", nullable=true)
     */
    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="duration", type="string", length=45, nullable=true)
     */
    private $duration;

    /**
     * @var integer
     *
     * @ORM\Column(name="steps", type="integer", nullable=true)
     */
    private $steps;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=true)
     */
    private $active;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=100, nullable=true)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="portions", type="string", length=100, nullable=true)
     */
    private $portions;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_category", referencedColumnName="id_category")
     * })
     */
    private $idCategory;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id_user")
     * })
     */
    private $createdBy;



    /**
     * Get idRecipe
     *
     * @return integer
     */
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
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
     * Set description
     *
     * @param string $description
     *
     * @return Recipe
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
     * Set ingredients
     *
     * @param integer $ingredients
     *
     * @return Recipe
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    /**
     * Get ingredients
     *
     * @return integer
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * Set tags
     *
     * @param integer $tags
     *
     * @return Recipe
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return integer
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set duration
     *
     * @param string $duration
     *
     * @return Recipe
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return string
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set steps
     *
     * @param integer $steps
     *
     * @return Recipe
     */
    public function setSteps($steps)
    {
        $this->steps = $steps;

        return $this;
    }

    /**
     * Get steps
     *
     * @return integer
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Recipe
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Recipe
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set portions
     *
     * @param string $portions
     *
     * @return Recipe
     */
    public function setPortions($portions)
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * Get portions
     *
     * @return string
     */
    public function getPortions()
    {
        return $this->portions;
    }

    /**
     * Set idCategory
     *
     * @param \AppBundle\Entity\Category $idCategory
     *
     * @return Recipe
     */
    public function setIdCategory(\AppBundle\Entity\Category $idCategory = null)
    {
        $this->idCategory = $idCategory;

        return $this;
    }

    /**
     * Get idCategory
     *
     * @return \AppBundle\Entity\Category
     */
    public function getIdCategory()
    {
        return $this->idCategory;
    }

    /**
     * Set createdBy
     *
     * @param \AppBundle\Entity\User $createdBy
     *
     * @return Recipe
     */
    public function setCreatedBy(\AppBundle\Entity\User $createdBy = null)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return \AppBundle\Entity\User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}
