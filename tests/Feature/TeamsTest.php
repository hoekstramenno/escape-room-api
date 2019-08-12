<?php

namespace Tests\Feature;

use App\Model\Task;
use App\Model\Team;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TeamsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_get_all_teams(): void
    {
        $teams = factory(Team::class, 3)->create();
        $response = $this->json('GET', 'api/v1/teams');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
            ]);

        $apiData = json_decode($response->getContent(), false);
        $this->assertEquals($teams[0]->name, $apiData->data[0]->name);
        $this->assertCount(3, $apiData->data);
    }

    /** @test */
    public function it_can_show_one_team(): void
    {
        $team = factory(Team::class)->create();
        $response = $this->json('GET', 'api/v1/teams', ['team' => $team]);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'current_page',
                'data',
            ]);

        $apiData = json_decode($response->getContent(), false);
        $this->assertEquals($team->name, $apiData->data[0]->name);
    }
}
