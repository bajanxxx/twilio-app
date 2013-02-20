<?php

namespace App\Test\Controller;

use App\Test\TestCase;

class RolesControllerTest extends TestCase
{


    public function testGETSingular()
    {
        $response = $this->call('GET', '/roles/slug');
        $response = json_decode($response->getContent(), true);

        $this->assertTrue($this->client->getResponse()->isOk());
        $this->assertInternalType('array', $response);
        $this->assertNotSame(null, $response);
        $this->assertArrayHasKey('roles', $response);
    }

	public function testPOSTValidateName()
	{

        $input = [
            'name' => 'x',
            'permissions' => [
                'global' => [
                    'users' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                    'roles' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                    'sites' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                ]
            ]
        ];

        $response = $this->call('POST', '/roles', array(), array(), array(), json_encode($input));

        $response = json_decode($response->getContent(), true);

        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('messages', $response);
	}

	public function testPOSTValidatePermissionBoolean()
	{

        $input = [
            'name' => 'A long enough name',
            'permissions' => [
                'global' => [
                    'users' => [
                        'read'      => 1,
                        'write'     => 'some crazy invalid thinggggs',
                        'delete'    => 1,
                    ],
                    'roles' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                    'sites' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                ]
            ]
        ];

        $response = $this->call('POST', '/roles', array(), array(), array(), json_encode($input));

        $response = json_decode($response->getContent(), true);

        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('messages', $response);
	}

    public function testPOSTWithValidData()
    {

        $input = [
            'name' => 'Admin Role',
            'permissions' => [
                'global' => [
                    'users' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                    'roles' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                    'sites' => [
                        'read'      => 1,
                        'write'     => 1,
                        'delete'    => 1,
                    ],
                ]
            ]
        ];

        $response = $this->call('POST', '/roles', array(), array(), array(), json_encode($input));
        $response = json_decode($response->getContent(), true);
        $this->assertInternalType('array', $response);
        $this->assertArrayHasKey('roles', $response);
    }

}