<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    /**
     * Get the user that owns the post.
     */
    public function user()
    {
        return $this->belongsTo('App\User')/*->withDefault([
            'name' => 'Guest Author',
        ])*/;
    }
}
