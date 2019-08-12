<?php

namespace Tests\Feature;

use App\Model\Task;
use App\Model\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TasksTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_get_all_tasks(): void
    {
        $tasks = factory(Task::class, 3)->create();
        $response = $this->json('GET', 'api/v1/tasks');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'links',
                'meta',
                'data',
            ]);

        $apiData = json_decode($response->getContent(), false);
        $this->assertEquals($tasks[0]->number, $apiData->data[0]->number);
        $this->assertCount(3, $apiData->data);
    }

    /** @test */
    public function it_can_see_if_a_task_is_unlocked(): void
    {
        $tasks = factory(Task::class, 2)->create();
        $team = factory(Team::class)->create();

        $team->tasks()->attach($tasks[0], ['is_done' => false]);

        $response = $this->json('GET', 'api/v1/tasks');
        $response->assertStatus(200);

        $apiData = json_decode($response->getContent(), false);
        $this->assertFalse($apiData->data[0]->locked);
        $this->assertTrue($apiData->data[1]->locked);
    }

    /** @test */
    public function it_can_see_if_a_task_is_done(): void
    {
        $tasks = factory(Task::class, 2)->create();
        $team = factory(Team::class)->create();

        $team->tasks()->attach($tasks[0], ['is_done' => true]);

        $response = $this->json('GET', 'api/v1/tasks');
        $response->assertStatus(200);

        $apiData = json_decode($response->getContent(), false);

        $this->assertTrue($apiData->data[0]->done);
        $this->assertFalse($apiData->data[1]->done);
    }

    /** @test */
    public function it_can_show_one_task(): void
    {
        $task = factory(Task::class)->create();
        $response = $this->json('GET', 'api/v1/tasks/' . $task->id);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
            ]);

        $apiData = json_decode($response->getContent(), false);
        $this->assertEquals($task->number, $apiData->data->number);
    }
}
