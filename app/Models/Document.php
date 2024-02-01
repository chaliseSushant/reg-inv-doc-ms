<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'document_number', 'remarks', 'attribute','fiscal_year_id'];

    /**
     * Get all of the registrations that are assigned this document.
     */
    public function registrations()
    {
        return $this->morphedByMany(Registration::class, 'documentable');
    }
    /**
     * Get all of the invoices that are assigned this document.
     */
    public function invoices()
    {
        return $this->morphedByMany(Invoice::class, 'documentable');
    }
    public function files()
    {
        return $this->hasMany(File::class);
    }
    /**
     * Get all of the departments that are assigned this document.
     */
    public function departments()
    {
        return $this->morphedByMany(Department::class, 'assignable')->withTimestamps()->withPivot(
            ['remarks','user_id','approved_at','disapproved_at','created_at','updated_at']);
    }
    /**
     * Get all of the users that are assigned this document.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'assignable')->withTimestamps()->withPivot(
            ['remarks','user_id','approved_at','disapproved_at','created_at','updated_at']);
    }

    public function getAssignsAttribute()
    {
        $result = collect([]);
        $users = $this->users;
        $departments = $this->departments;
        foreach ($users as $user)
        {
            $result = $result->push($user);
        }
        foreach ($departments as $department)
        {
            $result = $result->push($department);
        }
        return $result;
    }
    public function isAssignedLatest($assignable_type, $assignable_id)
    {
        $latest = $this->getAssignsAttribute()->sortByDesc('pivot.created_at')->first();
        if ($latest->pivot->assignable_type == $assignable_type && $latest->pivot->assignable_id == $assignable_id)
        {
            return true;
        }
        else return false;
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function getUrgencyAttribute()
    {
        switch (explode('-',$this->attribute)[0]) {
            case '1':
                return 'Important';
            case '2':
                return 'Very Important';
            case '3':
                return 'Urgent';
            default:
                return 'None';
        }
    }

    public function getSecrecyAttribute()
    {
        switch (explode('-',$this->attribute)[1]) {
            case '1':
                return 'Confidential';
            case '2':
                return 'Top Secret';
            default:
                return 'None';
        }
    }

    /*public function assigns()
    {
        return $this->hasMany(Assign::class);
    }*/
    /*public function assigned_to_user($user_id)
    {
        return  $this->assigns->where('assign_type','App\Models\User')->where('assign_id',$user_id)->first() ? true : false;
    }
    public function assigned_to_department($department_id)
    {
        return $this->assigns->where('assign_type','App\Models\Department')->where('assign_id',$department_id)->first() ? true : false;
    }*/
    /*public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    public function registration()
    {
        return $this->hasOne(Registration::class);
    }*/
}
