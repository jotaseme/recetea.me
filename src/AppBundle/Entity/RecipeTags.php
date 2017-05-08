<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeTags
 *
 * @ORM\Table(name="recipe_tags", indexes={@ORM\Index(name="fk_recipe_idx", columns={"id_recipe"})})
 * @ORM\Entity
 */
class RecipeTags
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_recipe_tags", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecipeTags;

    /**
     * @var string
     *
     * @ORM\Column(name="tag", type="string", length=45, nullable=true)
     */
    private $tag;

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
     * @var \Recipe
     *
     * @ORM\ManyToOne(targetEntity="Recipe")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_recipe", referencedColumnName="id_recipe")
     * })
     */
    private $idRecipe;



    /**
     * Get idRecipeTags
     *
     * @return integer
     */
    public function getIdRecipeTags()
    {
        return $this->idRecipeTags;
    }

    /**
     * Set tag
     *
     * @param string $tag
     *
     * @return RecipeTags
     */
    public function setTag($tag)
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * Get tag
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return RecipeTags
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
     * @return RecipeTags
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
     * Set idRecipe
     *
     * @param \AppBundle\Entity\Recipe $idRecipe
     *
     * @return RecipeTags
     */
    public function setIdRecipe(\AppBundle\Entity\Recipe $idRecipe = null)
    {
        $this->idRecipe = $idRecipe;

        return $this;
    }

    /**
     * Get idRecipe
     *
     * @return \AppBundle\Entity\Recipe
     */
    public function getIdRecipe()
    {
        return $this->idRecipe;
    }
}
