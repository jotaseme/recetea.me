<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeSteps
 *
 * @ORM\Table(name="recipe_steps", indexes={@ORM\Index(name="fk_recipe_steps_idx", columns={"id_recipe"})})
 * @ORM\Entity
 */
class RecipeSteps
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_recipe_steps", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecipeSteps;

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
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=65535, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="step_order", type="integer", nullable=true)
     */
    private $stepOrder;

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
     * Get idRecipeSteps
     *
     * @return integer
     */
    public function getIdRecipeSteps()
    {
        return $this->idRecipeSteps;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return RecipeSteps
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
     * @return RecipeSteps
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
     * Set description
     *
     * @param string $description
     *
     * @return RecipeSteps
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
     * Set stepOrder
     *
     * @param integer $stepOrder
     *
     * @return RecipeSteps
     */
    public function setStepOrder($stepOrder)
    {
        $this->stepOrder = $stepOrder;

        return $this;
    }

    /**
     * Get stepOrder
     *
     * @return integer
     */
    public function getStepOrder()
    {
        return $this->stepOrder;
    }

    /**
     * Set idRecipe
     *
     * @param \AppBundle\Entity\Recipe $idRecipe
     *
     * @return RecipeSteps
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
