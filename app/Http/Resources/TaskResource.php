<?php

namespace App\Http\Resources;

use App\Model\ApiToken;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $token = $request->bearerToken();
        $token = ApiToken::with('team.tasks')
                         ->where('token', $token)
                         ->whereDate('active_until', '>', date('Y-m-d H:i:s'))
                         ->first();

        $taskTeam = $this->teams()->wherePivot('team_id', $token->team->id)->first();

        if ($taskTeam !== null) {
            $isDone = ((bool)$taskTeam->pivot->is_done);
        }

        return [
            'id'         => $this->id,
            'number'     => $this->number,
            'task'       => $this->task,
            'location'   => $this->location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'locked'     => $this->teams->contains($token->team->id) === false,
            'done'       => $isDone ?? false,
        ];
    }
}
