<?php

namespace Tests\AppBundle\Controller;

use Tests\Functional\AppBundle\Controller\ApiTest;

class RecipesControllerTest extends ApiTest
{
    protected function setUp(){
        parent::setUp();
    }

    public function testGetRecipes()
    {
        $this->client->request('GET', '/api/v1/recipes');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));
    }

    public function testGetRecipesWithPagination()
    {
        $this->client->request('GET', '/api/v1/recipes?page=1');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?page=2');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?page=3');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(1, count($recipes));
    }

    public function testGetRecipesContent()
    {
        $this->client->request('GET', '/api/v1/recipes');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;

        $this->assertObjectHasAttribute('name', $recipes[0]);
        $this->assertObjectHasAttribute('description', $recipes[0]);
        $this->assertObjectHasAttribute('image', $recipes[0]);
        $this->assertObjectHasAttribute('recipe_tags', $recipes[0]);
    }

    public function testShowRecipe(){
        $this->client->request('GET', '/api/v1/recipes/1');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals(1, count(json_decode($response->getContent())));
    }

    public function testShowRecipeContent(){
        $this->client->request('GET', '/api/v1/recipes/1');
        $response = $this->client->getResponse();
        $recipe = json_decode($response->getContent());
        $this->assertObjectHasAttribute('name', $recipe);
        $this->assertObjectHasAttribute('description', $recipe);
        $this->assertObjectHasAttribute('image', $recipe);
        $this->assertObjectHasAttribute('recipe_tags', $recipe);
        $this->assertObjectHasAttribute('recipe_steps', $recipe);
        $this->assertObjectHasAttribute('recipe_ingredients', $recipe);
    }

    public function testShowRecipeResourceNotFound()
    {
        $this->client->request('GET', '/api/v1/recipes/100');
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testShowRecipeRandomly(){
        $this->client->request('GET', '/api/v1/recipes/random');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $this->assertEquals(1, count(json_decode($response->getContent())));
    }

    public function testShowRecipeRandomlyContent(){
        $this->client->request('GET', '/api/v1/recipes/random');
        $response = $this->client->getResponse();
        $recipe = json_decode($response->getContent());

        $this->assertObjectHasAttribute('name', $recipe[0]);
        $this->assertObjectHasAttribute('duration', $recipe[0]);
        $this->assertObjectHasAttribute('portions', $recipe[0]);
        $this->assertObjectHasAttribute('image', $recipe[0]);
    }
}
