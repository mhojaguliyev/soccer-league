<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MatchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'homeTeamId' => $this->home_team_id,
            'homeTeamName' => $this->homeTeam->name,
            'awayTeamId' => $this->away_team_id,
            'awayTeamName' => $this->awayTeam->name,
            'homeGoal' => $this->home_goal ?? null,
            'awayGoal' => $this->away_goal ?? null,
            'winnerId' => $this->winner_id ?? null,
        ];
    }
}
