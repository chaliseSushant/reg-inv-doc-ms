<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'name'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    public function revisions()
    {
        return $this->hasMany(Revision::class);
    }
    public function latest_revision()
    {
        //dd($this->hasOne(Revision::class)->latest());
        return $this->hasOne(Revision::class)->with('user')->latest();
    }
}
