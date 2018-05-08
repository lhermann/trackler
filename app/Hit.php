<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model {

    // assumes table with name `hits`
    // assumes PK with name `id`
    // assumes timestamps `created_at` and `updated_at`

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the event that owns this hit.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
}
