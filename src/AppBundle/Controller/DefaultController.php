<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Ingredient;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipeIngredients;
use AppBundle\Entity\RecipeSteps;
use AppBundle\Entity\RecipeTags;
use AppBundle\Entity\Tag;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Goutte\Client;


ini_set('max_execution_time', 2000000);
ini_set('memory_limit', '-1');

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $now = new \DateTime('now');
        $client = new Client();
        $guzzleClient = new \GuzzleHttp\Client(array('curl' => array(CURLOPT_SSL_VERIFYPEER => false,),));
        $client->setClient($guzzleClient);
        $crawler = $client->request('GET', 'https://www.recetasgratis.net/');
        $categories = $crawler->filter('div.categoria.link.ga a.titulo')->each(function ($node) {
            return $node->text();
        });
        $url_back_categories = "https://www.recetasgratis.net/";
        $aux_counter = 0;
        foreach ($categories as $category_name) {
            if($aux_counter>13){
                $link = $crawler->selectLink($category_name)->link();
                $crawler = $client->click($link);
                $registered_category = $em->getRepository('AppBundle:Category')->findOneBy(array('name' => $category_name));
                if ($registered_category) {
                    $category = $registered_category;
                } else {
                    $category = new Category();
                    $category->setName($category_name);
                    $category->setIsRootCategory(1);
                    $category->setActive(1);
                    $category->setIdParent(0);
                    $category->setCreatedAt($now);
                    $category->setUpdatedAt($now);
                    $em->persist($category);
                    $em->flush();
                }
                $subcategories = $crawler->filter('div.grupo.subgrupo-nivel-1.active a.filtro')->each(function ($node) {
                    return $node->text();
                });
                $url_back_subcategories = $link->getUri();
                foreach ($subcategories as $subcategory_name) {
                    $link = $crawler->selectLink($subcategory_name)->link();
                    $crawler = $client->click($link);
                    $registered_subcategory = $em->getRepository('AppBundle:Category')->findOneBy(array('name' => $subcategory_name));
                    if ($registered_subcategory) {
                        $subcategory = $registered_subcategory;
                    } else {
                        $subcategory = new Category();
                        $subcategory->setName($subcategory_name);
                        $subcategory->setIsRootCategory(0);
                        $subcategory->setActive(1);
                        $subcategory->setIdParent($category->getIdCategory());
                        $subcategory->setCreatedAt($now);
                        $subcategory->setUpdatedAt($now);
                        $em->persist($subcategory);
                        $em->flush($subcategory);
                    }
                    $subsubcategories = $crawler->filter('div.grupo.subgrupo-nivel-2.active a.filtro')->each(function ($node) {
                        return $node->text();
                    });

                    foreach ($subsubcategories as $subsubcategory_name) {
                        $link = $crawler->selectLink($subsubcategory_name)->link();
                        $crawler = $client->click($link);
                        $registered_subsubcategory = $em->getRepository('AppBundle:Category')->findOneBy(array('name' => $subsubcategory_name));
                        if ($registered_subsubcategory) {
                            $subsubcategory = $registered_subsubcategory;
                        } else {
                            $subsubcategory = new Category();
                            $subsubcategory->setName($subsubcategory_name);
                            $subsubcategory->setIsRootCategory(0);
                            $subsubcategory->setActive(1);
                            $subsubcategory->setIdParent($subcategory->getIdCategory());
                            $subsubcategory->setCreatedAt($now);
                            $subsubcategory->setUpdatedAt($now);
                            $em->persist($subsubcategory);
                            $em->flush($subsubcategory);
                        }
                        $recipes = $crawler->filter('div.resultado.link a.titulo.titulo--resultado')->each(function ($node) {
                            return $node->text();
                        });
                        $url_back = $link->getUri();
                        $recipes_counter = 0;
                        foreach ($recipes as $recipe) {
                            $dificultad = $crawler->filter('div.position-imagen div.dif.dif--1')->each(function ($node) {
                                return $node->text();
                            });

                            $link = $crawler->selectLink($recipe)->link();
                            $crawler = $client->click($link);
                            $title = $crawler->filter('h1.titulo.titulo--articulo')->each(function ($node) {
                                return $node->text();
                            });
                            if (sizeof($title) > 0) {

                                $title = $title[0];

                                $user = $crawler->filter('div.autor a.nombre_autor.ga')->each(function ($node) {
                                    return $node->text();
                                });
                                if (sizeof($user) > 0) {
                                    $user = $user[0];
                                    $ingredients = $crawler->filter('div.ingredientes ul.columna li.ingrediente label')->each(function ($node) {
                                        return $node->text();
                                    });

                                    $registered_user = $em->getRepository('AppBundle:User')->findOneBy(array('name' => $user));
                                    if ($registered_user) {
                                        $user = $registered_user;
                                    } else {
                                        $new_user = new User();
                                        $new_user->setName($user);
                                        $new_user->setEmail(str_replace(' ', '', $user) . "@" . str_replace(' ', '', $user) . ".com");
                                        $new_user->setPassword("123456");
                                        $new_user->setCreatedAt($now);
                                        $new_user->setUpdatedAt($now);
                                        $new_user->setActive(1);
                                        $em->persist($new_user);
                                        $em->flush();
                                        $user = $new_user;
                                    }

                                    $description = $crawler->filter('div.intro p')->each(function ($node) {
                                        return $node->text();
                                    });
                                    $recipe_description = "";
                                    foreach ($description as $paragraph) {
                                        $recipe_description .= '<p>' . $paragraph . '</p>';
                                    }
                                    $duration = $crawler->filter('div.p402_premium div.titulo.titulo--h3 span.destacado')->each(function ($node) {
                                        return $node->text();
                                    });

                                    $portions = $crawler->filter('div.titulo.titulo--h3 small')->each(function ($node) {
                                        return $node->text();
                                    });
                                    if (sizeof($duration) > 0) {
                                        $duration = $duration[0];
                                    } else {
                                        $duration = null;

                                    }
                                    if (sizeof($portions) > 0) {
                                        $portions = $portions[0];
                                    } else {
                                        $portions = null;
                                    }
                                    if (strpos($crawler->selectImage($title)->getUri(), 'video') == false) {
                                        if($crawler->selectImage($title)->image()!=null){
                                            $image = $crawler->selectImage($title)->image();
                                            $file = file_get_contents($image->getUri());
                                            $image_name = utf8_decode($recipe);
                                            file_put_contents("image_crawler/$image_name.jpg", $file);
                                            $image_name = "$recipe.jpg";
                                        }

                                    }else{
                                        $image_name=null;
                                    }

                                    $new_recipe = new Recipe();
                                    $new_recipe->setName($recipe);
                                    $new_recipe->setActive(1);
                                    $new_recipe->setDescription($recipe_description);
                                    $new_recipe->setIdCategory($subsubcategory);
                                    $new_recipe->setCreatedBy($user);
                                    $new_recipe->setUpdatedAt($now);
                                    $new_recipe->setCreatedAt($now);
                                    $new_recipe->setPortions($portions);
                                    $new_recipe->setDuration($duration);
                                    $new_recipe->setImage($image_name);
                                    $em->persist($new_recipe);
                                    $em->flush();

                                    $counter = 0;
                                    foreach ($ingredients as $ingredient_name) {
                                        $registered_ingredient = $em->getRepository('AppBundle:Ingredient')->findOneBy(array('name' => $ingredient_name));
                                        if ($registered_ingredient) {
                                            $ingredient = $registered_ingredient;
                                        } else {
                                            $ingredient = new Ingredient();
                                            $ingredient->setName($ingredient_name);
                                            $ingredient->setUpdatedAt($now);
                                            $ingredient->setCreatedAt($now);
                                            $em->persist($ingredient);
                                            $em->flush();
                                        }
                                        $recipe_ingredients = new RecipeIngredients();
                                        $recipe_ingredients->setIdIngredient($ingredient);
                                        //$recipe_ingredients->setQuantity($ingredients_quantity[$counter]);
                                        $recipe_ingredients->setIdRecipe($new_recipe);
                                        $em->persist($recipe_ingredients);
                                        $em->flush();
                                        $counter++;
                                    }

                                    $steps = $crawler->filter('div.p402_premium div.apartado p')->each(function ($node) {
                                        return $node->text();
                                    });
                                    array_pop($steps);
                                    $steps_counter = 1;
                                    foreach ($steps as $step) {
                                        $recipe_step = new RecipeSteps();
                                        $recipe_step->setDescription($step);
                                        $recipe_step->setUpdatedAt($now);
                                        $recipe_step->setCreatedAt($now);
                                        $recipe_step->setStepOrder($steps_counter);
                                        $recipe_step->setIdRecipe($new_recipe);
                                        $em->persist($recipe_step);
                                        $em->flush();
                                        $steps_counter++;
                                    }
                                    $tags = $crawler->filter('div.apartado ul.dos-columnas div.clear  li span strong')->each(function ($node) {
                                        return $node->text();
                                    });
                                    //array_push($tags,$dificultad[$recipes_counter]);
                                    foreach ($tags as $tag_name) {
                                        $registered_tag = $em->getRepository('AppBundle:Tag')->findOneBy(array('name' => $tag_name));
                                        if ($registered_tag) {
                                            $tag = $registered_tag;
                                        } else {
                                            $tag = new Tag();
                                            $tag->setName($tag_name);
                                            $tag->setCreatedAt($now);
                                            $tag->setUpdatedAt($now);
                                            $em->persist($tag);
                                            $em->flush();
                                        }

                                        $recipe_tag = new RecipeTags();
                                        $recipe_tag->setUpdatedAt($now);
                                        $recipe_tag->setCreatedAt($now);
                                        $recipe_tag->setIdRecipe($new_recipe);
                                        $recipe_tag->setIdTag($tag);
                                        $em->persist($recipe_tag);
                                        $em->flush();
                                    }
                                }else {
                                    print_r("Error en el nombre del usuario " . $link->getUri());
                                }
                            }else{
                                print_r("Error en el titulo " . $link->getUri());
                            }
                            $crawler = $client->request('GET', $url_back);
                            $recipes_counter++;
                        }
                    }
                    $crawler = $client->request('GET', $url_back_subcategories);
                }
                $crawler = $client->request('GET', $url_back_categories);
            }
            $aux_counter++;
        }

        die("OK");
    }
}
