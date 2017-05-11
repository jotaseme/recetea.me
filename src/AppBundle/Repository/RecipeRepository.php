<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class RecipeRepository extends EntityRepository
{
    public function findRecipesByRootCategory($id_category)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT r FROM AppBundle:Recipe r
                      JOIN AppBundle:Category c0 WITH r.idCategory=c0.idCategory
                      JOIN AppBundle:Category c1 WITH c0.idParent = c1.idCategory
                      JOIN AppBundle:Category c2 WITH c1.idParent = c2.idCategory
                      WHERE c2.idCategory = '.$id_category
            )
            ->getResult();
    }
}