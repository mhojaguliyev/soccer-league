<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function standing(): HasOne
    {
        return $this->hasOne(Standing::class);
    }

    public function won(int $gd): void
    {
        $this->updateStanding(1, 0, 0, 3, $gd);
    }

    public function lost(int $gd): void
    {
        $this->updateStanding(0, 1, 0, 0, $gd * -1);
    }

    public function draw(): void
    {
        $this->updateStanding(0, 0, 1, 1);
    }

    private function updateStanding ($won, $lost, $draw, $points, $goal_difference = 0) {
        /** @var Standing $standing */
        $standing = $this->standing->fresh();
        $standing->played += 1;
        $standing->won += $won;
        $standing->lost += $lost;
        $standing->draw += $draw;
        $standing->points += $points;
        $standing->goal_difference += $goal_difference;
        $standing->save();
    }
}
