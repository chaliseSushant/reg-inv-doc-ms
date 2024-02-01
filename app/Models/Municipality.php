<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Municipality extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['identifier' , 'name' , 'district_id'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

}
