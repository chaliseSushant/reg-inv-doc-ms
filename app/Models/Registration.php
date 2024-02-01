<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Registration extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'sender',
        'medium',
        'registration_number',
        'registration_date',
        'letter_number',
        'invoice_number',
        'invoice_date',
        'user_id',
        'subject',
        'remarks',
        'fiscal_year_id',
        'service_id',
        'complete',
    ];

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function documents()
    {
        return $this->morphToMany(Document::class, 'documentable');
    }

}
