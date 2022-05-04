<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PredictionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'teamId' => $this['team_id'],
            'teamName' => $this['team_name'],
            'percentage' => $this['percentage'] ?? 0,
            'raw' => $this['raw_prediction'] ?? 0,
        ];
    }
}
