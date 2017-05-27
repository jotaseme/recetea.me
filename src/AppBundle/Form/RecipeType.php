<?php

namespace AppBundle\Form;

use AppBundle\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
class RecipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('recipe_tags', CollectionType::class, array(
                'entry_type' => TagsType::class,
                'allow_add' => true,
                'by_reference' => false,
            ))
            ->add('description')
            ->add('duration')
            ->add('image')
            ->add('portions')
            ->add('recipe_steps', CollectionType::class, array(
                'entry_type'=>StepsType::class,
                'allow_add'=> true,
                'by_reference' => false,
            ))
            ->add('recipe_ingredients', CollectionType::class, array(
                'entry_type'=>IngredientType::class,
                'allow_add'=> true,
                'by_reference' => false,
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'data_class' => Recipe::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_recipe';
    }


}
