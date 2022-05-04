<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Fixture
 *
 * @property int $id
 * @property int $week_number
 * @property int $home_team_id
 * @property int $away_team_id
 * @property int|null $home_goal
 * @property int|null $away_goal
 * @property int|null $winner_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $awayTeam
 * @property-read \App\Models\Team $homeTeam
 * @property-read \App\Models\Team|null $winnerTeam
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereAwayGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereAwayTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereHomeGoal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereHomeTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereWeekNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fixture whereWinnerId($value)
 */
	class Fixture extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Standing
 *
 * @property int $id
 * @property int $team_id
 * @property int $played
 * @property int $won
 * @property int $draw
 * @property int $lost
 * @property int $goal_difference
 * @property int $points
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Team $team
 * @method static \Illuminate\Database\Eloquent\Builder|Standing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Standing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Standing query()
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereDraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereGoalDifference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereLost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing wherePlayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing wherePoints($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Standing whereWon($value)
 */
	class Standing extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Team
 *
 * @property int $id
 * @property string $name
 * @property int $power
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Standing|null $standing
 * @method static \Illuminate\Database\Eloquent\Builder|Team newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Team query()
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team wherePower($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Team whereUpdatedAt($value)
 */
	class Team extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

