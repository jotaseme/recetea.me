<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserShoppingList
 *
 * @ORM\Table(name="user_shopping_list", indexes={@ORM\Index(name="fk_user_shopping_list_idx", columns={"id_user"}), @ORM\Index(name="fk_ingredient_shopping_list_idx", columns={"id_ingredient"})})
 * @ORM\Entity
 */
class UserShoppingList
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_shopping_list", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idShoppingList;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_recipe", type="integer", nullable=true)
     */
    private $idRecipe;

    /**
     * @var string
     *
     * @ORM\Column(name="recipe_name", type="string", length=100, nullable=true)
     */
    private $recipeName;

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
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;



    /**
     * Get idShoppingList
     *
     * @return integer
     */
    public function getIdShoppingList()
    {
        return $this->idShoppingList;
    }

    /**
     * Set idRecipe
     *
     * @param integer $idRecipe
     *
     * @return UserShoppingList
     */
    public function setIdRecipe($idRecipe)
    {
        $this->idRecipe = $idRecipe;

        return $this;
    }

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
     * Set recipeName
     *
     * @param string $recipeName
     *
     * @return UserShoppingList
     */
    public function setRecipeName($recipeName)
    {
        $this->recipeName = $recipeName;

        return $this;
    }

    /**
     * Get recipeName
     *
     * @return string
     */
    public function getRecipeName()
    {
        return $this->recipeName;
    }

    /**
     * Set idIngredient
     *
     * @param \AppBundle\Entity\Ingredient $idIngredient
     *
     * @return UserShoppingList
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
     * Set idUser
     *
     * @param \AppBundle\Entity\User $idUser
     *
     * @return UserShoppingList
     */
    public function setIdUser(\AppBundle\Entity\User $idUser = null)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }
}
