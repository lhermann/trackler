<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Label extends Model {

    // assumes table with name `labels`
    // assumes PK with name `id`
    // assumes timestamps `created_at` and `updated_at`

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'domain_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the domain that owns this label.
     */
    public function domain()
    {
        return $this->belongsTo('App\Domain');
    }

    /**
     * Get the hits of this label.
     */
    public function hits()
    {
        return $this->hasMany('App\Hit');
    }
}
