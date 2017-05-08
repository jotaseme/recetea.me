<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeTags
 *
 * @ORM\Table(name="recipe_tags", indexes={@ORM\Index(name="fk_recipe_idx", columns={"id_recipe"}), @ORM\Index(name="id_tag_idx", columns={"id_tag"})})
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
     * @var \Tag
     *
     * @ORM\ManyToOne(targetEntity="Tag")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_tag", referencedColumnName="id_tag")
     * })
     */
    private $idTag;

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
     * Set idTag
     *
     * @param \AppBundle\Entity\Tag $idTag
     *
     * @return RecipeTags
     */
    public function setIdTag(\AppBundle\Entity\Tag $idTag = null)
    {
        $this->idTag = $idTag;

        return $this;
    }

    /**
     * Get idTag
     *
     * @return \AppBundle\Entity\Tag
     */
    public function getIdTag()
    {
        return $this->idTag;
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
