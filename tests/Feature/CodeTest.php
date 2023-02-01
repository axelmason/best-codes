<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\FixturesTrait;
use Symfony\Component\HttpFoundation\Response;

class CodeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testCreate()
    {
        $data = $this->getFixture('create_code_request.json');

        $response = $this->json('post', '/api/codes', json_decode($data, true));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEqualFixtures('create_code_response.json', $response->json());
        $this->assertDatabaseHas('codes', [
           "id" => 3
        ]);
    }

    public function testGet()
    {
        $response = $this->json('get', '/api/codes');

        $response->assertStatus(Response::HTTP_OK);

        $this->assertEqualFixtures('get_codes.json', $response->json());
    }
}
