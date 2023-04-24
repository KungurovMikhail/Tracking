<?php

namespace App\Tests\Controller;

use App\Tests\AbstractControllerTest;

class ReportEmployeeControllerTest extends AbstractControllerTest
{
    public function testList(): void
    {
        $this->createAndFlushUsers();

        $this->client->request('GET', '/api/v1/list_employee');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'array',
            'items' => [
                'type' => 'object',
                'required' => ['id', 'name'],
                'properties' => [
                    'name' => ['type' => 'string'],
                    'id' => ['type' => 'integer'],
                ],
            ],
        ]);
    }

    public function testReport(): void
    {
        $this->createAndFlushUsers();

        $this->client->request('GET', '/api/v1/report');
        $responseContent = json_decode($this->client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertJsonDocumentMatchesSchema($responseContent, [
            'type' => 'object',
            'required' => ['reports'],
            'properties' => [
                'reports' => [
                    'type' => 'array',
                    'items' => [
                        'type' => 'object',
                        'required' => ['name', 'perWeekHours'],
                        'properties' => [
                            'name' => ['type' => 'string'],
                            'perWeekHours' => [
                                'type' => ['array', 'object'],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }

    private function createAndFlushUsers(): void
    {
        for ($i = 0; $i < 10; $i++) {
            $user = $this->createUsers();

            $this->em->persist($user);
        }
        $this->em->flush();
    }
}
