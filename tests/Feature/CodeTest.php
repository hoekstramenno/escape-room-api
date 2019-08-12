<?php

namespace Tests\Feature;

use App\Model\Task;
use App\Model\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CodeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_validate_a_code_submit(): void
    {
        $task = factory(Task::class)->create();
        $response = $this->json('POST', 'api/v1/tasks/validate', [
            'number' => $task->number,
            'code' => 123,
            'icon' => 'trangle',
        ]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'currentPoints',
                'validate',
                'next',
            ]]);

        $apiData = json_decode($response->getContent(), false);
        $this->assertTrue($apiData->data->validate);
        $this->assertEquals($task->number+1, $apiData->data->next);
        $this->assertEquals(10, $apiData->data->currentPoints);

    }

    /** @test */
    public function it_returns_not_validated_when_arguments_are_missing(): void
    {
        $response = $this->json('POST', 'api/v1/tasks/validate');
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data' => [
                'currentPoints',
                'validate',
                'next',
            ]]);

        $apiData = json_decode($response->getContent(), false);
        $this->assertFalse($apiData->data->validate);
        $this->assertNull($apiData->data->next);
        $this->assertEquals(0, $apiData->data->currentPoints);
    }
}
