<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'task',
        'location',
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
        'number'     => 'integer',
        'task'       => 'string',
        'location'   => 'string',
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
    ];

    /**
     * Get the Teams for the Task.
     */
    public function teams()
    {
        return $this->belongsToMany(\App\Model\Team::class)
                    ->withPivot('is_done')
                    ->withTimestamps();
    }

    public function scopeIsDone($query)
    {
        return $query->whereHas('productionOrders', function ($query) {
            $query->where('deadline_date', '<', 'finished_date');
        });
    }
}
