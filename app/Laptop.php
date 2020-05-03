<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    protected $fillable = [
        'user_id',
        'brand',
        'model',
        'year',
        'cpuBrand',
        'cpuModel',
        'cpuCores',
        'cpuFrequency',
        'ramSize',
        'storage1',
        'storage2',
        'os',
        'damage',
        'price',
        'description',
    ];

    // protected $guarded = []; mass assignment for all

    protected $casts = [
        'storage1' => 'array',
        'storage2' => 'array',
    ];

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
