<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'interconnect', 'identifier'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    /*public function assignable()
    {
        return $this->morphMany(Assign::class, 'assignable');
    }*/
    /**
     * Get all of the documents for the department.
     */
    public function documents()
    {
        return $this->morphToMany(Document::class, 'assignable')->withTimestamps()
            ->withPivot(['user_id', 'remarks','user_id','created_at','updated_at','approved_at', 'disapproved_at']);
    }
}
