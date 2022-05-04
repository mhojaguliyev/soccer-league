<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('week_number')->orderBy('id');
    }

    public function scopePlayed($query)
    {
        return $query->where('status', true);
    }

    public function scopeNotPlayed($query)
    {
        return $query->where('status', false);
    }

    public function awayTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    public function homeTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function winnerTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'winner_id');
    }
}
