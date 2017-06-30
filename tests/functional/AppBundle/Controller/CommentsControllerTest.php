<?php

namespace Tests\AppBundle\Controller;

use Tests\Functional\AppBundle\Controller\ApiTest;

class CommentsControllerTest extends ApiTest
{

    public function testCreateComment()
    {
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);

        $data = array(
            'form_comment'=>array(
                'title'=>'Comment title',
                'description'=>'Comment description'
            )
        );
        $this->client->request('POST', '/api/v1/recipes/1/comments',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(201, 201);
    }

    public function testCreateCommentMalformedForm()
    {
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);

        $data = array(
            'form_comment'=>array(
                'title'=>null,
                'description'=>'Comment description'
            )
        );
        $this->client->request('POST', '/api/v1/recipes/1/comments',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(400, 400);
    }

    public function testCreateCommentRecipeNotFound()
    {
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);

        $data = array(
            'form_comment'=>array(
                'title'=>'Comment title',
                'description'=>'Comment description'
            )
        );
        $this->client->request('POST', '/api/v1/recipes/100/comments',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Bearer %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testCreateCommentUnAuthorizedUser()
    {
        $this->client->request('POST', '/api/v1/users/auth', array(
            'login_form' => array(
                'email' => 'test@gmail.com',
                'password' => 'token'
            )));
        $response = $this->client->getResponse();
        $token = substr($response->getContent(),10);
        $token = substr($token,0,-2);

        $data = array(
            'form_comment'=>array(
                'title'=>'Comment title',
                'description'=>'Comment description'
            )
        );
        $this->client->request('POST', '/api/v1/recipes/1/comments',$data,[], [], ['HTTP_AUTHORIZATION' =>  sprintf('Malformed header %s', $token)]);
        $response = $this->client->getResponse();
        $this->assertEquals(401, $response->getStatusCode());
    }
}
