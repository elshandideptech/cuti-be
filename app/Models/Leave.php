<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Leave extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id_language',
        'id_parent',
        'title',
        'description'
    ];

    public function language(){
        return $this->belongsTo(Language::class, 'id_language');
    }
}
