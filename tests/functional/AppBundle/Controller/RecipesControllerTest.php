<?php

namespace Tests\AppBundle\Controller;

use Tests\Functional\AppBundle\Controller\ApiTest;

class RecipesControllerTest extends ApiTest
{
    const TOKEN = 'eyJhbGciOiJSUzI1NiJ9.eyJ1c2VybmFtZSI6ImpvdGFlbWVtb3Jlbm9AZ21haWwuY29tIiwiZXhwIjoxNTM0NzM4MDQwLCJpYXQiOjE0OTg3MzgwNDB9.J81T-ZYa-PEI8C-HGqE_0nlnz5cVzsM3dZKqotaAGBf0VLMrzGX4WU8V0QVkpQtcumzQSoAIZqWkgRHGCAbLcUL8nVor5Uw0wEB9vi6csFTeWDW2SsOR3I0Mm0HyoetCrS06AH2l4zGxl8YOLKlakghjPxaMuIhHPFTvCuUcJAujTbjbjTUzg2FCvIyTQwRY_Enke8PWk_lfrYmyumYYydmHZJhlUVEthwiCmUcEY4gmzlf8_Oi78A03iK4A8zCIrxa85bTQPp4mJoSvmId7XVF14ncyDtNLoaY6ze5tFSdhhBFOHBsY_yhVTbAnTtpbMI3GvONnrAcmOz525kkQIwL0TzIQ_1L19lE5OvOsj8H9P1rP6IHgB7Fu6QLD4M07bPZuGiAsBIETRIu8wxZmYI9sDRmFT-cc3HOQe9i3_378DpKgnV8oKzLG4_WQaQCrnP2yv4sTpRDkL82UmRNVz8WZEjeJRKEMQbfmB1gG_9IypBjmevZ5rvxOp8HWLwYnS6l-x-9imSqD5E01-MzXL_KEeI1WuElfH_2O73KKOIzOex_zchnrpitguinu8eIeQ_xFj_obStr0U0e6nfu5QIyuL3bVaEE14YgKTH81acPo_0hHM4TvyfMuR1vaZdZlBMg96cCa9DQGDqwJaE_y_3GfQ2eAQd58_dLgIA_93Ag';

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
        //var_dump($response->getContent());die;
        $this->assertEquals(201, $response->getStatusCode());
        //var_dump($response->getContent());die;
    }


}
