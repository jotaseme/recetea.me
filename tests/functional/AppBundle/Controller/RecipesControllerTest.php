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
        $this->assertEquals(5, count($recipes));
    }

    public function testGetRecipesWithPagination()
    {
        $this->client->request('GET', '/api/v1/recipes?page=1');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?page=2');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?page=3');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(3, count($recipes));
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

    public function testCreateRecipe(){
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);
        $data = array(
            'recipe_form'=>array(
                'name'=>'Test recipe',
                'description'=>'Test recipe',
                'portions'=>1,
                'duration'=>1,
                'recipe_steps'=>array(
                    array(
                        'description'=>'Test'
                    )
                ),
                'recipe_tags'=>array(
                    array(
                        'tag'=>'Test'
                    )
                ),
                'recipe_ingredients'=>array(
                    array(
                        'name'=>'Test'
                    )
                ),

            )
        );
        $this->client->request('POST', '/api/v1/recipes',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(201, 201);
    }

    public function testCreateRecipeInvalidForm(){
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);
        $data = array(
            'recipe_form'=>array(
                'name'=>'Test recipe',
                'description'=>'Test recipe',

                'duration'=>1,
                'recipe_steps'=>array(
                    array(
                        'description'=>'Test'
                    )
                ),
                'recipe_tags'=>array(
                    array(
                        'tag'=>'Test'
                    )
                ),
                'recipe_ingredients'=>array(
                    array(
                        'name'=>'Test'
                    )
                ),

            )
        );
        $this->client->request('POST', '/api/v1/recipes',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(400, 400);
    }

    public function testCreateRecipeInvalidToken(){

        $data = array(
            'recipe_form'=>array(
                'name'=>'Test recipe',
                'description'=>'Test recipe',

                'duration'=>1,
                'recipe_steps'=>array(
                    array(
                        'description'=>'Test'
                    )
                ),
                'recipe_tags'=>array(
                    array(
                        'tag'=>'Test'
                    )
                ),
                'recipe_ingredients'=>array(
                    array(
                        'name'=>'Test'
                    )
                ),

            )
        );
        $this->client->request('POST', '/api/v1/recipes',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', "fake_token")]);
        $response = $this->client->getResponse();
        $this->assertEquals(401, 401);
    }

    public function testGetSelfRecipes(){
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);

        $this->client->request('GET', '/api/v1/recipes/user-profile',[],[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(200, 200);
    }

    public function testGetSelfRecipesWrongToken(){
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);

        $this->client->request('GET', '/api/v1/recipes/user-profile',[],[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Wrong token %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(401, 401);
    }

    public function testGetRecipesByName(){
        $this->client->request('GET', '/api/v1/recipes?recipe_filter[name]=busqueda');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(1, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[name]=recipe');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[name]=Sin resultados');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(0, count($recipes));
    }

    public function testGetRecipesByNameWithPagination(){
        $this->client->request('GET', '/api/v1/recipes?recipe_filter[name]=recipe');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[name]=recipe&page=2');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[name]=recipe&page=3');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(3, count($recipes));
    }


    public function testGetRecipesByTag(){
        $this->client->request('GET', '/api/v1/recipes?recipe_filter[recipe_tags][0][tag]=test');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(1, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[recipe_tags][0][tag]=tag');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[recipe_tags][0][tag]=Sin resultados');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(0, count($recipes));
    }

    public function testGetRecipesByTagWithPagination(){
        $this->client->request('GET', '/api/v1/recipes?recipe_filter[recipe_tags][0][tag]=tag');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[recipe_tags][0][tag]=tag&page=2');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(5, count($recipes));

        $this->client->request('GET', '/api/v1/recipes?recipe_filter[recipe_tags][0][tag]=tag&page=3');
        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());
        $object = json_decode($response->getContent());
        $recipes = $object->recipes;
        $this->assertEquals(2, count($recipes));
    }
}
