<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\JsonResource;

class StandingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'points' => $this->points ?? 0,
            'played' => $this->played ?? 0,
            'won' => $this->won ?? 0,
            'draw' => $this->draw ?? 0,
            'lost' => $this->lost ?? 0,
            'gd' => $this->goal_difference ?? 0,
        ];
    }
}
