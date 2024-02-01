<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
/*use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;*/
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    /*use HasProfilePhoto;
    use TwoFactorAuthenticatable;*/

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    /*protected $appends = [
        'profile_photo_url',
    ];*/

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    /*public function receivesBroadcastNotificationsOn()
    {
        return 'App.User.' . $this->id;
    }*/

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    /*public function assignable()
    {
        return $this->morphMany(Assign::class, 'assign');
    }*/
    /**
     * Get all of the documents for the user.
     */
    public function documents()
    {
        return $this->morphToMany(Document::class, 'assignable')->withTimestamps()->withPivot(['user_id', 'remarks','created_at','updated_at', 'approved_at', 'disapproved_at']);
    }
    /*public function allDocuments()
    {
        $document_ids = array();
        $user_id = $this->id;
        $department_id = $this->department->id;
        $user_documents = $this->documents;
                $department_documents = $this->department->documents;
                foreach ($user_documents as $document)
                {
                    if ($document->isAssignedLatest('App\Models\User', $user_id))
                    {
                        $document_ids[] = $document->id;
                    }

                }
                foreach ($department_documents as $document)
                {
                    if ($document->isAssignedLatest('App\Models\Department', $department_id))
                    {
                        $document_ids[] = $document->id;
                    }

                }
                return Document::whereIn('id', array_unique($document_ids))->get();

    }*/

    /*public function allDocuments()
    {
        $document_ids = array_unique(
            array_merge(
                $this->documents()->pluck('document_id')->toArray(),
                $this->department->documents()->pluck('document_id')->toArray())
        );
        return Document::whereIn('id', $document_ids)->get();
    }*/
    /*public function allDocuments()
    {   $document_ids = array();
        $user_id = $this->id;
        $department_id = $this->department->id;
        $documents = Document::

            with(['users' => function ($query) use($user_id){
            $query->orderBy('pivot_created_at','desc');

        },
            'departments' => function ($query)  use($department_id) {
                $query->orderBy('pivot_created_at','desc');
            }

        ])->withCount('users','departments')->orderBy('created_at','desc')
            ->get();
        $result = array();
        foreach ($documents as $document)
        {
            if ($document->users_count != 0 && $document->departments_count != 0)
            {
                if ($document->users->first()->pivot->created_at > $document->departments->first()->pivot->created_at)
                {
                    if ($document->users->first()->id == $user_id)
                    {
                        array_push($result, $document);
                    }
                }
                else
                {
                    if ($document->departments->first()->id == $department_id)
                    {
                        array_push($result, $document);
                    }
                }
            }
            elseif ($document->departments_count != 0)
            {
                if ($document->departments->first()->id == $department_id)
                {
                    array_push($result, $document);
                }
            }
            elseif ($document->users_count != 0)
            {
                if ($document->users->first()->id == $user_id)
                {
                    array_push($result, $document);
                }
            }
        }
        return $result;


    }*/
    public function allDocumentsIds($from = null, $to = null)
    {   $from = $from != null ? $from : Carbon::now()->subMonth();
        $to = $to != null ? $to : Carbon::now();
        $document_ids = array();
        $user_id = $this->id;
        $department_id = $this->department->id;
        $documents = Document::
        /* whereBetween('created_at',[$from,$to])*/
        with(['users' => function ($query){
            $query->orderBy('pivot_created_at','desc');

        },
            'departments' => function ($query){
                $query->orderBy('pivot_created_at','desc');
            }

        ])->withCount('users','departments')->orderBy('created_at','desc')
            ->lazy(1000);
        //dd($documents);
        $result = array();
        foreach ($documents as $document)
        {
            //dd($document);
            if ($document->users_count != 0 && $document->departments_count != 0)
            {
                if ($document->users->first()->pivot->created_at > $document->departments->first()->pivot->created_at)
                {
                    if ($document->users->first()->id == $user_id)
                    {
                        array_push($result, $document->id);
                    }
                }
                else
                {
                    if ($document->departments->first()->id == $department_id)
                    {
                        array_push($result, $document->id);
                    }
                }
            }
            elseif ($document->departments_count != 0)
            {
                if ($document->departments->first()->id == $department_id)
                {
                    array_push($result, $document->id);
                }
            }
            elseif ($document->users_count != 0)
            {
                if ($document->users->first()->id == $user_id)
                {
                    array_push($result, $document->id);
                }
            }
        }

        return array_unique($result);
    }

    public function allDocuments($paginator, $from = null, $to = null)
    {
        $document_ids = $this->allDocumentsIds($from,$to);

        return count($document_ids) == 0 ? null : Document::orderBy('created_at', 'DESC')->whereIn('id',$document_ids)->paginate($paginator);
    }

    public function allRegistrations($paginator, $from = null, $to = null)
    {
        $documents = Document::orderBy('created_at', 'DESC')->whereIn('id', $this->allDocumentsIds($from,$to))->with('registrations')->get();
        $registration_ids = array();
        foreach ($documents as $document)
        {
            foreach ($document->registrations as $registration)
            {
                array_push($registration_ids, $registration->id);
            }
        }

        return count($registration_ids) == 0 ? null : Registration::orderBy('created_at', 'DESC')->whereIn('id', $registration_ids)->paginate($paginator);
    }

    public function hasPrivilege($identifier,$crud)
    {
        return $this->role->hasPrivilege($identifier,$crud);
    }
    public function isInDepartment($department_identifier)
    {
        if ($this->department->identifier == $department_identifier)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
