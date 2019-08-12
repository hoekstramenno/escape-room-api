<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subcamp' => $this->subcamp,
            'points' => $this->points,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'api_tokens' => new ApiTokenCollection($this->whenLoaded('api_tokens')),
            'tasks' => new TaskCollection($this->whenLoaded('tasks'))
        ];
    }
}
