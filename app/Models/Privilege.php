<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Privilege extends Model
{
    use HasFactory;

    protected $fillable = ['identifier', 'name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


}