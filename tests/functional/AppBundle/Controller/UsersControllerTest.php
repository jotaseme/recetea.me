<?php

namespace Tests\AppBundle\Controller;

use Tests\Functional\AppBundle\Controller\ApiTest;

class UsersControllerTest extends ApiTest
{

    public function testCreateUser()
    {
        $this->client->request('POST', '/api/v1/users', array(
            'user_form' => array(
                'name'  => 'Jose Maria',
                'email' => 'test1@gmail.com',
                'password' => 'test'
            )));
        $response = $this->client->getResponse();
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testCreateUserWithEmptyName()
    {
        $this->client->request('POST', '/api/v1/users', array(
            'user_form' => array(
                'name'  => null,
                'email' => 'test2@gmail.com',
                'password' => 'test'
            )));
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testCreateUserWithEmptyPassword()
    {
        $this->client->request('POST', '/api/v1/users', array(
            'user_form' => array(
                'name'  => 'Jose Maria',
                'email' => 'test2@gmail.com',
                'password' => null
            )));
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testCreateUserWithMalformedEmail()
    {
        $this->client->request('POST', '/api/v1/users', array(
            'user_form' => array(
                'name'  => 'Jose Maria',
                'email' => 'test2',
                'password' => 'test'
            )));
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

    public function testCreateUserWithExistingEmail()
    {
        $this->client->request('POST', '/api/v1/users', array(
            'user_form' => array(
                'name'  => 'Jose Maria',
                'email' => 'test1@gmail.com',
                'password' => 'test'
            )));
        $response = $this->client->getResponse();
        $this->assertEquals(400, $response->getStatusCode());
        $this->assertJson($response->getContent());
    }

}
