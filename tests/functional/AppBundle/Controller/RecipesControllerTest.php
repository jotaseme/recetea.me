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
        $object = \GuzzleHttp\json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));
    }

    public function testGetRecipesWithPagination()
    {
        $this->client->request('GET', '/api/v1/recipes?page=1');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = \GuzzleHttp\json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?page=2');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = \GuzzleHttp\json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?page=3');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = \GuzzleHttp\json_decode($response->getContent());
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
}
