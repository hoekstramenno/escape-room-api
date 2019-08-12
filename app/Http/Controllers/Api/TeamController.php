<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\ApiToken;
use App\Model\Task;
use App\Model\Team;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    public function register(Request $registrationRequest)
    {
        $validator = Validator::make($registrationRequest->all(), [
            'teamName'           => 'required',
            'subCamp'            => 'required',
            'groupNumber'        => 'required',
            'authenticationHash' => 'required',
        ]);

        if ($validator->fails()) {
            return [
                'data' => $validator->errors()->toArray(),
            ];
        }

        $team = Team::create([
            'name'      => $registrationRequest->get('teamName'),
            'subcamp'   => $registrationRequest->get('subCamp'),
            'number'    => $registrationRequest->get('groupNumber'),
            'points'    => 0,
            'is_active' => true,
        ]);

        $token = ApiToken::create([
            'token'        => $registrationRequest->get('authenticationHash'),
            'active_until' => new DateTime('tomorrow'),
            'team_id' => $team->id
        ]);

        $task = Task::where('number', 1)->first();

        $team->tasks()->attach($task->id, ['is_done' => false]);

        $team = $team->fresh();

        return [
            'message' => true,
            'data'    => [
                'user' => [
                    'id' => $team->id,
                    'number' => $team->number,
                    'subcamp' => $team->subcamp,
                    'token' => $token->token
                ]
            ],
        ];
    }

}
