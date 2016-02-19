<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'responsible',
        'email',
        'phone',
        'address',
        'skype',
        'twitter',
        'facebook',
        'google_plus',
        'website',
        'obs'
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}