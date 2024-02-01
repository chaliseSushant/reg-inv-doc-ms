<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['users'];

    protected $fillable = ['role', 'title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function privileges()
    {
        return $this->belongsToMany(Privilege::class)->withPivot('crud');
    }

    public function hasPrivilege($privilege_identifier,$code)
    {
        if ($this->privileges->where('identifier',$privilege_identifier)->count() != 0)
        {
            $requires = str_split($code);
            $crud_granted = str_split($this->privileges->where('identifier',$privilege_identifier)->first()->pivot->crud);

            if($crud_granted[array_search("1", $requires)] == '1'){
              return true;
            }
            else return false;

        }
        return false;
    }

}
