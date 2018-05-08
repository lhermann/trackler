<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domain extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the events of this domain.
     */
    public function events()
    {
        return $this->hasMany('App\Event');
    }
}
