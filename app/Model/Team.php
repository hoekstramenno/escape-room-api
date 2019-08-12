<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subcamp', 'points', 'number', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        //
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'subcamp' => 'string',
        'number' => 'string',
        'points' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp'
    ];

    /**
     * Get the ApiTokens for the Team.
     */
    public function token()
    {
        return $this->hasOne(ApiToken::class);
    }


    /**
     * Get the Tasks for the Team.
     */
    public function tasks()
    {
        return $this->belongsToMany(Task::class)
            ->withPivot('is_done')
            ->withTimestamps();
    }

}
