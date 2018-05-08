<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hit extends Model {

    // assumes table with name `labels`
    // assumes PK with name `id`
    // assumes timestamps `created_at` and `updated_at`

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'label_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the label that owns this hit.
     */
    public function label()
    {
        return $this->belongsTo('App\Label');
    }
}
