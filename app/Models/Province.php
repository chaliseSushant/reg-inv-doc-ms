<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory, softDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['districts'];

    protected $fillable = ['name', 'identifier' ];

    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
