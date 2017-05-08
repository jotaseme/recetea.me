<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecipeComments
 *
 * @ORM\Table(name="recipe_comments", indexes={@ORM\Index(name="fk_recipe_comments_idx", columns={"id_recipe"}), @ORM\Index(name="fk_comment_idx", columns={"id_comment"})})
 * @ORM\Entity
 */
class RecipeComments
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_recipe_comments", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRecipeComments;

    /**
     * @var \Comment
     *
     * @ORM\ManyToOne(targetEntity="Comment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_comment", referencedColumnName="id_comment")
     * })
     */
    private $idComment;

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
     * Get idRecipeComments
     *
     * @return integer
     */
    public function getIdRecipeComments()
    {
        return $this->idRecipeComments;
    }

    /**
     * Set idComment
     *
     * @param \AppBundle\Entity\Comment $idComment
     *
     * @return RecipeComments
     */
    public function setIdComment(\AppBundle\Entity\Comment $idComment = null)
    {
        $this->idComment = $idComment;

        return $this;
    }

    /**
     * Get idComment
     *
     * @return \AppBundle\Entity\Comment
     */
    public function getIdComment()
    {
        return $this->idComment;
    }

    /**
     * Set idRecipe
     *
     * @param \AppBundle\Entity\Recipe $idRecipe
     *
     * @return RecipeComments
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
