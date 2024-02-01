<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number',
        'sender',
        'receiver',
        'subject',
        'fiscal_year_id',
        'attender_book_number',
        'remarks',
        'medium',
        'invoice_datetime'];

    public function documents()
    {
        return $this->morphToMany(Document::class, 'documentable');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class);
    }

}
