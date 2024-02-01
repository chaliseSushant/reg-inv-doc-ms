<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['municipalities'];

    protected $fillable = [ 'identifier' , 'name' , 'province_id'];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
