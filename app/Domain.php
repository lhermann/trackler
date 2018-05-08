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
     * Get the labels of this domain.
     */
    public function labels()
    {
        return $this->hasMany('App\Label');
    }
}
