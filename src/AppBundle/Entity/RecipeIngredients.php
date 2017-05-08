<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeIngredients
 *
 * @ORM\Table(name="recipe_ingredients", indexes={@ORM\Index(name="fk_recipe_idx", columns={"id_recipe"}), @ORM\Index(name="fk_ingredient_idx", columns={"id_ingredient"})})
 * @ORM\Entity
 */
class RecipeIngredients
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_recipe_ingredients", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecipeIngredients;

    /**
     * @var string
     *
     * @ORM\Column(name="quantity", type="string", length=45, nullable=true)
     */
    private $quantity;

    /**
     * @var \Ingredient
     *
     * @ORM\ManyToOne(targetEntity="Ingredient")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_ingredient", referencedColumnName="id_ingredient")
     * })
     */
    private $idIngredient;

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
     * Get idRecipeIngredients
     *
     * @return integer
     */
    public function getIdRecipeIngredients()
    {
        return $this->idRecipeIngredients;
    }

    /**
     * Set quantity
     *
     * @param string $quantity
     *
     * @return RecipeIngredients
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set idIngredient
     *
     * @param \AppBundle\Entity\Ingredient $idIngredient
     *
     * @return RecipeIngredients
     */
    public function setIdIngredient(\AppBundle\Entity\Ingredient $idIngredient = null)
    {
        $this->idIngredient = $idIngredient;

        return $this;
    }

    /**
     * Get idIngredient
     *
     * @return \AppBundle\Entity\Ingredient
     */
    public function getIdIngredient()
    {
        return $this->idIngredient;
    }

    /**
     * Set idRecipe
     *
     * @param \AppBundle\Entity\Recipe $idRecipe
     *
     * @return RecipeIngredients
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
